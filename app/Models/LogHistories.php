<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHistories extends Model
{
    use HasFactory;

    protected $table = 'log_histories';

    protected $guarded = [];
}
