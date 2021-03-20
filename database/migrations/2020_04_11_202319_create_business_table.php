<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('nit',10)->unique();
            $table->string('name',250);
            $table->string('slogan',250);
            $table->longText('vision');
            $table->longText('mision');
            $table->longText('logotipo');
            $table->string('ubication_x');
            $table->string('ubication_y');
            $table->string('facebook',250);
            $table->string('twitter',250);
            $table->string('instagram',250);
            $table->string('page',250);
            $table->boolean('current')->default(true);
            $table->boolean('system')->default(false);
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
        Schema::dropIfExists('business');
    }
}
