<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model
{
    protected $table = "job_details";
    protected $primaryKey = "id";

    protected $fillable = [
        'employee_id', 
        'company_id', 
        'department_id', 
        'section_id', 
        'position_id', 
        'employment_status_id', 
        'location_id', 
        'join_date', 
        'absence_number', 
        'work_email', 
        'created_at', 
        'updated_at', 
        'employee_number', 
        'phone_number', 
        'line_number', 
        'extention_number'
    ];
}
