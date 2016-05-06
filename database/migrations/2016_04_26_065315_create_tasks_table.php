<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration
{

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('worker_id');
            $table->string('name');
            $table->string('status');
            $table->string('description');
            $table->integer('sort');
            $table->integer('time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('tasks');
    }
}