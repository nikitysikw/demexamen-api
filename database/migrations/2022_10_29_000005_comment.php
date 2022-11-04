<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comment extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('video_id')->constrained('videos');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('time_create')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
