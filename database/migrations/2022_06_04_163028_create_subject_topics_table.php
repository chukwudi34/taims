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
        Schema::create('subject_topics', function (Blueprint $table) {
            $table->id();
            $table->string('topic_name')->nullable();
            $table->mediumText('description')->nullable();
            $table->foreignId('subject_id')->nullable()->references('id')->on('subjects');;
            $table->enum('status', ['pending', 'approved', 'declined'])->default('approved');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('subject_topics');
    }
};
