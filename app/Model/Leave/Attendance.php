<?php namespace App\Model\Leave;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {

	protected $table = "attendance";

    protected $fillable = ['employee_id','work_shift_id','start_time','end_time','date','leave_id'];
    
    public function WorkShift()
    {
        return $this->belongsTo('App\Model\System\WorkShift','work_shift_id');
    }
    
    public function Employee()
    {
        return $this->belongsTo('App\Model\Employee\Employee','employee_id');
    }
}
