angular.module('permission',[]).
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
controller('permissionCtrl',['$scope','webservice',function($scope,webservice){
    $scope.role_id = role_id;
    $scope.permissions = [];
    var permissions = [];
    $scope.form = [];
    var loadInfo = function()
    {
        var response = webservice.get(BASE+'api/permissions.json');
        response.success(function(res){
            $scope.permissions = res;
            permissions = res;
        });
    }
    
    $scope.setPermission = function(index)
    {
        
        var obj = permissions[index];
        var i = $scope.form.indexOf(obj);
        
        if(i == -1)
        {
            $scope.form.push(obj);
        }
        else{
            $scope.form.splice(i,1);
        }
            
    }
    
    $scope.savePermission = function()
    {
        var response = webservice.post(BASE+'permission/create',{role_id:$scope.role_id,permissions:$scope.form});
    
        response.success(function(res){
           
            console.log(res);
        }).errors(function(){
            $scope.errors = res.message;
        });
    }
    
    
    loadInfo();
}]);