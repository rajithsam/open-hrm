@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="evaluation" ng-controller="evaluationCtrl" ng-cloak>
    
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default">
        
        <div class="panel-heading">Create Evaluation Request</div>
        <div class="panel-body">
            
        </div>
    </div>
    <div class="panel panel-default">
        
    </div>
</section>

@stop