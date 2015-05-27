<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\Helpers\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		
		$role = Role::find($id);
		if(!count($role))
		{
			return redirect('/');
		}
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/permission-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['role'] = $role;
		
		$viewModel['page_title'] = 'Permissions';
		return view('user.permissions',$viewModel);
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
	
	public function getAll()
	{
		$routes = [];
		$routeCollection =  Route::getRoutes();
		
		foreach ($routeCollection as $value) {
			$path = $value->getPath();
			if(preg_match('/(auth)|(pass)|(api)|(\/$)/',$path))
			{
				continue;
			}
			$routes[$path]['path'] = $path;
		    $routes[$path]['name'] = str_replace("/","-",$path);
		    $routes[$path]['display_name'] = implode('-', array_map('ucfirst', explode('-', $routes[$path]['name'])));
		}
		
		return json_encode($routes);
		
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		$role_id  = $req->get('role_id');
		$permissions = $req->get('permissions');
		
		if(empty($permissions) || empty($role_id))
		{
			return json_encode(array('message'=>array('Sorry something wrong. check you select permission')));
		}
		foreach($permissions as $p)
		{
			$permission = new Permission();
			$permission->name = $p['name'];
			$permission->display_name = $p['display_name'];
			$permission->description = $p['path'];
			$permission->save();
			
			$role = Role::find($role_id);
			$role->attachPermission($permission);
		}
		
		return json_encode(array('message'=>array('Permissions saved successfully')));
		
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
