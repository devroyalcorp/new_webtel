<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\JobDetails;
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
            $data_companies= JobDetails::select('job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','departments.name','companies.acronym')
            ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
            ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
            ->whereIn('job_details.company_id',$ids_company)
            ->get();
        }else{
            $data_companies= JobDetails::select('job_details.employee_id', 'job_details.work_email','job_details.line_number','job_details.extention_number','employees.first_name','departments.name','companies.acronym')
            ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
            ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
            ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
            ->where('job_details.company_id',$id)
            ->get();
        }

        return DataTables::of($data_companies)
        ->addIndexColumn()
        ->make(true);
    }


    public function create(){

    }

    public function get_employee_webtel($id){
        $data = JobDetails::where('employee_id',$id)->first();

        if($data){
            return response()->json(['status' => 202, 'msg' => "Data has been !", 'title' => 'Berhasil!', 'type' => 'success', 'data' => $data]);
        }else{
            return response()->json(['status' => 500, 'msg' => "There is no data!", 'title' => 'Gagal!', 'type' => 'error']);
        }
    }

    public function update(Request $request){
        $data = $request->all();
        $updated_jobdetails = JobDetails::where('employee_id',$data['employee_id'])->first();
        
        $updated_jobdetails->line_number = $data['line_number'];
        $updated_jobdetails->extention_number = $data['extention_number'];
        $updated_jobdetails->update();

        if($updated_jobdetails){
            return response()->json(['status' => 202, 'msg' => "Update succesfull!", 'title' => 'Berhasil!', 'type' => 'success']);
        }else{
            return response()->json(['status' => 500, 'msg' => "Update Failed!", 'title' => 'Gagal!', 'type' => 'error']);
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
}
