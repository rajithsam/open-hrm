<?php namespace App\Model\Leave;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attendance extends Model {

	protected $table = "attendance";

    protected $fillable = ['employee_id','work_shift_id','in_time','out_time','start_after','end_before','working_time','date','leave_id'];
    
    public function WorkShift()
    {
        return $this->belongsTo('App\Model\System\WorkShift','work_shift_id');
    }
    
    public function Employee()
    {
        return $this->belongsTo('App\Model\Employee\Employee','employee_id');
    }
    
    public function getAllColumnsNames()
    {
        switch (DB::connection()->getConfig('driver')) {
            case 'pgsql':
                $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$this->table."'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                $query = 'SHOW COLUMNS FROM '.$this->table;
                $column_name = 'Field';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->table);
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $query = "SELECT column_name FROM ".DB::connection()->getConfig('database').".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'".$table."'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach(DB::select($query) as $i=> $column)
        {
            if($i==0)
                continue;
            $columns[] = $column->$column_name;
        }

        if($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }
}
