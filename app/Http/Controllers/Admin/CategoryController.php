<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category');
    }

    public function getcategories()
    {
        return Category::where('parent_id',0)->get();
    }
    
    public function savecategory(Request $request)
    {
        $this->validate($request,[
            'category' => 'required',
        ]);

        if($request->editflag != false){
            $save = Category::where('id', $request->id)->first();
        }else{
            $save = new Category();  
            $save->last = 1 ;
            if($request->parentid != 0){
                Category::where('id', $request->parentid)->update(['last' => 0]);
                // Attribute::Where('category_id', $request->parentid)->delete();
            }
        }

        $save->name = $request->category;
        $save->description = $request->description;
        $save->parent_id = $request->parentid;
        $save->save();
    }

    //Delete category
    /*public function deletecategory(Request $request)
    {   
        if($request->allowdelete == false){
            $chid = Category::where('parent_id', $request->id)->get();
            $attr = Category::where('id', $request->id)->with('attributes')->get();
            if(count($chid) > 0 or count($attr[0]['attributes']) > 0){
                error.abort(422);
            }
            if($request->parentid != 0){
                Category::where('id', $request->parentid)->update(['last' => 1]);
            }
            Category::where('id', $request->id)->delete();
           
        }
        else{
            $chid = Category::where('parent_id', $request->id)->get();
            if(count($chid) > 0){
                $ids = array();
                array_push($ids, $request->id);

                $idsTotal = array();
                array_push($idsTotal, $request->id); 
                $break = true;

                while($break){
                    $childs = $this->findchild($ids);
                    if(count($childs) > 0){
                        $ids = array();
                        foreach($childs as $child){
                            array_push($ids, $child->id);
                            array_push($idsTotal, $child->id);
                        }
                    }
                    if(count($childs) == 0){
                        $break = false;
                    }
                }//end while

                if($request->parentid != 0){
                    Category::where('id', $request->parentid)->update(['last' => 1]);
                }
                Category::whereIn('id', $idsTotal)->delete();
                Attribute::WhereIn('category_id', $idsTotal)->delete();
            }
            else{
                if($request->parentid != 0){
                    Category::where('id', $request->parentid)->update(['last' => 1]);
                }
                Category::where('id', $request->id)->delete();
                Attribute::Where('category_id', $request->id)->delete();
            }
        }
    }

    public static function findchild($ids){
        return Category::whereIn('parent_id', $ids)->get();
    }*/

    public function getsubcategorys(Request $request)
    {
        return Category::where('parent_id', $request->parentid)->get();
    }

    public function getattributegroup(Request $request)
    {
        $all = Attribute::all();
        $forthis = Category::where('id', $request->categoryid)->with('group_attributes')->first();

        return [$all, $forthis];
    }



    public function saveattrgroup(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        
        $groupID = array();
        for ($i=0; $i < count($request->attrgroups); $i++) { 
            array_push($groupID, $request->attrgroups[$i]['id']);
        }

        $category->group_attributes()->sync($groupID);
    }

    




}
