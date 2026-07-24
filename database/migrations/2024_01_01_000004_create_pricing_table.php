<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pricing', function (Blueprint $table) {
            $table->id();
            $table->string('item_type'); // class, video, live_class, quiz
            $table->unsignedBigInteger('item_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('NGN');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['item_type', 'item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pricing');
    }
};
