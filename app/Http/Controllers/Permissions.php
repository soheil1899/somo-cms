<?php


namespace App\Http\Controllers;


trait Permissions
{

    public function getpermission($roles)
    {
        $per = array();
//        $roles = auth()->user()->roles()->get();
        $permissions = array();
        foreach ($roles as $role){
            array_push($permissions, $role->permissions()->get());
        }
        for ($i=0; $i<count($permissions); $i++){
            for($j=0; $j<count($permissions[$i]);$j++){
                array_push($per, $permissions[$i][$j]['permission']);
            }
        }

        return $per;
    }

}