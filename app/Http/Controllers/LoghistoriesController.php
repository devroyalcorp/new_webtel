<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Employees;
use App\Models\JobDetails;
use App\Models\LogHistories;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Session;

class LoghistoriesController extends Controller
{
    public function datatables_loghistory($id)
    {
        $history_id = $id;
        $log_history = LogHistories::select('log_histories.*', 'users.first_name', 'employees.first_name', 'employees.last_name')
                                    ->leftjoin('users', 'users.id', '=', 'log_histories.user_id')
                                    ->leftjoin('employees', 'employees.id', '=', 'log_histories.employee_id')
                                    ->where('log_histories.history_id',$history_id)
                                    ->orderByDesc('log_histories.created_at')
                                    ->limit(5)
                                    ->get();

        return DataTables::of($log_history)
        ->addIndexColumn()
        ->addColumn('name_user', function ($data) {
            $get_user = User::find($data['user_id']);
            $user_employee = Employees::find($get_user['employee_id']);
            return $user_employee['first_name']." ".$user_employee['last_name'];
        })
        ->editColumn('created_at', function($data) {
            return date('j F Y H:i:s', strtotime($data->created_at));
        })
        ->make(true);
    }

    public function check_history($id)
    {
        $data = LogHistories::select('log_histories.*', 'employees.first_name', 'employees.last_name')
        ->where('log_histories.history_id',$id)
        ->leftjoin('employees', 'employees.id', '=', 'log_histories.employee_id')->first();


        if($data){
            return response()->json(['status' => 202, 'msg' => "Data Exist !", 'title' => 'Success!', 'type' => 'success', 'data' => $data]);
        }else{
            return response()->json(['status' => 500, 'msg' => "Data doesnt exist!", 'title' => 'Failed!', 'type' => 'error']);
        }
    }
}
