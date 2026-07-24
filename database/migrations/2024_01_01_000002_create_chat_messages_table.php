<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('sender_id');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->uuid('receiver_id');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index('sender_id');
            $table->index('receiver_id');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
};
