<?php namespace App\Model\Payment;

use Illuminate\Database\Eloquent\Model;

class PaymentHead extends Model {

	protected $table = "payment_heads";
	
	protected $fillable = ['head_name','parent_head','job_type','head_type'];

}
