<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use App\Models\QuizScore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    private const QUESTION_TIME = 15;

    public function start(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'difficulty' => ['required', 'in:facil,medio,dificil'],
        ]);

        $questions = QuizQuestion::query()
            ->where('difficulty', $validated['difficulty'])
            ->inRandomOrder()
            ->limit(5)
            ->get()
            ->map(fn (QuizQuestion $question): array => [
                'difficulty' => $question->difficulty,
                'question' => $question->question,
                'choices' => $question->choices,
                'answer' => $question->answer_index,
                'explanation' => $question->explanation,
            ])
            ->all();

        if (count($questions) < 5) {
            return response()->json(['message' => 'Não há perguntas suficientes para este nível. Execute as migrations e os seeders do projeto.'], 503);
        }

        $request->session()->forget('quiz_result');
        $request->session()->put('quiz', [
            'difficulty' => $validated['difficulty'],
            'questions' => $questions,
            'current' => 0,
            'correct' => 0,
            'score' => 0,
            'question_started_at' => microtime(true),
        ]);

        return response()->json(['question' => $this->questionPayload($questions[0], 0)]);
    }

    public function answer(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'index' => ['required', 'integer', 'min:0'],
            'option' => ['nullable', 'integer', 'between:0,3'],
        ])->validate();

        $quiz = $request->session()->get('quiz');
        if (! is_array($quiz) || $validated['index'] !== $quiz['current']) {
            return response()->json(['message' => 'Esta pergunta não está mais ativa. Inicie um novo quiz.'], 409);
        }

        $currentQuestion = $quiz['questions'][$quiz['current']];
        $elapsed = microtime(true) - $quiz['question_started_at'];
        $option = isset($validated['option']) && $elapsed < self::QUESTION_TIME
            ? (int) $validated['option']
            : null;
        $isCorrect = $option !== null && $option === $currentQuestion['answer'];
        $difficultyMultiplier = ['facil' => 1, 'medio' => 1.25, 'dificil' => 1.5][$quiz['difficulty']];
        $points = $isCorrect
            ? (int) round((100 + max(0, self::QUESTION_TIME - $elapsed) * 5) * $difficultyMultiplier)
            : 0;

        $quiz['correct'] += (int) $isCorrect;
        $quiz['score'] += $points;
        $response = [
            'correct' => $isCorrect,
            'correct_choice' => $currentQuestion['choices'][$currentQuestion['answer']],
            'explanation' => $currentQuestion['explanation'],
            'points' => $points,
        ];
        $nextIndex = $quiz['current'] + 1;

        if ($nextIndex >= count($quiz['questions'])) {
            $result = [
                'difficulty' => $quiz['difficulty'],
                'correct' => $quiz['correct'],
                'total' => count($quiz['questions']),
                'score' => $quiz['score'],
            ];
            $request->session()->put('quiz_result', $result);
            $request->session()->forget('quiz');

            return response()->json($response + ['complete' => true, 'result' => $result]);
        }

        $quiz['current'] = $nextIndex;
        $quiz['question_started_at'] = microtime(true);
        $request->session()->put('quiz', $quiz);

        return response()->json($response + [
            'complete' => false,
            'question' => $this->questionPayload($quiz['questions'][$nextIndex], $nextIndex),
        ]);
    }

    public function saveScore(Request $request): JsonResponse
    {
        $result = $request->session()->get('quiz_result');
        if (! is_array($result)) {
            return response()->json(['message' => 'Conclua um quiz antes de salvar sua pontuação.'], 409);
        }

        $user = $request->user();
        $entry = DB::transaction(function () use ($user, $result): QuizScore {
            $entry = $user->quizScores()->lockForUpdate()->first();

            if (! $entry) {
                return $user->quizScores()->create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'score' => $result['score'],
                    'correct_answers' => $result['correct'],
                    'difficulty' => $result['difficulty'],
                ]);
            }

            if ($result['score'] > $entry->score) {
                $entry->update([
                    'name' => $user->name,
                    'email' => $user->email,
                    'score' => $result['score'],
                    'correct_answers' => $result['correct'],
                    'difficulty' => $result['difficulty'],
                ]);
            }

            return $entry->refresh();
        });

        $request->session()->forget('quiz_result');

        return response()->json([
            'message' => 'Sua melhor pontuação já está no ranking!',
            'entry' => [
                'user_id' => $entry->user_id,
                'name' => $entry->name,
                'score' => $entry->score,
                'correct_answers' => $entry->correct_answers,
                'difficulty' => $entry->difficulty,
            ],
        ], 201);
    }

    public function leaderboard(): JsonResponse
    {
        return response()->json([
            'leaders' => QuizScore::query()
                ->join('users', 'users.id', '=', 'quiz_scores.user_id')
                ->whereNotNull('quiz_scores.user_id')
                ->whereRaw('quiz_scores.id = (SELECT candidate.id FROM quiz_scores AS candidate WHERE candidate.user_id = quiz_scores.user_id ORDER BY candidate.score DESC, candidate.created_at ASC, candidate.id ASC LIMIT 1)')
                ->orderByDesc('quiz_scores.score')
                ->orderBy('quiz_scores.created_at')
                ->limit(10)
                ->get(['users.id as user_id', 'users.name', 'quiz_scores.score', 'quiz_scores.correct_answers', 'quiz_scores.difficulty']),
        ]);
    }

    private function questionPayload(array $question, int $index): array
    {
        return [
            'index' => $index,
            'total' => 5,
            'difficulty' => $question['difficulty'],
            'question' => $question['question'],
            'choices' => $question['choices'],
            'seconds' => self::QUESTION_TIME,
        ];
    }
}
