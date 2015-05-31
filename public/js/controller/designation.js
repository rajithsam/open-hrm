angular.module('designation',[]).
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
controller('designationCtrl',['$scope','webservice',function($scope,webservice){
    
    $scope.parent_department = [];
    $scope.form={id:'',title:'',quote:'',description:'',parent_department:[]};
    $scope.showForm = 0;
    var loadDepartments = function()
    {
        var response = webservice.get(BASE+'api/departments.json');
        response.success(function(res){
            
            $scope.departments = res;
           
        });
        
        $scope.parent_department = [];
        
       
    }
    
    var loadDesignations = function()
    {
        var response = webservice.get(BASE+'api/designations.json');
        response.success(function(res){
            
            $scope.designations = res;
           
        });
    }
    
    $scope.cancelFrm = function()
    {
        $scope.form={id:'',title:'',quote:'',description:'',parent_department:[]};
        $scope.showForm = 0;
        $scope.parent_department = [];
    }
    
    $scope.openFrm = function()
    {
        $scope.form={id:'',title:'',quote:'',description:'',parent_department:[]};
        $scope.showForm = 1;
        $scope.parent_department = [];
    }
    
    $scope.setDepartment = function(department)
    {
        var index = $scope.parent_department.indexOf(department.id);
        $scope.parent_department = [];
        $scope.parent_department.push(department.id);
        
        /*if(index == -1)
        {
            $scope.parent_department.push(department.id);
        }else{
            $scope.parent_department.splice(index,1);
        }*/
    }
    
    $scope.saveDesignation = function()
    {
        $scope.successes = [];
        $scope.errors = [];
        var response = null;
        
        if($scope.parent_department.length ==  0)
        {
            $scope.errors.push('Please select department');
            return false;
        }
        
        $scope.form.parent_department = $scope.parent_department;
        
        
        if($scope.form.id)
            response = webservice.post(BASE+'designation/update',$scope.form);
        else
            response = webservice.post(BASE+'designation/create',$scope.form);
            
        response.success(function(res){
            
            $scope.successes = res.message;
            $scope.form={id:'',title:'',quote:'',description:'',parent_department:[]};
            $scope.parent_department = [];
            $scope.showForm = 0;
            loadDesignations();
            
        }).
        error(function(res){
            
            for(i in res)
            {
                $scope.errors.push(res[i][0]);
            }
        });
    }
    
    $scope.editDesignation = function(designation)
    {
        
        $scope.form.id = designation.id;
        $scope.form.title = designation.title;
        
        $scope.form.description = designation.description;
        $scope.form.quota = designation.quota;
        $scope.form.parent_department.push(designation.department_id);
        $scope.parent_department = $scope.form.parent_department;
        $scope.showForm = 1;
    }
    
    $scope.deleteDesignation = function(designation)
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'designation/remove',designation);
        response.success(function(res){
            $scope.successes.push('Designation '+designation.title+' removed');
            loadDesignations();
        });
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    loadDesignations();
    loadDepartments();
    
}]);