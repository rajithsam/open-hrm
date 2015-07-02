<?php namespace App\Http\Controllers\Leave;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Breadcrumb;
use App\Helpers\Theme;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use App\Model\Leave\Attendance;

class AttendanceController extends Controller {


	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$breadcrumb = new Breadcrumb;
		$theme = new Theme;
		$theme->addScript(url('public/js/controller/attendance-controller.js'))
		      ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap.min.js'))
			  ->addScript(url('public/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js'));
		$breadcrumb->add('Dashboard',url('dashboard'))->add('Attendance');
		$viewModel['breadcrumb'] = $breadcrumb->output();
		$viewModel['scripts'] = $theme->getScripts();
		$viewModel['page_title'] = 'Attendance';
		return view('leave.attendance',$viewModel);
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
		return Attendance::with('Employee','WorkShift')->get()->toJson();
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $req)
	{
		
		 $employee_id = $req->get('employee_id');
		 $attendance = Attendance::firstOrNew(array('employee_id'=>$employee_id,'date'=>$req->get('date')));
		 $shift = $req->get('shift');
		 
		 $shift_st = $shift['work_shift']['start_time'];
		 $shift_et = $shift['work_shift']['end_time'];
		 
		 $st = $req->get('start_time');
		 $et = $req->get('end_time');
		 $st_diff = date('H:i:s',(($st - $shift_st)/1000));
		 $et_diff = date('H:i:s',(($et - $shift_et)/1000));
		 $work_time = date('H:i:s',($et-$st)/1000);
		 
		 $attendance->work_shift_id = $shift['work_shift_id'];
		 $attendance->start_time = $st;
		 $attendance->end_time = $et;
		 $attendance->start_after = $st_diff;
		 $attendance->end_before = $et_diff;
		 $attendance->working_time = $work_time;
		 $attendance->date = $req->get('date');
		 $attendance->leave_id = null;
		 $attendance->save();
		 
		 return array('message'=>array('Attendance Successfully saved'));
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
		$attendance = Attendance::find($req->get('id'));
		$shift = $req->get('shift');
		$attendance->work_shift_id = $shift['work_shift_id'];
		$attendance->start_time = $req->get('start_time');
		$attendance->end_time = $req->get('end_time');
		$attendance->date = $req->get('date');
		$attendance->leave_id = null;
		$attendance->save();
		
		return array('message'=>array('Attendance Successfully saved'));
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
	
	public function getMyAttendance($month='',$year='')
	{
		$user = Auth::user();
		$date = (!empty($year) && !empty($month)) ? $year.'-'.$month : date('Y-m');
		$result = Attendance::with('WorkShift')->where('employee_id',$user->employee_id)->where('date','like',$date.'%')->get();
		$attendance = [];
		foreach($result as $r)
		{
			$attendance[$r->date][$r->WorkShift->shift_name]['in'] = (($r->start_time)/1000);
			$attendance[$r->date][$r->WorkShift->shift_name]['out'] = (($r->end_time)/1000);
		}
		return $attendance;
		Utils::LastQuery();
	}

}