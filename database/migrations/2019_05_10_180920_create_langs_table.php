<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('langs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('lang');
            $table->timestamps();
        });

        DB::table('langs')->insert(
            array(
                'title' => 'فارسی',
                'lang' => 'fa',
            )
        );
        DB::table('langs')->insert(
            array(
                'title' => 'english',
                'lang' => 'en',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('langs');
    }
}
