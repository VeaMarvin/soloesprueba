<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nit');
            $table->string('name_complete',250);
            $table->string('email',250);
            $table->string('direction',250);
            $table->string('phone');
            $table->string('status')->default('PEDIDO');
            $table->string('type_payment')->nullable();
            $table->text('observation')->nullable();
            $table->decimal('total', 10,2)->default(0);
            $table->boolean('sold')->default(false);
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('employee_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
