<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\JobDetails;
use App\Models\EmployeeMails;
use App\Models\LogHistories;
use Yajra\DataTables\Facades\DataTables;
use Session;
class WebtelController extends Controller
{
    public function index()
    {
        Session::forget('name_company');
        $data_companies = Companies::whereNotIn('id', [5,6])->orderBy('id','asc')->get();

        return view('webtel.index',compact('data_companies'));
    }

    public function datatables_webtel($id)
    {
        $where = [];
        if($this->checkExistedSession('login_status') == false){
            $where = [
                ['job_details.extention_number', '!=', null]
            ];
        }else{
            if($this->checkExistedSession('user_session_details') == true){

                $userDetails = Session::get('user_session_details');
                if($userDetails['username'] != "admin.it"){
                    $where = [
                        ['job_details.department_id', $userDetails['department_id']]
                    ];
                }
            }
        }
        if(isset($userDetails) && ($userDetails['username'] != "admin.it" && $userDetails['username'] != "reynold")){
            $data_companies= JobDetails::select('job_details.id', 'job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','employees.last_name','departments.name','companies.acronym')
            ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
            ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
            ->where('employees.active', true)
            ->where('employees.is_internal', true)
            ->where('job_details.is_private', false)
            ->where($where)
            ->get();
        }else{
            if($id == 1){
                $ids_company = [$id,5,6];
                $data_companies= JobDetails::select('job_details.id', 'job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','employees.last_name','departments.name','companies.acronym')
                ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
                ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
                ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
                ->whereIn('job_details.company_id',$ids_company)
                ->where('employees.active', true)
                ->where('employees.is_internal', true)
                ->where('job_details.is_private', false)
                ->where($where)
                ->get();

            }else{
                $data_companies= JobDetails::select('job_details.id','job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','employees.last_name','departments.name','companies.acronym')
                ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
                ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
                ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
                ->where('job_details.company_id',$id)
                ->where('employees.active', true)
                ->where('employees.is_internal', true)
                ->where('job_details.is_private', false)
                ->where($where)
                ->get();
            }        
        }

        return DataTables::of($data_companies)
        ->addIndexColumn()
        ->addColumn('full_extention_number', function($data_companies) {
            if($data_companies['line_number'] == null || $data_companies['line_number'] == ""){
                if($data_companies['extention_number'] == null || $data_companies['extention_number'] == ""){
                    return "(-) "."-";
                }else{
                    return "(-) ".$data_companies['extention_number'];
                }
            }else{
                if($data_companies['extention_number'] == null || $data_companies['extention_number'] == ""){
                    return "(".$data_companies['line_number'].") "."-";
                }else{
                    return "(".$data_companies['line_number'].") ".$data_companies['extention_number'];
                }
            }
        })
        ->addColumn('full_name', function($data_companies) {
            $full_name = ($data_companies['first_name'] ?? "")." ".($data_companies['last_name'] ?? "");
            return $full_name;
        })
        ->make(true);
    }


    public function create(){

    }

    function randomNumber() {
        $length = 3;
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }

    public function get_employee_webtel($id){
        $data = JobDetails::select('job_details.*', 'employees.first_name', 'employees.last_name')
                ->leftjoin('employees', 'employees.id','=','job_details.employee_id')
                ->where('job_details.employee_id',$id)
                ->where('job_details.is_private', false)
                ->first();

        if($data){
            return response()->json(['status' => 202, 'msg' => "Data exist!", 'title' => 'Success!', 'type' => 'success', 'data' => $data]);
        }else{
            return response()->json(['status' => 500, 'msg' => "Data doesnt exist!", 'title' => 'Failed!', 'type' => 'error']);
        }
    }

