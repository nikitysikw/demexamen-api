<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VideoCategory extends Migration
{
    public function up()
    {
        Schema::create('video_categorys', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_categorys');
    }
}
