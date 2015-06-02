<?php namespace App\Model\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

	protected $table = "employees";
	
	protected $fillable = ['email'];


    public function JobDetails()
    {
        return $this->hasMany('JobDetails','employee_id');
    }
    
    
    
    public function ActiveJobDetails()
    {
        return $this->hasMany('JobDetails','employee_id')->where('active_job',1);
    }
    
}
