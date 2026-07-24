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
        Schema::create('quiz_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->references('id')->on('classes');
            $table->foreignId('subject_id')->references('id')->on('subjects');
            $table->foreignId('topic_id')->references('id')->on('subject_topics');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->enum('status', ['approved', 'pending', 'disapproved'])->default('approved');
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
        Schema::dropIfExists('quiz_categories');
    }
};
