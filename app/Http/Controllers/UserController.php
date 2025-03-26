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
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected $connection;

    public function __construct(Type $var = null) {
        $this->connection = LdapContainer::getConnection('default');
    }

    public function index()
    {

        $session_user = Session::get('user_session_details');
        if(!isset($session_user)){
            return view('admin.login-left-content');
        }else{
            return redirect()->route('webtel.detail', ['id' => $session_user['company_id']]);
        }
        // return view('admin.login-nataru');
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
        // The Keycloak server's URL and realm you want to log out from
        $keycloakUrl = env('KEYCLOAK_BASE_URL'); // Base URL for Keycloak
        $realm = env('KEYCLOAK_REALM');  // The realm for your Keycloak configuration

        // The Keycloak client credentials (client ID and client secret)
        $clientId = env('KEYCLOAK_CLIENT_ID');
        $clientSecret = env('KEYCLOAK_CLIENT_SECRET');

        // Get the access token from the session (assuming it's stored there)
        $refresh_token = Session::get('keycloak_refresh_token'); // Adjust according to how you're storing it

        // Send a POST request to Keycloak logout endpoint
        $response = Http::asForm()->post("{$keycloakUrl}/realms/{$realm}/protocol/openid-connect/logout", [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refresh_token, // Use refresh token if available
        ]);

        if ($response->successful()) {
            // Clear Laravel session and logout
            Session::flush(); // Remove all session data
    
            // Optionally, you could redirect to a login page or home page here:
            return redirect('/login')->with('message', 'You have been logged out.');
        } else {
            // Handle error in logout request
            return redirect('/login')->with('message', 'Error Logout.');
        }

    }

    public function redirectToKeycloak()
    {
        return Socialite::driver('keycloak')->redirect();
    }

    public function handleKeycloakCallback()
    {
        $user = Socialite::driver('keycloak')->user();

        if(isset($user->nickname)){
            $get_user = User::select('users.*','job_details.company_id','job_details.department_id')
            ->where('username', $user->nickname)
            ->leftjoin('job_details', 'job_details.employee_id','=', 'users.employee_id')->first();

            if($get_user){
                $get_user = $get_user->toArray();
                $data_companies = Companies::find($get_user['company_id']);
            
                Session::put('users_session', $get_user['id']);
                Session::put('user_session_details', $get_user);
                Session::put('keycloak_refresh_token', $user->refreshToken);
                Session::put('login_status', true);
                Session::forget('name_company');

                return redirect()->route('webtel.detail', ['id' => $get_user['company_id']]);
            }else{
                return redirect()->back();
            }
        }else{
            return null;
        }
    }
}
