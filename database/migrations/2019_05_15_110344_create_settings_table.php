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
            $table->text('aboutus_all')->nullable();
            $table->string('company_name')->nullable();
            $table->string('flag')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('header_description')->nullable();
            $table->boolean('catalog')->default(false);
            $table->timestamps();
        });


        DB::table('settings')->insert(
            array(
                'lang' => 'fa',
                'mobile' => '0903',
                'tellphone' => '0113',
                'fax' => '0113',
                'email' => 'a@a.com',
                'address' => 'تست',
                'aboutus' => 'تست',
                'aboutus_all' => 'تست',
                'company_name' => 'تست',
                'flag' => 'تست',
                'header_description' => 'تست',
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
