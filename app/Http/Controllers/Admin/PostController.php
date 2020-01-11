<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contactus;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.post');
    }

    public function getposts()
    {
        return Contactus::orderBy('id', 'desc')->get();
    }
}
