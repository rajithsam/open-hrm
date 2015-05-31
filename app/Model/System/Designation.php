<?php namespace App\Model\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model {

    use SoftDeletes;
    
	protected $table = "designations";
	
	protected $fillable = ['title','description','quota'];

    protected $dates = ['deleted_at'];
    
    public function Department()
    {
        return $this->belongsTo('App\Model\System\Department','department_id');
    }
}
