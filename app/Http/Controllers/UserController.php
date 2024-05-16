<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use LdapRecord\Container as LdapContainer;
use App\Ldap\User as LdapUser;
use App\Models\Companies;

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
        $ldapUser = LdapUser::findByOrFail('samaccountname', $data['username']);

        if($ldapUser){
            $companies = Companies::get();
            $data_companies = null;
            foreach($companies as $key=>$val){
                if(strtoupper ($val['name']) == $ldapUser['company'][0]){
                    $data_companies = $val;
                    break;
                }
            }
            
            Session::put('login_status', true);
            Session::forget('name_company');

            return response()->json(['status' => 202, 'msg' => "Login Succesfully!", 'title' => 'Berhasil!', 'type' => 'success', 'data'=>$data_companies['id']]);
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
