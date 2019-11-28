<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('parent_id')->unsigned()->default(0);
            $table->bigInteger('article_group_id')->unsigned()->nullable();
            $table->bigInteger('article_id')->unsigned()->nullable();
            $table->bigInteger('menu_group_id')->unsigned()->nullable();
            $table->string('url')->unique();
            $table->timestamps();

            $table->foreign('article_group_id')->references('id')->on('article_groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('article_id')->references('id')->on('articles')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('menu_group_id')->references('id')->on('menu_groups')
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
        Schema::dropIfExists('menus');
    }
}
