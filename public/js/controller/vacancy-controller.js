angular.module('vacancy',[]).
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
controller('vacancyCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.showFrm = 0;
    $scope.form = {department:'',designation:'',title:'',hiring_manager:'',position:'',description:'',publish:''};
    $scope.openFrm = function()
    {
        $scope.showFrm = 1;
         $scope.form = {department:'',designation:'',title:'',hiring_manager:'',position:'',description:'',publish:''};
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
         $scope.form = {department:'',designation:'',title:'',hiring_manager:'',position:'',description:'',publish:''};
    }
    
    
    $scope.getDesignations = function()
    {
        var response = webservice.get(BASE+'designations/'+$scope.form.department);
        response.success(function(res){
           $scope.designations = res; 
        }).error(function(res){
            
        });
        
        var response = webservice.get(BASE+'api/get-hiring-manager/'+$scope.form.department);
        response.success(function(res){
           $scope.hiring_managers = res; 
        }).error(function(res){
            
        });
    
    }
    
    var loadDepartments = function()
    {
        var response  = webservice.get(BASE+'departments.json');
        response.success(function(res){
            $scope.departments = res;   
            
        });
    }
    
    var loadVacncies = function()
    {
        var response = webservice.get(BASE+'vacanicies.json');
        response.success(function(res){
           $scope.vacancies = res; 
        });
    }
    
    $scope.saveVacancy = function()
    {
        $scope.successes = $scope.errors = [];
        var response = webservice.post(BASE+'vacancy/save-vacancy',$scope.form);
        response.success(function(res){
            $scope.successes = res.message;
        });
    }
    
    loadDepartments();
    
}]);