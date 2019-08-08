<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brand');
    }
    public function getbrands()
    {

        return Brand::all();
    }
    public function savebrand(Request $request)
    {
        $this->validate($request, [
            'brand' => 'required',
        ]);

        if ($request->editflag != false) {
            $save = Brand::where('id', $request->brandid)->first();
        } else {
            $save = new Brand();
        }

        $save->name = $request->brand;
        $save->description = $request->description;
        $save->save();
    }


}
