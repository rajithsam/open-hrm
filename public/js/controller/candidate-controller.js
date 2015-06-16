angular.module('candidate',[]).
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
controller('candidateCtrl',['$scope','webservice',function($scope,webservice){
    $scope.showFrm = 0;
    $scope.form = {id:'',name:'',email:'',phone:'',vacancy:'',keyword:'',description:'',source:'',referer:''};
    $scope.sources = ['NEWS','ONLINE','PERSON','OTHERS'];
    
    var loadVacncies = function()
    {
        var response = webservice.get(BASE+'vacanicies.json');
        response.success(function(res){
           $scope.vacancies = res; 
        });
    }
    
    var loadCandidates = function()
    {
        var response = webservice.get(BASE+'candidates.json');
        response.success(function(res){
            $scope.candidates = res;
        });
    }
    
    $scope.openFrm = function()
    {
        loadVacncies();
        $scope.showFrm = 1;
        $scope.form = {id:'',name:'',email:'',phone:'',vacancy:'',keyword:'',description:'',source:'',referer:''};
    }
    
    $scope.closeFrm = function()
    {
        $scope.showFrm = 0;
        $scope.form = {id:'',name:'',email:'',phone:'',vacancy:'',keyword:'',description:'',source:'',referer:''};
    }
    
    $scope.saveCandidate = function()
    {
        $scope.successes = $scope.errors = [];
        var response = webservice.post(BASE+'candidate/save-candidate',$scope.form); 
        response.success(function(res){
            $scope.successes = res.message;
            loadCandidates();
        }).error(function(res){
            
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = $scope.errors = [];
    }
}]);