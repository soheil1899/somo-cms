<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.tag');
    }
    public function gettags()
    {
        return Tag::all();
    }
    public function savetag(Request $request)
    {
        $this->validate($request, [
            'tag' => 'required',
        ]);

        if ($request->editflag != false) {
            $save = Tag::where('id', $request->tagid)->first();
        } else {
            $save = new Tag();
        }

        $save->tag = $request->tag;
        $save->save();
    }

}
