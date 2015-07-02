@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="kpi" ng-controller="kpiCtrl" ng-cloak>
    
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default">
        
        <div class="panel-heading">Create KPI</div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-3">Write Question</label>
                    <div class="col-lg-6">
                        <textarea class="form-control" ></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-3 col-lg-offset-3">
                        <input type="submit" class="btn btn-success btn-sm" value="Save Key"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="panel panel-default">
        <table class="table">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="k in kpi">
                    <td>@{{k.question}}</td>
                    <td>
                        <a class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> 
    
</section>

@stop