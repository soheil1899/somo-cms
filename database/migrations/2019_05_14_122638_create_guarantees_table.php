<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('companyname');
            $table->string('time');
            $table->string('label');
            $table->string('description')->nullable();
            $table->timestamps();
        });


        Schema::create('guarantee_product', function (Blueprint $table) {
            $table->bigInteger('guarantee_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();

            $table->foreign('guarantee_id')->references('id')->on('guarantees')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guarantee_product');
        Schema::dropIfExists('guarantees');
    }
}
