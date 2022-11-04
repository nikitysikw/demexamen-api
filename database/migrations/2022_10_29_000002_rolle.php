<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rolle extends Migration
{
    public function up()
    {
        Schema::create('rolles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 35)->unique();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rolles');
    }
}
