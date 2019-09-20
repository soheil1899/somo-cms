<?php

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('url')->unique();
            $table->text('description')->nullable();
            $table->bigInteger('lang_id')->unsigned();
            $table->timestamps();
        });



        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('image')->default(false);
            $table->string('url')->unique();
            $table->text('description')->nullable();
            $table->text('minitext')->nullable();
            $table->boolean('publish')->default(false);
            $table->string('articlevideo')->nullable();
            $table->integer('ordered')->default(0);
            $table->string('reference')->nullable();
            $table->bigInteger('article_group_id')->unsigned();
            $table->timestamps();

            $table->foreign('article_group_id')->references('id')->on('article_groups')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });




        Schema::create('article_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->timestamps();

        });
        DB::table('article_types')->insert(
            array(
                'type' => 'عنوان',
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );
        DB::table('article_types')->insert(
            array(
                'type' => 'متن',
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );
        DB::table('article_types')->insert(
            array(
                'type' => 'تصویر',
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            )
        );




        Schema::create('article_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text')->nullable();
            $table->integer('ordered')->default(0);
            $table->boolean('publish')->default(true);
            $table->bigInteger('article_id')->unsigned();
            $table->integer('col')->default(1);
            $table->bigInteger('article_type_id')->unsigned();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('article_type_id')->references('id')->on('article_types')
                ->onDelete('cascade')->onUpdate('cascade');
        });



        Schema::create('keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keyword')->nullable();
            $table->bigInteger('article_id')->unsigned()->nullable();
            $table->bigInteger('article_group_id')->unsigned()->nullable();
            $table->boolean('setting')->default(false);
            $table->bigInteger('setting_id')->unsigned()->default(1);
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('article_group_id')->references('id')->on('article_groups')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('setting_id')->references('id')->on('settings')
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
        Schema::dropIfExists('keywords');
        Schema::dropIfExists('article_contents');
        Schema::dropIfExists('article_types');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_groups');
    }
}
