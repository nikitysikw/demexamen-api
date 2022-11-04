<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 40)->unique();
            $table->string('email', 255)->unique();
            $table->binary('password');
            $table->string('token', 60);
            $table->foreignId('rolle_id')->default(2)->constrained('rolles');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
