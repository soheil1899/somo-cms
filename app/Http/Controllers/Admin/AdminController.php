<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\User;
use App\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
        return view('admin.myinfo');
    }

    public function getmyinfos(Request $request)
    {
        return auth()->user();
    }


    public function savemyinfo(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'oldpass' => 'required|min:8',
            'newpass' => 'required|min:8',
            'repass' => 'required|min:8',
        ]);
        if(Hash::check($request->oldpass, auth()->user()->password))
        {
            if ($request->newpass == $request->repass) {
                $save = User::where('id', auth()->user()->id)->first();

                $save->name = $request->name;
                $save->email = $request->email;
                $save->password = bcrypt($request->newpass);

                $save->save();

                $action = 'true';
                return $action;
            }else{
                return 'foo';
            }
        }else{
            return 'bar';
        }





    }





}
