<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VideoStatus extends Migration
{
    public function up()
    {
        Schema::create('video_status', function (Blueprint $table) {
            $table->id();
            $table->string('name', 35)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_status');
    }
}
