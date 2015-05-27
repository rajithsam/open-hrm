@extends('template')


@section('content')
<script type="text/javascript">
    var role_id = "{{$role->id}}";
</script>
<section class="col-lg-10 col-lg-offset-2 content" ng-app="permission" ng-controller="permissionCtrl" ng-cloak>
    <ol class="breadcrumb">
        <li>Home</li>
    </ol>
    <div class="panel panel-default">
		<div class="panel-heading">
			Add Permisssions - [Access Level {{$role->display_name}}]
		</div>
	
		<div class="panel-body">
			<form class="form-horizontal" ng-submit="savePermission()">
			    <table class="table">
			        <thead>
			            <tr>
			                <th>Module</th>
			                <th>Select Permission</th>
			            </tr>
			        </thead>
			        <tbody>
			                <tr ng-repeat="route in permissions">
			                    <td>@{{route.display_name}}</td>
			                    <td><input type="checkbox" ng-change="setPermission(route.path)" class="form-control" ng-model="permissions"/></td>
			                </tr>
			        </tbody>
			    </table>
			    <input type="submit" class="btn btn-success btn-sm" value="Save"/>
		    </form>
	    </div>
    </div>
</section>
@stop