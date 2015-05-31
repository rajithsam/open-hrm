<div class="alert alert-danger" ng-if="errors.length > 0">
	<button aria-label="Close" type="button" ng-click="resetAlert()"><span aria-hidden="true">×</span></button>
    <ul class="errors" >
		<li ng-repeat="err in errors">@{{err}}</li>
	</ul>
</div>
<div class="alert alert-success" ng-if="successes.length > 0">
	<button aria-label="Close" type="button" ng-click="resetAlert()"><span aria-hidden="true">×</span></button>
	<ul class="success" >
		<li ng-repeat="success in successes">@{{success}}</li>
	</ul>
</div>