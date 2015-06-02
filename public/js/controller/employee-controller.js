angular.module('employee',[]).
service('webservice',function($http){
    
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
}).
controller('employeeCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.showForm = 0;
    $scope.sources = ['NEWS','ONLINE','PERSON','OTHERS'];
    $scope.form = {employee_id:'',name:'',present_address:'',
                permanent_address:'',email:'',phone:'',source:'',source_name:''};
    $scope.tab = {avaiable_resource:0,assigned_resource:0};
    
    $scope.cancelFrm = function()
    {
        
        $scope.showForm = 0;
        
    }
    
    $scope.openFrm = function()
    {
        
        $scope.showForm = 1;
   
    }
    
    $scope.selectTab = function(item)
    {
        $scope.tab = {avaiable_resource:0,assigned_resource:0};
        $scope.tab[item] = 1;
    }
    
    var loadAvailableEmployees = function()
    {
        var response = webservice.get(BASE+'api/available-employees.json'); 
        response.success(function(res){
            $scope.available_employees = res;
        });
    }
    
    $scope.saveEmployee = function()
    {
         
         var response = webservice.post(BASE+'employee/create',$scope.form);
         
         response.success(function(res){
             
             $scope.successes = res.message;
             
         }).error(function(res){
             
         });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadAvailableEmployees();
    
}]);