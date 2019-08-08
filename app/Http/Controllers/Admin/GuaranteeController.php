<?php

namespace App\Http\Controllers\Admin;

use App\Guarantee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuaranteeController extends Controller
{
    public function index(){
        return view('admin.guarantee');
    }

    public function getguarantees(){
        return Guarantee::all();
    }

    public function saveguarantee(Request $request)
    {
        $this->validate($request,[
            'companyname' => 'required',
            'time' => 'required | numeric | between:1,360',
        ]);

        if($request->editflag != false){
            $save = Guarantee::where('id', $request->id)->first();
        }else{
            $save = new Guarantee();
        }

        $save->companyname = $request->companyname;
        $save->description = $request->description;
        $save->label = $request->companyname .' ' .$request->time.' ماهه';
        $save->time = $request->time;

        $save->save();
    }
}
