<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Article_group;
use App\Models\Menu;
use App\Models\Menu_group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.menugroup');
    }
    public function getmenugroups()
    {
        return Menu_group::all();
    }
    public function getmenus()
    {
        $articlegroups = Article_group::all();
        $articles = Article::all();
        $menus = Menu::where('parent_id',0)->get();
        return [$menus, $articlegroups, $articles];
    }
    public function getsubmenus(Request $request)
    {
        return Menu::where('parent_id', $request->parentid)->get();
    }
}
