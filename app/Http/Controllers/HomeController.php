<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Comment;
use App\Models\Komen;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {

        return view('index')->with([
            'menu' => Menu::all(),
            'populer' =>  Menu::where('populer', 1)->get(),
            'reviews' => Komen::all(),
        ]);
    }
}
