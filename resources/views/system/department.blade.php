@extends('template')

@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="department" ng-controller="departmentCtrl" ng-cloak>
    <ol class="breadcrumb">
	  <li><a href="#">Home</a></li>
	  <li><a href="#">Library</a></li>
	  <li class="active">Data</li>
	</ol>
	<ul class="alert alert-danger errors" ng-if="errors.length > 0">
		<li ng-repeat="err in errors">@{{err}}</li>
	</ul>
	<ul class="alert alert-success success" ng-if="successes.length > 0">
		<li ng-repeat="success in successes">@{{success}}</li>
	</ul>
	<div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}</div>
        <div class="panel-body">
            <form class="form-horizontal" ng-submit="saveDepartment()">
                <div class="col-lg-2">
                    
                    <script type="text/ng-template" id="categoryTree">
                        <input type="checkbox" ng-model="depart.parent_department" ng-change="setParent(depart)" /> @{{depart.name}}
                        <ul class="nav sub-level-1" ng-if="depart.child_department">
                            <li ng-repeat="depart in depart.child_department" ng-include="'categoryTree'">           
                            </li>
                        </ul>
                    </script>
                    <ul class="nav">
                        <li ng-repeat="depart in departments" ng-include="'categoryTree'"></li>
                    </ul>
                </div>
                <div class="col-lg-10 vertical-seperator">
                    <div class="form-group">
                        
                        <label class="control-label col-lg-3">Department Name</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" ng-model="department.name" name="name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-lg-offset-3">
                            <input type="submit" class="btn btn-success btn-sm" value="save"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@stop