<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empattendancedata extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeattendance_id',
        'employee_id',
        'attendance',
        'employee_name',
        'date',
        'shift',
        'month',
        'year',
        'checkleave'
    ];
}
