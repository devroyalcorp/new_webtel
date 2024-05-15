<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if($data){
            return response()->json(['status' => 202, 'msg' => "Berhasil Login!", 'title' => 'Berhasil!', 'type' => 'success']);
        }else{
            return response()->json(['status' => 500, 'msg' => "Username atau Password Salah !", 'title' => 'Gagal!', 'type' => 'error']);
        }
    }
}
