<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebtelController extends Controller
{
    public function index()
    {
        return view('webtel.index');
    }
}
