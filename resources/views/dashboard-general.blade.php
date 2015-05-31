@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content">
	<ol class="breadcrumb">
	  {!!$breadcrumb!!}}
	</ol>
	@include('partials.alertmessage')
	<div class="panel panel-default">
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