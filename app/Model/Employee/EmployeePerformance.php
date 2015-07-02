<?php

namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeePerformance extends Model{
    
    protected $table = 'employee_performance';
    
    protected $fillable = ['employee_id','feedback_by','template'];
}