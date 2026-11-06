<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_scores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('email', 254);
            $table->unsignedInteger('score');
            $table->unsignedTinyInteger('correct_answers');
            $table->string('difficulty', 10);
            $table->timestamps();

            $table->index(['score', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_scores');
    }
};
