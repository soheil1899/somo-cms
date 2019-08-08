<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Color;

class ColorController extends Controller
{
    public function index(){
        return view('admin.color');
    }

    public function getcolors(){
        return Color::all();
    }

    public function getcolor(Request $request){
        return Color::where('id', $request->id)->first();
    }

    public function savecolor(Request $request){
        $this->validate($request,[
            'colorname' => 'required',
        ]);

        if($request->editflag != false){
            $save = Color::where('id', $request->id)->first();
        }else{
            $save = new Color();
        }

        $save->name = $request->colorname;
        $save->hexcode = $request->hexcode;

        $save->save();
    }

    public function deletecolor(Request $request)
    {
        Color::where('id',$request->id)->delete();
    }
    



    
}
