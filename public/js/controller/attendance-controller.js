angular.module('attendance',['ui.bootstrap'])
.service('webservice',function($http){
    return{
       get:function(url,data){
           return $http({
               method:"GET",
               url:url,
               data:data
           });
       },
       post:function(url,data)
       {
           return $http({
               method:"POST",
               url:url,
               data:data
           });
       }
   }; 
})
.controller('attendanceCtrl',['$scope','webservice',function($scope,webservice){
    $scope.hstep = 1;
    $scope.mstep = 15;
    $scope.form = {employee_id:'',start_time:'',end_time:'',date:'',shift:''};
    $scope.shift = '';
    $scope.showFrm = 0;
    $scope.attendances = [];
    
    var loadAttendances = function()
    {
        var response = webservice.get(BASE+'attendances.json');
        response.success(function(res){
           $scope.attendances = res; 
        });
    }
    
    $scope.openFrm = function()
    {
        $scope.showFrm = 1;
        $('input[name="date"]').datepicker({dateFormat:'yy-mm-dd'});
        $scope.form = {employee_id:'',start_time:'',end_time:'',date:'',shift:''};
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {employee_id:'',start_time:'',end_time:'',date:'',shift:''};
        
    }
    
    $scope.getTodayShift = function()
    {
        var response = webservice.get(BASE+'employee/workshift/'+$scope.form.employee_id);
        response.success(function(res){
           $scope.form.shift = res; 
        });
    }
    
    var loadAssignedEmployees = function()
    {
        var response = webservice.get(BASE+'api/assigned-employees.json'); 
        response.success(function(res){
            $scope.employees = res;
        });
    }
    
    $scope.saveAttendance = function()
    {
        
        $scope.successes = $scope.errors = [];
        var response = webservice.post(BASE+'attendance/save-attendance',$scope.form);
        response.success(function(res){
            $scope.successes = res.message;
            $scope.closeFrm();
        }).error(function(res){
            
        });
    }
    
    $scope.editAttendance = function(a)
    {
        $scope.form.employee_id = a.employee_id;
        var sD = new Date();
        sD.setTime(a.start_time);
        $scope.form.start_time = sD;
        $scope.form.end_time = a.end_time;
        $scope.date = a.date;
    }
    
    
    
    loadAttendances();
    
    loadAssignedEmployees();
}]);