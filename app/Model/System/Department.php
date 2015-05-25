<?php namespace App\Model\System;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table="departments";
	
	protected $fillable=['name','parent_department','department_order'];
	
	
	public function ChildDepartment()
	{
	    return $this->hasMany('App\Model\System\Department','parent_department');
	}

}
