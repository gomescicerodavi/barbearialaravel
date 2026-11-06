<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Models\QuizScore;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $leaders = QuizScore::query()
        ->join('users', 'users.id', '=', 'quiz_scores.user_id')
        ->whereNotNull('quiz_scores.user_id')
        ->whereRaw('quiz_scores.id = (SELECT candidate.id FROM quiz_scores AS candidate WHERE candidate.user_id = quiz_scores.user_id ORDER BY candidate.score DESC, candidate.created_at ASC, candidate.id ASC LIMIT 1)')
        ->orderByDesc('quiz_scores.score')
        ->orderBy('quiz_scores.created_at')
        ->limit(5)
        ->get(['users.id as user_id', 'users.name', 'quiz_scores.score', 'quiz_scores.correct_answers', 'quiz_scores.difficulty']);

    return view('welcome', compact('leaders'));
});

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/answer', [QuizController::class, 'answer'])->name('quiz.answer');
    Route::post('/quiz/score', [QuizController::class, 'saveScore'])->name('quiz.score');
});
Route::get('/quiz/leaderboard', [QuizController::class, 'leaderboard'])->name('quiz.leaderboard');
