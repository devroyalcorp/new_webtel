<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Employees;
use App\Models\JobDetails;
use App\Models\User;
class WebtelController extends Controller
{
    public function index()
    {
        $data_companies = Companies::get();
        // dd($data_companies);
        return view('webtel.index',compact('data_companies'));
    }

    public function create(){

    }

    public function update($id){
        
    }

    public function detail_webtel($id){
        $data_companies= JobDetails::select('job_details.line_number','job_details.extention_number','employees.first_name','departments.name','companies.acronym')
        ->leftJoin('employees', 'employees.id', '=', 'job_details.employee_id')
        ->leftJoin('departments', 'departments.id', '=', 'job_details.department_id')
        ->leftJoin('companies', 'companies.id', '=', 'job_details.company_id')
        ->where('job_details.company_id',$id)
        ->get();

        // dd($data_companies);
        return view('webtel.detail',compact('data_companies'));
    }

    public function delete(){
        
    }
}
