<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $tittle = "Home";
        return view('home', compact('tittle'));
    }
}
