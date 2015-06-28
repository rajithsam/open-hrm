@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="dashboard" ng-controller="dashboardCtrl" ng-cloak>
	<ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
	@include('partials.alertmessage')
	<div>
		<div class="col-lg-3 card card-red">
			<h1><i class="glyphicon glyphicon-envelop"></i> Leave</h1>
		</div>
		<div class="col-lg-3 card card-blue">
			&nbsp;
		</div>
		<div class="col-lg-3 card card-green">
			&nbsp;
		</div>
		<div class="col-lg-3 card card-yellow">
			&nbsp;
		</div>
	</div>
	<br style="clear:left;"/>
	<div class=" panel panel-default" style="margin-top:20px">
      <div class="panel-heading">
      	Panel Header
      </div>
	  <div class="panel-body">
	    Panel content
	  </div>
	  <div class="panel-footer">Panel footer</div>
	</div>
</section>

@stop