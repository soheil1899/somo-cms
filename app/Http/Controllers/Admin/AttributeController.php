<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Subattribute;
use App\Subattribute_value;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index()
    {
        return view('admin.attribute');
    }


    public function getattribute()
    {
        return Attribute::all();
    }


    public function saveattribute(Request $request)
    {
        $this->validate($request,[
            'attribute' => 'required',
        ]);

        if($request->editflag != false){
            if($request->subattr != false){
                $save = Subattribute::where('id', $request->id)->first();
                $save->attribute_id = $request->parentid;
            }else{
                $save = Attribute::where('id', $request->id)->first();
            }
        }else{
            if($request->subattr != false){
                $save = new Subattribute();
                $save->attribute_id = $request->parentid;
            }else{
                $save = new Attribute();
            }
        }

        $save->title = $request->attribute;
        $save->description = $request->description;

        $save->save();
    }

    public function getsubattribute(Request $request)
    {
        return Subattribute::where('attribute_id', $request->parentid)->get();
    }

    public function savesubattributevalue(Request $request)
    {

        $subattrvalues = $request->subattrvalues;

        for ($i=0; $i < count($request->subattrvalues) ; $i++) {
            unset($subattrvalues[$i]['id']);

            if ($request->subattrvalues[$i]['value'] == null) {
                unset($subattrvalues[$i]);
            }
        }// delete form array if title value set null


        Subattribute_value::where('subattribute_id', $request->subattrid)->delete();
        if(count($subattrvalues) > 0) {
            Subattribute_value::insert($subattrvalues);
        }


    }

    
    public function deletesubattribute(Request $request)
    {
        return Subattribute::where('id', $request->id)->delete();
    }

    
    public function getsubvalue(Request $request)
    {
        return Subattribute_value::where('subattribute_id', $request->id)->get();
    }

    
    


}
