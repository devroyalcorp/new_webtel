<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use LdapRecord\Container as LdapContainer;
use App\Ldap\User as LdapUser;
use App\Models\Companies;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;


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

                if ($this->connection->auth()->attempt($ldapUser->getDn(), $data['password'])) {

                    $get_user = User::select('users.*','job_details.company_id')
                    ->where('username', $ldapUser['samaccountname'])
                    ->leftjoin('job_details', 'job_details.employee_id','=', 'users.employee_id')->first()->toArray();

                    $data_companies = Companies::find($get_user['company_id']);
                    
                    Session::put('users_session', $get_user['id']);
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
            $message = $th->getMessage();
            Log::error("Login failed: ", [
                $message,
                $data['username'],
            ]);
            return response()->json(['status' => 500, 'msg' => $data['username'].' = '.$message, 'title' => 'Login Failed!', 'type' => 'error']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
