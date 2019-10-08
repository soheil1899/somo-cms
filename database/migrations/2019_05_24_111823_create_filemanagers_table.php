<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilemanagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filemanagers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('randomnum');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->bigInteger('article_id')->unsigned()->nullable();
            $table->timestamps();


            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('article_id')->references('id')->on('articles')
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
        Schema::dropIfExists('filemanagers');
    }
}
