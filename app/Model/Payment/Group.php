<?php namespace App\Model\Payment;

use Illuminate\Database\Eloquent\Model;

class PaymentGroup extends Model {

	protected $table = "payment_groups";
	
	protected $fillable = ['job_type','title','template'];

}
