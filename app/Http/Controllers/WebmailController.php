<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebmailController extends Controller
{
    public function index()
    {
        return view('webmail.index');
    }
}
