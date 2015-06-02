<?php namespace App\Http\Controllers\Employee;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Helpers\Breadcrumb;
use App\Helpers\Utils;
use App\User;
use App\Role;
use App\Model\Employee\Employee;
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
		$theme->addScript(url('public/js/controller/employee-controller.js'));
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
		return Employee::with('JobDetails','JobDetails.Department','JobDetails.Designation')->where('is_employee_working',0)->get()->toJson();
	}
	
	public function getAvailableEmployees()
	{
		return Employee::where('is_employee_working',0)->get()->toJson();
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
	public function update($id)
	{
		//
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

}
