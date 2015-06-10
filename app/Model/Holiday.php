<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model {

	protected $table ="holidays";
	
	protected $fillable = ['name','holiday_date','recurring'];

}
