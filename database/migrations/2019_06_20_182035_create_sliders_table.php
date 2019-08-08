<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->boolean('publish')->default(false);
            $table->bigInteger('lang_id')->unsigned()->default(1);
            $table->timestamps();

            $table->foreign('lang_id')->references('id')->on('langs')
                ->onUpdate('cascade')->onDelete('cascade');
        });


        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('subtext')->nullable();
            $table->bigInteger('slider_id')->unsigned();
            $table->timestamps();

            $table->foreign('slider_id')->references('id')->on('sliders')
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
        Schema::dropIfExists('images');
        Schema::dropIfExists('sliders');
    }
}
