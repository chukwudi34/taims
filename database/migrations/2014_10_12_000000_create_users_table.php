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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_type_id')->nullable()->constrained('user_types')->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('lga_id')->nullable()->constrained('state_lgas');
            $table->text('address')->nullable();
            $table->string('meeting_url')->nullable();
            $table->string('parent_email')->nullable();
            $table->foreignId('class_id')->nullable()->references('id')->on('classes');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('region')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
