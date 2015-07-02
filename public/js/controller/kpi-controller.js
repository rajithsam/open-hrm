angular.module('kpi',[])
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
.controller('kpiCtrl',['$scope','webservice',function($scope,webservice){
    $scope.kpi = [];
    
    
    var loadKpi = function()
    {
        var response = webservice.get(BASE + 'kpi.json');
        response.success(function(res){
            $scope.kpi = res;
        });
    }
    
    loadKpi();
    
}]);