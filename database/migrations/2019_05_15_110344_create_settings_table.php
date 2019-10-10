<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mobile')->nullable();
            $table->string('lang');
            $table->string('tellphone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->text('aboutus')->nullable();
            $table->string('company_name')->nullable();

            $table->string('site_title')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->string('googleplus')->nullable();
            $table->string('whatsup')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('googlemap')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('aparat')->nullable();

            $table->string('flag')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('header_description')->nullable();
            $table->boolean('catalog')->default(false);
            $table->timestamps();
        });


        DB::table('settings')->insert(
            array(
                'lang' => 'fa',
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
        Schema::dropIfExists('settings');
    }
}
