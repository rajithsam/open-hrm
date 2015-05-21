<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleForm;
use App\Helpers\Theme;

class RoleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$theme = new Theme;
		$theme->addScript(url('public/js/rolecontroller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = "Manage Roles";
		return view('role.list',$viewModel);
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RoleForm $req)
	{
		if(!count($req->messages()))
		{
			$role = new Role;
			$role->name = strtolower(str_replace(" ", "-",$req->get('name')));
			$role->display_name = $req->get('name');
			$role->description = $req->get('description');
			$role->save();
			return json_encode(array('message'=>array('New role '.$role->name.' successfully Added')));
		}else{
			echo $req->messages();
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
	
	public function all()
	{
		return Role::all()->toJson();
	}

}
