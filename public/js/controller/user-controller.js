angular.module('users',[]).
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
controller('userCtrl',['$scope','webservice',function($scope,webservice){
    $scope.users = [];
    $scope.userForm = {};
    
    $scope.showForm = 0;
    $scope.selectedUserId = '';
    
    var loadInfo = function()
    {
        $scope.users = [];
        var response = webservice.get(BASE+'api/users.json');
        response.success(function(res){

            $scope.users = res;
            
        });
        $scope.selectedUserId = '';
    }
    $scope.cancelFrm = function()
    {
        $scope.showForm = 0;
        $scope.successes = [];
        $scope.errors = [];
        $scope.selectedUserId = '';
    }
    
    $scope.deleteUser = function(user)
    {
        var response = webservice.post(BASE+'user/remove',{id:user.id});
        response.success(function(res){
           $scope.successes = res.message;
           loadInfo();
           $scope.userForm = {};
           $scope.showForm = 0;
       }).error(function(res){
           if(res.name != undefined)
                $scope.errors = res.name;
           if(res.email != undefined)
                $scope.errors = res.email;
       });
    }
    
    $scope.editUser = function(user)
    {
        
        $scope.showForm = 1;
        $scope.userForm.name = user.name;
        $scope.userForm.email = user.email;
        $scope.userForm.role_id = user.role_id;
        $scope.selectedUserId = user.id;
        $scope.userForm.id = user.id;
        
        
    }
    
    $scope.showCreateUserFrm = function()
    {
        $scope.showForm = 1;
        return false;
    }
    
    
    $scope.saveUser = function(){
       $scope.successes = [];
       $scope.errors = [];
       if($scope.selectedUserId != "")
       {
           var response = webservice.post(BASE+'user/update',$scope.userForm);
           
       }else{
           var response = webservice.post(BASE+'user/create',$scope.userForm);
           
       }
       response.success(function(res){
           $scope.successes = res.message;
           loadInfo();
           $scope.userForm = {};
           $scope.showForm = 0;
       }).error(function(res){
           if(res.name != undefined)
                $scope.errors = res.name;
           if(res.email != undefined)
                $scope.errors = res.email;
       });
       
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadInfo();
}]);