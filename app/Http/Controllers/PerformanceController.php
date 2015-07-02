<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use App\Model\Kpi\Kpi;
use Illuminate\Http\Request;

class PerformanceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/kpi-controller.js'));
		
		$breadcurmb = new Breadcrumb;
		$breadcurmb->add('Dashboard',url('/'))->add('Performance Key');
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['breadcrumb'] = $breadcurmb->output();
		return view('kpi.list',$viewModel);
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
		return Kpi::all();
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
