@extends('template')


@section('content')
<section class="col-lg-10 col-lg-offset-2 content" ng-app="employee" ng-controller="employeeCtrl" ng-cloak>
    <ol class="breadcrumb">
	  {!!$breadcrumb!!}
	</ol>
    @include('partials.alertmessage')
    <div class="panel panel-default" ng-show="showForm">
        <div class="panel-heading">Create Employee</div>
        <div class="panel-body">
        <form class="form-horizontal" ng-submit="saveEmployee()">
            <div class="form-group">
                <label class="control-label col-lg-3">Employee ID</label>
                <div class="col-lg-1">
                    <input type="text" class="form-control" name="employee_id" ng-model="form.employee_id"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Name</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="name" ng-model="form.name"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Present Address</label>
                <div class="col-lg-6">
                    <textarea type="text" class="form-control" name="present_address" ng-model="form.present_address"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Permanent Address</label>
                <div class="col-lg-6">
                    <textarea type="text" class="form-control" name="permanent_address" ng-model="form.permanent_address"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">E-mail</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="email" ng-model="form.email"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Phone</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="phone" ng-model="form.phone"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Source</label>
                <div class="col-lg-3">
                    <select name="source" class="form-control" ng-model="form.source">
                        <option ng-repeat="s in sources" value="@{{s}}">@{{s}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-3">Source Name</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" name="source_name" ng-model="form.source_name"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-3 col-lg-offset-3">
                    <input type="submit" class="btn btn-success btn-sm" value="Save"/>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">{{$page_title}}
        <button class="btn btn-primary btn-xs pull-right" ng-show="!showForm" ng-click="openFrm()"><i class="glyphicon glyphicon-plus"></i> New Employee</button>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li role="presentation" ng-class="{active:tab.avaiable_resource}"><a ng-click="selectTab('avaiable_resource')">Available Resources</a></li>
                <li role="presentation" ng-class="{active:tab.assigned_resource}"><a ng-click="selectTab('assigned_resource')">Assigned Resources</a></li>
            </ul>
            <div class="panel">
                <table class="table" ng-show="tab.avaiable_resource">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="e in available_employees">
                            <td>@{{e.name}}</td>
                            <td>@{{e.email}}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table" ng-show="tab.assigned_resource">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="e in employees">
                            <td>@{{e.name}}</td>
                            <td>@{{e.email}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@stop