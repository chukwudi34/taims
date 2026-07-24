<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_class_id')->constrained('live_classes');
            $table->uuid('student_id');
            $table->foreign('student_id')->references('id')->on('users');
            $table->enum('status', ['present', 'absent', 'excused'])->default('present');
            $table->uuid('marked_by');
            $table->foreign('marked_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_records');
    }
};
