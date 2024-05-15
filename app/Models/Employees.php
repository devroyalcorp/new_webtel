<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{

    protected $table = "employees";
    protected $primaryKey = "id";

    protected $fillable = [
        'profile_picture',
        'first_name',
        'nickname',
        'id_card',
        'ssah_number', 
        'ssae_number', 
        'marital_status', 
        'date_of_birth', 
        'gender',
        'smoker',
        'created_at', 
        'updated_at', 
        'last_name', 
        'birthplace', 
        'instagram', 
        'linkedin', 
        'ancestry', 
        'religion_id', 
        'blood_type', 
        'npwp', 
        'npwp_status', 
        'personal_email', 
        'active', 
        'attendance_schedule_id', 
        'parent_id', 
        'depth', 
        'ordering', 
        'state', 
        'is_internal', 
        'uuid', 
        'termination_date', 
        'termination_reason'
    ];
}
