<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = "departments";
    protected $primaryKey = "id";

    protected $fillable = [
        'name', 
        'created_at', 
        'updated_at', 
        'group_name'
    ];
}
