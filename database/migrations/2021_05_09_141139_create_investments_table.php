<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('plan_id')->unsigned();
            $table->integer('unit');
            $table->integer('pay_date')->nullable();
            $table->json('plan_meta')->nullable();
            $table->float('roi');
            $table->string('amount');
            $table->string('withdraw_amount')->nullable();
            $table->integer('duration');
            $table->enum('duration_type', ['year', 'month', 'day', 'week'])->default('month');
            $table->enum('status', ['created', 'paid', 'active', 'completed', 'archived'])->default('created');
            $table->date('activated_on')->nullable();
            $table->date('completed_on')->nullable();
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
        Schema::dropIfExists('investments');
    }
}
