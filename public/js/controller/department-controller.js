angular.module('department',[]).
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
controller('departmentCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.department = {name:'',parent_department:[]};
    
    var loadOrgInfo = function()
    {
        var response = webservice.get(BASE+'api/departments.json');
        response.success(function(res){
            
            $scope.departments = res;
           
        });
        
        $scope.department = {name:'',parent_department:[]};
        
    }
    
    $scope.saveDepartment = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        var response = webservice.post(BASE+'department/store',$scope.department);
        response.success(function(res){
            loadOrgInfo();
            $scope.successes = res.message;
        }).error(function(res){
            
            $scope.errors = res.name;
        });
        
    }
    
    $scope.setParent = function(department)
    { 
        var index = $scope.department.parent_department.indexOf(department.id);
        
        if(index == -1)
            $scope.department.parent_department.push(department.id);
        else
            $scope.department.parent_department.splice(index,1);
    }
    
    loadOrgInfo();
    
}]);