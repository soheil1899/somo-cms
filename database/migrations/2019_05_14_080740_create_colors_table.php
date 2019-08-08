<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('hexcode');
            $table->timestamps();
        });


        Schema::create('color_product', function (Blueprint $table) {
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();

            $table->foreign('color_id')->references('id')->on('colors')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_product');
        Schema::dropIfExists('colors');
    }
}
