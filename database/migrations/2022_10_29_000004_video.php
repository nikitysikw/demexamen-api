<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Video extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);
            $table->text('title');
            $table->text('body')->nullable();
            $table->timestamp('time_create')->useCurrent();
            $table->string('name_file');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('video_status_id')->default(1)->constrained('video_status');
            $table->foreignId('video_category_id')->constrained('video_categorys');
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
