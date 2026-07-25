<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('live_classes', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('meeting_url');
        });
        Schema::table('recorded_videos', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('video_link');
        });
        Schema::table('quizzes', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('live_classes', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('recorded_videos', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
