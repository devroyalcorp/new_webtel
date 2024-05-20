<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\JobDetails;
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
        if($id == 1){
            $ids_company = [$id,5,6];
            $data_companies= JobDetails::select('job_details.id', 'job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','employees.last_name','departments.name','companies.acronym')
            ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
            ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
            ->whereIn('job_details.company_id',$ids_company)
            ->where('employees.active', true)
            ->where('employees.is_internal', true);

        }else{
            $data_companies= JobDetails::select('job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','employees.last_name','departments.name','companies.acronym')
            ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
            ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
            ->where('job_details.company_id',$id)
            ->where('employees.active', true)
            ->where('employees.is_internal', true);
        }

        if($this->checkExistedSession('login_status') == false){
            $data_companies->where('job_details.extention_number', '!=', null);
        }
        $data_companies->get();

        return DataTables::of($data_companies)
        ->addIndexColumn()
        ->make(true);
    }


    public function create(){

    }

    public function get_employee_webtel($id){
        $data = JobDetails::select('job_details.*', 'employees.first_name', 'employees.last_name')
                ->leftjoin('employees', 'employees.id','=','job_details.employee_id')
                ->where('job_details.employee_id',$id)
                ->first();

        if($data){
            return response()->json(['status' => 202, 'msg' => "Data exist!", 'title' => 'Success!', 'type' => 'success', 'data' => $data]);
        }else{
            return response()->json(['status' => 500, 'msg' => "Data doesnt exist!", 'title' => 'Failed!', 'type' => 'error']);
        }
    }

    public function update(Request $request){
        $data = $request->all();
        $updated_jobdetails = JobDetails::where('employee_id',$data['employee_id'])->first();
        
        $updated_jobdetails->line_number = $data['line_number'];
        $updated_jobdetails->extention_number = $data['extention_number'];
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

        Session::put('name_company', $data_companies['name']);
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
            'old_data' => $old_data
        ]); 
    }
}
