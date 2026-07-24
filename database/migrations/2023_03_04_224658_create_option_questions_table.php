<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->references('id')->on('options');
            $table->foreignId('question_id')->references('id')->on('questions');
            $table->foreignId('quiz_id')->references('id')->on('quizzes');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_questions');
    }
};
