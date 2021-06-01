<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amount');
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('meta');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->integer('duration');
            $table->enum('duration_type', ['year', 'month', 'day', 'week'])->default('month');
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
        Schema::dropIfExists('plans');
    }
}
