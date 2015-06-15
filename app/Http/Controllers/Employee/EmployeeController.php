<?php namespace App\Http\Controllers\Employee;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Utils;
use App\User;
use App\Role;
use App\Model\Employee\Employee;
use App\Model\Employee\EmployeeEducation;
use App\Model\Employee\WorkExperience;
use App\Model\Employee\EmployeeWorkshift;
use App\Model\JobDetails;
use App\Http\Requests\EmployeeForm;
use Illuminate\Http\Request;

class EmployeeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$breadcrumb = new Breadcrumb;
		$theme->addScript(url('http://nervgh.github.io/js/es5-shim.min.js'))
			  ->addScript(url('public/bower_components/angular-file-upload/angular-file-upload.min.js'))
			  ->addScript(url('public/js/directives/ngThumb.js'))
			  ->addScript(url('public/js/controller/employee-controller.js'));
		$breadcrumb->add('Dashboard',url('dashboard'))->add('Employee');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['page_title'] = 'Employee Management';
		return view('employee.list',$viewModel);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	
	public function getAssignedEmployees()
	{
		return Employee::with('Education','WorkExperience','ActiveJobDetails','ActiveJobDetails.Department','ActiveJobDetails.Designation')->where('is_employee_working','!=',0)->get()->toJson();
	}
	
	public function getAvailableEmployees()
	{
		return Employee::with('Education','WorkExperience')->where('is_employee_working',0)->get()->toJson();
	}

	public function getEmployeeByDepartment($id)
	{
		return JobDetails::with('Employee')->where('department_id',$id)->where('active_job',1)->get()->toJson();
	}
	
	public function assignWorkShift(Request $req)
	{ 	$employees = $req->get('employee');
		if(count($employees)){
			foreach($employees as $emp){
				$employeeWorkShift = EmployeeWorkshift::firstOrNew(array(
					'employee_id'   => $emp,
					'work_shift_id' => $req->get('shift'),
					'shift_date'    => $req->get('shift_date')
				));
				$employeeWorkShift->save();
			}
		}
		return array('message'=>array('Roster Schedule updated'));
	}
	
	public function getWorkShifts($month,$year)
	{
		$month = (strlen($month)==1) ? '0'.$month :$month;
		$searchDuration = (!empty($month) && !(empty($year)))? $year.'-'.$month : date('Y-m');
		$results = EmployeeWorkshift::with('Employee')->where('shift_date','like',$searchDuration.'%')->get();
		$shifts = [];
		if(count($results))
		{
			foreach($results as $result)
			{
				$shifts[$result->shift_date][$result->work_shift_id]['employees'][] =  $result->employee;
			}
		}
		return $shifts;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EmployeeForm $req)
	{
		if(!count($req->messages()))
		{
			
			$user = User::firstOrNew(array('email'=>$req->get('email')));
			if(!$user->exists)
			{
				$role = Role::where('name','ESS')->first();
				
				if($role->exists)
				{
					$employee = Employee::firstOrNew(array('email'=>$req->get('email')));
					$employee->employee_id = $req->get('employee_id');
					$employee->name = $req->get('name');
					$employee->present_address = $req->get('present_address');
					$employee->permanent_address = $req->get('permanent_address');
					$employee->phone = $req->get('phone');
					$employee->source = $req->get('source');
					$employee->source_name = $req->get('source_name');
					$employee->save();
			
					$user->name = $req->get('name');
					$user->password = bcrypt($user->name);
					$user->role_id = $role->id;
					$user->employee_id = $employee->id;
					
					$user->save();
					
				}else{
					return array('error'=>array('Sorry! ESS role not defined, Go to <a href="'.url('role').'">Role Manager</a> please create ESS role before create employee '));
				}
			
			}else{
				return array('error'=>array('User already exist with this email address'));
			}
			
			
			return array('message'=>array('Employee created successfully'));
		}
		else
		{
			return $req->messages();
		}
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $req,$option)
	{
		
		$employee = Employee::find($req->get('id'));
		
		if(count($employee))
		{
			switch($option)
			{
				case 'basic':
				    $employee->employee_id = $req->get('employee_id');
					$employee->name = $req->get('name');
					$employee->present_address = $req->get('present_address');
					$employee->permanent_address = $req->get('permanent_address');
					$employee->source = $req->get('source');
					$employee->email = $req->get('email');
					$employee->source_name = $req->get('source_name');
					if($req->hasFile('file'))
					{
						@unlink('data/'.$employee->photo);
						
						$fileObj = $req->file('file');
						$ext = $fileObj->getClientOriginalExtension();
						$name = $fileObj->getClientOriginalName();
						$prefix = time();
						$path = 'data';
		                $name = $prefix.'_'.$name;
		                if(in_array($ext,array('jpg','png','gif'))){
		                    $fileObj->move($path,$name);
		                    $employee->photo = $name;
		                }
						
					}	
					$employee->save();
					
					$role = Role::where('display_name','ESS')->first();
					$user = User::where('employee_id',$employee->id)->where('role_id',$role->id)->first();
					$user->update(array('email'=>$employee->email));
					return (!empty($name))? $name : json_encode(array('message'=>array('Information updated')));
				break;
				
				case 'edu':
					$edus = $req->get('edus');
					EmployeeEducation::where('employee_id',$employee->id)->delete();
					if(count($edus))
					{
						foreach($edus as $edu)
						{
							$employeeEdu =	EmployeeEducation::firstOrNew(array(
								'employee_id' => $employee->id,
								'institution_name' => $edu['institution_name']
								
							));
							
							$employeeEdu->degree_name = $edu['degree_name'];
							$employeeEdu->pass_year = $edu['pass_year'];
							$employeeEdu->grade = $edu['grade'];
							
							$employeeEdu->save();
						}
					}
					break;
				
				case 'exp':
					$exps = $req->get('exps');
					WorkExperience::where('employee_id',$employee->id)->delete();
					if(count($exps))
					{
						foreach($exps as $exp)
						{
							$employeeExp =	WorkExperience::firstOrNew(array(
								'employee_id' => $employee->id,
								'work_title' => $exp['work_title']
								
							));
							
							$employeeExp->org_name = $exp['org_name'];
							$employeeExp->year_exp = $exp['year_exp'];
							$employeeExp->save();
						}
					}
					break;
					
				case 'assign':
					$job_details = $req->get('job_details');
					$department_id = $job_details['department_id'];
					$designation_id = $job_details['designation_id'];
					$jobDetails = JobDetails::firstOrNew(array('employee_id'=>$employee->id,'department_id'=>$department_id,'designation_id'=>$designation_id));
					$jobDetails->basic_salary = $job_details['basic_salary'];
					$jobDetails->verifier = (int)$job_details['verifier'];
					$jobDetails->active_job = 1;
					$jobDetails->job_start = $job_details['job_start'];
					$jobDetails->job_end = $job_details['job_end'];
					$jobDetails->save();
					$employee->is_employee_working = 1;
					$employee->save();
					return array('message'=>array('Information updated'));
					break;
				case 'release':
					$activeJobDetails = $employee->ActiveJobDetails;
					$activeJobDetails->job_end = date('Y-m-d H:i:s');
					$activeJobDetails->active_job = 0;
					$activeJobDetails->save();
					$employee->is_employee_working = 0;
					$employee->save();
					return array('message'=>array('Information updated'));
					break;
			}
		}
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	public function removeWorkShift(Request $req)
	{
		EmployeeWorkshift::where('employee_id',$req->get('emp_id'))
			->where('work_shift_id',$req->get('shift_id'))
			->where('shift_date',$req->get('full_date'))->delete();
	}

}
