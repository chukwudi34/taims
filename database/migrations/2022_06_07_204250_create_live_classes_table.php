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
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->references('id')->on('subjects');
            $table->foreignId('topic_id')->references('id')->on('subject_topics');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('time_duration');
            $table->foreignId('class_id')->references('id')->on('classes');
            $table->enum('status', ['expired', 'ongoing', 'not_started'])->default('not_started');
            $table->string('meeting_url');
            $table->string('total_participant')->nullable();
            $table->json('participants')->nullable();
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
        Schema::dropIfExists('live_classes');
    }
};
