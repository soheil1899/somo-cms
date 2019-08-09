<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role');
    }

    public function getroles()
    {
        $roles = Role::where('id','>', 2)->with('permissions')->get();

        $permissions = Permission::orderBy('id','asc')->get();

        return [$roles, $permissions];
    }

    public function saverole(Request $request)
    {
        $this->validate($request, [
            'roletitle' => 'required',
        ]);

        if ($request->editflag != false) {
            $save = Role::where('id', $request->roleid)->first();
        } else {
            $save = new Role();
        }

        $lastorder = Role::select('ordered')->orderBy('ordered','desc')->limit(1)->get();
        $save->ordered = $lastorder[0]['ordered']+1;
        $save->title = $request->roletitle;
        $save->role = $request->role;
        $save->save();
    }

    public function savepermission(Request $request)
    {
        $accessids = array();
        foreach ($request->accessflag as $key=>$item){
            if($item == true){
                array_push($accessids, $key+1);
            }
        }

        $role = Role::where('id', $request->roleid)->first();
        $role->permissions()->sync($accessids);
    }

    public function deleterole(Request $request)
    {
        Role::where('id', $request->roleid)->delete();
    }



}
