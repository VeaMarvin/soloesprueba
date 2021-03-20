<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_credits', function (Blueprint $table) {
            $table->id();
            $table->date('date_start');
            $table->date('date_end');
            $table->decimal('total',11,2);
            $table->boolean('payment')->default(false);

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->unsignedBigInteger('credit_id');
            $table->foreign('credit_id')->references('id')->on('credits');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->boolean('current')->default(true);
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
        Schema::dropIfExists('request_credits');
    }
}
