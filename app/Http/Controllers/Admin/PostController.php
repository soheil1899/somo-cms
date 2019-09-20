<?php

namespace App\Http\Controllers\Admin;

use App\Contactus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Comment;

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
