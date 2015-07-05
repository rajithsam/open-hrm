angular.module('evaluation',[])
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
}).controller('evaluationCtrl',['$scope','webservice',function($scope,webservice){
   
   $scope.lists = [];
   $scope.form = {id:'',employee_id:'',feedback_by:'',rating:'',template:''};
   $scope.showFrm = 0;
   
   var loadEvalRequests = function()
   {
       var response = webservice.get(BASE+'evaluations.json');
       response.success(function(res){
          $scope.lists = res; 
       });
   }
   
   $scope.openFrm = function()
   {
        $scope.form = {id:'',employee_id:'',feedback_by:'',rating:'',template:''};
        $scope.showFrm = 1;
   }
    
   $scope.closeFrm = function()
   {
        $scope.form = {id:'',employee_id:'',feedback_by:'',rating:'',template:''};
        $scope.showFrm = 0;
   }
   
   $scope.resetAlert = function()
   {
       $scope.successes = errors = [];
   }
   
   
}]);