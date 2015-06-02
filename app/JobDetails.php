<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class JobDetails extends Model {

	protected $table = "job_details";
	
	protected $fillable = ['employee_id','department_id','designation_id','basic_salary','job_start','job_end','verifier','active_job'];
	
	public function Department()
	{
	    return $this->belongsTo('Department','department_id');
	}
	
	public function Designation()
	{
	    return $this->belongsTo('Designation','designation_id');
	}

}
