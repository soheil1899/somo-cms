<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubattributesAndProattrTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subattributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->bigInteger('attribute_id')->unsigned();
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')->on('attributes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });


        Schema::create('subattribute_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('subattribute_id')->unsigned();
            $table->string('value');


            $table->foreign('subattribute_id')->references('id')->on('subattributes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });


        Schema::create('product_subattributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('subattribute_id')->unsigned();
            $table->string('value');

            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subattribute_id')->references('id')->on('subattributes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_subattributes');
        Schema::dropIfExists('subattribute_values');
        Schema::dropIfExists('subattributes');

    }
}
