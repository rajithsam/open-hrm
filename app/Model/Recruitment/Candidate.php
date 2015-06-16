<?php namespace App\Model\Recruitment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Candidate extends Model {

    use SoftDeletes;
    
	protected $table = "candidates";
	
	protected $fillable = ['name','email','vacancy_id','description','keyword','application_source'];
	
	protected $dates = ['deleted_at'];

}
