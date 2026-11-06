<?php

namespace Tests\Feature;

use App\Models\QuizScore;
use App\Models\User;
use Database\Seeders\QuizQuestionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_the_career_and_leaderboard(): void
    {
        $this->seed(QuizQuestionSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Do Brasil')
            ->assertSee('Hall da')
            ->assertSee('Você sabe');
    }

    public function test_quiz_answers_are_checked_on_the_server_and_score_can_be_saved(): void
    {
        $this->seed(QuizQuestionSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user);

        $start = $this->postJson(route('quiz.start'), ['difficulty' => 'facil'])
            ->assertOk()
            ->assertJsonMissingPath('question.answer');

        $firstQuestion = $this->app['session.store']->get('quiz')['questions'][0];
        $start->assertJsonPath('question.question', $firstQuestion['question']);

        for ($index = 0; $index < 5; $index++) {
            $quiz = $this->app['session.store']->get('quiz');
            $question = $quiz['questions'][$quiz['current']];

            $response = $this->postJson(route('quiz.answer'), [
                'index' => $index,
                'option' => $question['answer'],
            ])->assertOk();

            if ($index === 4) {
                $response->assertJsonPath('complete', true)
                    ->assertJsonPath('result.correct', 5)
                    ->assertJsonPath('result.total', 5);
            }
        }

        $this->postJson(route('quiz.score'), [])
            ->assertCreated()
            ->assertJsonPath('entry.name', $user->name)
            ->assertJsonPath('entry.correct_answers', 5);

        $this->assertDatabaseHas('quiz_scores', [
            'user_id' => $user->id,
            'email' => $user->email,
            'correct_answers' => 5,
            'difficulty' => 'facil',
        ]);
        $this->assertSame(1, QuizScore::count());

        $this->withSession(['quiz_result' => [
            'difficulty' => 'dificil',
            'correct' => 0,
            'total' => 5,
            'score' => 0,
        ]])->postJson(route('quiz.score'), [])->assertCreated();

        $this->assertSame(1, QuizScore::where('user_id', $user->id)->count());
        $this->assertSame(5, QuizScore::where('user_id', $user->id)->value('correct_answers'));
        $this->getJson(route('quiz.leaderboard'))
            ->assertOk()
            ->assertJsonCount(1, 'leaders')
            ->assertJsonPath('leaders.0.name', $user->name);
    }

    public function test_a_score_cannot_be_saved_without_finishing_a_quiz(): void
    {
        $this->actingAs(User::factory()->create())
            ->postJson(route('quiz.score'), [])
            ->assertConflict();

        $this->assertDatabaseCount('quiz_scores', 0);
    }

    public function test_guests_cannot_start_or_answer_a_quiz(): void
    {
        $this->postJson(route('quiz.start'), ['difficulty' => 'facil'])->assertUnauthorized();
        $this->postJson(route('quiz.answer'), ['index' => 0, 'option' => 0])->assertUnauthorized();
    }

    public function test_the_server_rejects_an_answer_after_the_timer_expires(): void
    {
        $this->seed(QuizQuestionSeeder::class);
        $this->actingAs(User::factory()->create());
        $this->postJson(route('quiz.start'), ['difficulty' => 'facil'])->assertOk();

        $quiz = $this->app['session.store']->get('quiz');
        $question = $quiz['questions'][0];
        $quiz['question_started_at'] = microtime(true) - 16;

        $this->withSession(['quiz' => $quiz])
            ->postJson(route('quiz.answer'), [
                'index' => 0,
                'option' => $question['answer'],
            ])->assertOk()
            ->assertJsonPath('correct', false)
            ->assertJsonPath('points', 0);
    }
}
