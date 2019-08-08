<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\User;
use App\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        $roles = auth()->user()->roles()->get();
        $permissions = array();
        foreach ($roles as $role){
            array_push($permissions, $role->permissions()->get());
        }

        $useraccess = 0;
        $storeaccess = 0;
        $writeraccess = 0;

        for ($i=0; $i<count($permissions); $i++){
            for($j=0; $j<count($permissions[$i]);$j++){
                $per = $permissions[$i][$j]['permission'];
                if($per == 'add_user' or $per == 'edit_user' or $per == 'delete_user'){
                    $useraccess = 1;
                }
                if($per == 'add_article' or $per == 'edit_article' or $per == 'delete_article'){
                    $writeraccess = 1;
                }
                if($per == 'add_product' or $per == 'edit_product' or $per == 'delete_product'){
                    $storeaccess = 1;
                }
            }
        }

        return view('admin.dashboard' , compact('useraccess', 'storeaccess', 'writeraccess'));
    }


    public function getpermissions(Request $request)
    {

    }


    public function getmyinfo()
    {
        $userid = auth()->user()->id;
        return view('admin.myinfo', compact('userid'));
    }

    public function getmyinfos(Request $request)
    {
        $user = User::where('id', $request->userid)->first();
        $userinfo = Userinfo::where('user_id', $request->userid)->first();

        $city = file_get_contents("Province.json");
        $city = json_decode($city, true);

        return [$user, $userinfo, $city];
    }

}
