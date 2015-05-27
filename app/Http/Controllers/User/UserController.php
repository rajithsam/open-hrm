<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Theme;
use App\Role;
use App\User;
use App\Http\Requests\User\UserForm;
use Illuminate\Http\Request;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/user-controller.js'));
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'User Management';
		$viewModel['roles'] = Role::all();
		return view('user.list',$viewModel);
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
	 * Get all users as json
	 * @return Json
	 */
	public function getAll()
	{
		return User::with('Role')->get()->toJson();
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UserForm $req)
	{
		if(!count($req->messages()))
		{
			//print_r($req->all());die();
			$user = User::create($req->all());
			
			$role = Role::find($req->get('role_id'));
			
			$user->roles()->attach($role->id);
			
			
			return json_encode(array('message'=>array('New user '.$user->name.' successfully created')));
		}
		else{
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
	public function update(Request $req)
	{
		$id = $req->get('id');
		if($id)
		{
			

			$user = User::find($id);
			
			$user->name = $req->get('name');
			
			$user->email = $req->get('email');
			
			$user->role_id = $req->get('role_id');
			$password = trim($req->get('password'));
			if(!empty($password))
			{
				die('here');
				$user->password = bcrypt($password);
			}
			
			$user->save();
			return json_encode(array('message'=>array('User Information updated successfully')));
		}else{
			return redirect('/');
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
	
	public function remove(Request $req)
	{
		if($req->get('id'))
		{
			$user = User::find($req->get('id'));
			$user->delete();
			return json_encode(array('message'=>array('User '.$user->name.' deleted successfully')));
		}else{
			return redirect('/');
		}
	}

}