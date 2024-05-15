<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        Session::put('login_status', true);
        if($data){
            return response()->json(['status' => 202, 'msg' => "Login Succesfully!", 'title' => 'Berhasil!', 'type' => 'success']);
        }else{
            return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Gagal!', 'type' => 'error']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
