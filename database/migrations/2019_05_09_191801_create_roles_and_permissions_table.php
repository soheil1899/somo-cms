<?php

use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesAndPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('role')->nullable();
            $table->integer('ordered')->default(1);
            $table->timestamps();
        });

        DB::table('roles')->insert(
            array(
                'title' => 'مدیر ارشد',
                'role' => 'superadmin',
                'ordered' => 1,
                'created_at' => Date::now(),
            )
        );
        DB::table('roles')->insert(
            array(
                'title' => 'کاربر معمولی',
                'role' => 'user',
                'ordered' => 2,
                'created_at' => Date::now(),
            )
        );









        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('permission')->nullable();
            $table->timestamps();
        });


        DB::table('permissions')->insert(
            array(
                'title' => 'حذف کاربر',
                'permission' => 'delete_user',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'ویرایش کاربر',
                'permission' => 'edit_user',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'افزودن کاربر',
                'permission' => 'add_user',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'حذف محصول',
                'permission' => 'delete_product',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'افزودن محصول',
                'permission' => 'add_product',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'ویرایش محصول',
                'permission' => 'edit_product',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'افزودن مطلب',
                'permission' => 'add_article',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'حذف مطلب',
                'permission' => 'delete_article',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'ویرایش مطلب',
                'permission' => 'edit_article',
                'created_at' => Date::now(),
            )
        );
        DB::table('permissions')->insert(
            array(
                'title' => 'دسترسی ها',
                'permission' => 'permission_access',
                'created_at' => Date::now(),
            )
        );










        Schema::create('permission_role', function (Blueprint $table) {
            $table->bigInteger('permission_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });


        DB::table('permission_role')->insert(
            array(
                'permission_id' => '1',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '2',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '3',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '4',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '5',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '6',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '7',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '8',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '9',
                'role_id' => '1',
            )
        );
        DB::table('permission_role')->insert(
            array(
                'permission_id' => '10',
                'role_id' => '1',
            )
        );












        Schema::create('role_user', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });


        DB::table('role_user')->insert(
            array(
                'role_id' => '1',
                'user_id' => '1',
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
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
}
