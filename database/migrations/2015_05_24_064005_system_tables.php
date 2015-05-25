<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hrm_org', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title',50);
			$table->string('phone',50);
			$table->string('fax',50)->nullable();
			$table->string('email',100);
			$table->text('address');
			$table->string('country',50);
			$table->string('city',50);
			$table->string('state',50);
			$table->string('postcode',50);
			$table->timestamps();
		});
		
		Schema::create('departments',function(Blueprint $table){
			$table->increments('id');
			$table->string('name',100)->unique();
			$table->integer('parent_department')->unsigned();
			$table->integer('department_order')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
		
		Schema::create('designations',function(Blueprint $table){
			$table->increments('id');
			$table->integer('department_id')->unsigned();
			$table->string('job_title',100);
			$table->text('description');
			$table->integer('job_order')->unsigned();
			$table->integer('job_quota')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('department_id')->references('id')->on('departments')
				->onUpdate('cascade')->onDelete('cascade');
				
			$table->index('department_id');
		});
		
		Schema::create('hrm_work_week',function(Blueprint $table){
			$table->increments('id');
			$table->string('day_name',10);
			$table->enum('status',['Working Day','Not Working Day']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('designations');
		Schema::drop('departments');
		Schema::drop('hrm_work_week');
		Schema::drop('hrm_org');
	}

}
