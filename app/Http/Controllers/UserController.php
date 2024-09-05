<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use LdapRecord\Container as LdapContainer;
use App\Ldap\User as LdapUser;
use App\Models\Companies;
use App\Models\User;
use App\Models\JobDetails;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
            $employee = null;
            if ($ldapUser?->description) {
                $nik = $ldapUser->description[0] ?? "";
                if ($nik) {
                    if (strlen($nik) <= 7) {
                        $nik = "0$nik";
                    }

                    $employee = JobDetails::select('id', 'employee_id', 'employee_number','company_id','department_id')
                        ->where('employee_number', $nik)
                        ->first();
                }
            }

            if($ldapUser){

                if ($this->connection->auth()->attempt($ldapUser->getDn(), $data['password'])) {

                    $get_user = User::select('users.*','job_details.company_id','job_details.department_id')
                    ->where('username', $ldapUser->samaccountname[0])
                    ->leftjoin('job_details', 'job_details.employee_id','=', 'users.employee_id')->first();

                    if($get_user){

                        $get_user = $get_user->toArray();
                        $data_companies = Companies::find($get_user['company_id']);
                    
                        Session::put('users_session', $get_user['id']);
                        Session::put('user_session_details', $get_user);
                        Session::put('login_status', true);
                        Session::forget('name_company');
                    }else{
                        return response()->json(['status' => 500, 'msg' => "There is no data user.", 'title' => 'Login Failed!!', 'type' => 'error']);
                    }
    
                    return response()->json(['status' => 202, 'msg' => "Login Succesfully!", 'title' => 'Login Success!!', 'type' => 'success', 'data'=>$data_companies['id']]);
                }else{
                    $user = User::select('users.*','job_details.company_id','job_details.department_id')->where('username', $data['username'])
                    ->leftjoin('job_details', 'job_details.employee_id','=', 'users.employee_id')->first();

                    // Sync user with employee
                    if ($employee && $user) {
                        $user->employee_id = $employee->employee_id;
                        $user->save();
                    }
    
                    // NOTE: bypass login jika user sudah login menggunakan akun AD. issue akun AD kadang bermasalah!
                    // issue jika check tb users password hrms harus sync dengan ldap
                    if ($user?->password) {
                        if (Hash::check($data['password'], $user->password)) {
                            Log::info('Using alternative login because authentication issue form AD');
                            $data_companies = Companies::find($user['company_id']);

                            Session::put('users_session', $user['id']);
                            Session::put('user_session_details', $user);
                            Session::put('login_status', true);
                            Session::forget('name_company');
                            
                            return response()->json(['status' => 202, 'msg' => "Login Succesfully (NAD)!", 'title' => 'Login Success!!', 'type' => 'success', 'data'=>$data_companies['id']]);
                        } else {
                            return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!', 'type' => 'error']);
                        }
                    } else {
                        return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!', 'type' => 'error']);
                    }

                    return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!!', 'type' => 'error']);
                }
            }else{
                return response()->json(['status' => 500, 'msg' => "Wrong Username or Password!", 'title' => 'Login Failed!!', 'type' => 'error']);
            }
        } catch (\Throwable $th) {
            if (config('app.env') !== 'production') {
                $message = $th->getMessage();
                Log::error("Login failed: ", [
                    $data['username'].': '.$message,
                    $data['username'],
                ]);
            }else{
                $message = "Something went wrong!";
            }

            return response()->json(['status' => 500, 'msg' => $message, 'title' => 'Login Failed!', 'type' => 'error']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