    public function update(Request $request){
        $data = $request->all();
        $updated_jobdetails = JobDetails::where('employee_id',$data['employee_id'])->where('is_private', false)->first();
        
        $updated_jobdetails->line_number = $data['line_number'];
        $updated_jobdetails->extention_number = $data['extention_number'];
        $updated_jobdetails->updated_at = date('Y-m-d H:i:s.u');
        $updated_jobdetails->update();

        if($updated_jobdetails){
            $old_data =[
                "old_line_number" => $data['line_number'],
                "old_extention_number" => $data['extention_number'],
            ];
            $this->createLog($updated_jobdetails['id'], Session::get('users_session'), $data['employee_id'], "UPDATE", 'webtel detail', 'Web Telekomunikasi', $old_data);
            return response()->json(['status' => 202, 'msg' => "Update succesfull!", 'title' => 'Success!', 'type' => 'success']);
        }else{
            return response()->json(['status' => 500, 'msg' => "Update Failed!", 'title' => 'Failed!', 'type' => 'error']);
        }
    }

    public function detail_webtel($id){
        Session::forget('name_company');
        $id_company = $id;
        $data_companies = Companies::find($id_company);

        if($data_companies){
            Session::put('name_company', $data_companies['name']);
        }else{
            return redirect()->route('webtel.index')->with('alert', 'The Company Is not Found!');
        }
        return view('webtel.detail',compact('data_companies','id_company'));
    }

    public function delete(){
        
    }

    function checkExistedSession($name_session){
        if(Session::get($name_session)){
            return true;
        }else{
            return false;
        }
    }

    //function of create log the type is all the name if have id its integer and others is string
    function createLog($history_id=null, $user_id=null, $employee_id=null, $type=null, $menus=null, $web_name=null, $old_data=[]){
        $old_data = json_encode($old_data);
        $create_log = LogHistories::create([
            'history_id' => $history_id,
            'user_id' => $user_id,
            'employee_id' => $employee_id,
            'type' => $type,
            'menus' => $menus,
            'web_name' => $web_name,
            'old_data' => $old_data,
            'created_at' => date('Y-m-d H:i:s.u')
        ]); 
    }

    public function showEmails($employee_id){
            $employeeEmails = EmployeeMails::where('employee_id',$employee_id)->first();

            if($employeeEmails){
                $employeeEmails = $employeeEmails->toArray();
                $dataEmails = [];
                foreach($employeeEmails as $key=>$val){
                    if(str_contains($key,"email")){
                        if(isset($val)){
                            $dataEmails['emails'][]=$val;
                        }
                    }
                }
                $dataEmails['employee_id'] = $employee_id;
                return response()->json(['status' => 202, 'msg' => "Employee have emails !", 'title' => 'Success!', 'type' => 'success', 'data' => $dataEmails]);
            }else{
                return response()->json(['status' => 500, 'msg' => "Employee dont have emails!", 'title' => 'Failed!', 'type' => 'warning']);
            }
    }

    public function set_primary_emails(Request $request){
        $data = $request->all();
        $EmployeeEmails = EmployeeMails::where('employee_id',$data['employee_id'])->first();

        if($EmployeeEmails){
            $old_data =[
                "old_primary_email" => $EmployeeEmails['primary_email'],
            ];

            $EmployeeEmails->primary_email = $data['email'];
            $EmployeeEmails->update();

            $job_details = JobDetails::where('employee_id',$data['employee_id'])->first();
            if($EmployeeEmails && $job_details){
                $job_details->work_email = $data['email'];
                $job_details->update();

                if($job_details){
                    $this->createLog($EmployeeEmails['id'], Session::get('users_session'), $data['employee_id'], "UPDATE", 'webtel email', 'Web Telekomunikasi', $old_data);
                    return response()->json(['status' => 202,  'msg' => "Success Set Email to Primary !", 'title' => 'Failed!', 'type' => 'success', 'data' => $EmployeeEmails]);
                }else{
                    return response()->json(['status' => 500,  'msg' => "Failed Set Email to Primary !", 'title' => 'Failed!', 'type' => 'error']);
                }
            }else{
                return response()->json(['status' => 500,  'msg' => "Failed Set Email to Primary !", 'title' => 'Failed!', 'type' => 'error']);
            }
        }else{
            return response()->json(['status' => 500,  'msg' => "Failed Set Email to Primary !", 'title' => 'Failed!', 'type' => 'error']);
        }
    }
}
