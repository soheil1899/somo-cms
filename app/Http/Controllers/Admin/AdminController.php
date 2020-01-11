<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Permissions;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use Permissions;


    public function index()
    {

        $useraccess = 0;
        $storeaccess = 0;
        $writeraccess = 0;

        $per = $this->getpermission(auth()->user()->roles()->get());

        for ($i = 0; $i < count($per); $i++) {
            if ($per[$i] == 'add_user' or $per[$i] == 'edit_user' or $per[$i] == 'delete_user') {
                $useraccess = 1;
            }
            if ($per[$i] == 'add_article' or $per[$i] == 'edit_article' or $per[$i] == 'delete_article') {
                $writeraccess = 1;
            }
            if ($per[$i] == 'add_product' or $per[$i] == 'edit_product' or $per[$i] == 'delete_product') {
                $storeaccess = 1;
            }

        }

        return view('admin.dashboard', compact('useraccess', 'storeaccess', 'writeraccess'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'oldpass' => 'required|min:8',
            'newpass' => 'required|min:8',
            'repass' => 'required|min:8',
        ]);
        if (Hash::check($request->oldpass, auth()->user()->password)) {
            if ($request->newpass == $request->repass) {
                $save = User::where('id', auth()->user()->id)->first();

                $save->name = $request->name;
                $save->email = $request->email;
                $save->password = bcrypt($request->newpass);

                $save->save();

                $action = 'true';
                return $action;
            } else {
                return 'foo';
            }
        } else {
            return 'bar';
        }


    }


    public function superadmininfo()
    {
        $id = 1;
        return view('admin.userinfo', compact('id'));
    }







}
