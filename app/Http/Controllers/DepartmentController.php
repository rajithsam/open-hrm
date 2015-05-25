<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Http\Requests\DepartmentForm;
use App\Model\System\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/department-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = "Department";
		return view('system.department',$viewModel);
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


	/**
	 * Get all department as json
	 * @return Json;
	 */
	public function getAll()
	{
		return Department::with('ChildDepartment','ChildDepartment.ChildDepartment','ChildDepartment.ChildDepartment.ChildDepartment')->where('parent_department',0)->get()->toJson();
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(DepartmentForm $req)
	{
		if(!count($req->messages()))
		{
			$parentDepartment = $req->get('parent_department');
			if(!empty($parentDepartment))
			{
				foreach($parentDepartment as $pd)
				{
					$department = Department::firstOrNew(array(
						'name'=>$req->get('name'),
						
						));
					$department->parent_department = $pd;
					$department->save();
				}
				
			}else{
				$department = Department::firstOrNew(array('name'=>$req->get('name')));
				$department->parent_department = 0;
				$department->save();
			}
			
			return json_encode(array('message'=>array('Organization Information updated successfully')));
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
