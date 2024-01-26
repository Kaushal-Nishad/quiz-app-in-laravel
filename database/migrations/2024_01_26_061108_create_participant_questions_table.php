<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participant_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->integer('participant_id');
            $table->integer('question_id');
            $table->integer('correct_choice');
            $table->integer('student_answer');
            $table->integer('is_correct');
            $table->string('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_questions');
    }
};
