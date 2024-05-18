<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use LdapRecord\Container as LdapContainer;
use App\Ldap\User as LdapUser;
use App\Models\Companies;
use Exception;

class UserController extends Controller
{
    protected $connection;

    public function __construct(Type $var = null) {
        $this->connection = LdapContainer::getConnection('default');
    }

    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->all();

        try {
            $ldapUser = LdapUser::findByOrFail('samaccountname', $data['username']);
            
            if($ldapUser){
                // dd($this->connection->auth()->attempt($ldapUser->getDn(), $data['password']));
                if ($this->connection->auth()->attempt($ldapUser->getDn(), $data['password'])) {

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
    
                    return response()->json(['status' => 202, 'msg' => "Login Succesfully!", 'title' => 'Login Success!!', 'type' => 'success', 'data'=>$data_companies['id']]);
                }else{
                    return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!!', 'type' => 'error']);
                }
            }else{
                return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!!', 'type' => 'error']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!', 'type' => 'error']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
