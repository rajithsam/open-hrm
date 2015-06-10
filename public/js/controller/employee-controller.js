angular.module('employee').
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
controller('employeeCtrl',['$scope','webservice','$sce','FileUploader',function($scope,webservice,$sce,FileUploader){
    
    
    
    $scope.showForm = 0;
    $scope.sources = ['NEWS','ONLINE','PERSON','OTHERS'];
    $scope.form = {employee_id:'',name:'',present_address:'',
                permanent_address:'',email:'',phone:'',source:'',source_name:''};
    $scope.tab = {avaiable_resource:1,assigned_resource:0};
    $scope.formTab = {basic:1,edu:0,work_exp:0};
    
    $scope.cancelFrm = function()
    {
        $scope.active_job = 0;
        $scope.showForm = 0;
        
    }
    
    $scope.openFrm = function()
    {
        
        $scope.showForm = 1;
   
    }
    
    var uploader = $scope.uploader = new FileUploader({
            url: BASE+'employee/save-photo',
            headers: {
              'X-CSRF-TOKEN': angular.element("input[name='_token']").val()
            },
     });
    
    
    $scope.selectTab = function(item)
    {
        $scope.tab = {avaiable_resource:0,assigned_resource:0};
        $scope.tab[item] = 1;
    }
    
    $scope.selectFormTab = function(item)
    {
        $scope.formTab = {basic:0,edu:0,work_exp:0};
        $scope.formTab[item] = 1;
    }
    
    var loadAvailableEmployees = function()
    {
        var response = webservice.get(BASE+'api/available-employees.json'); 
        response.success(function(res){
            $scope.available_employees = res;
        });
    }
    
    var loadAssignedEmployees = function()
    {
        var response = webservice.get(BASE+'api/assigned-employees.json'); 
        response.success(function(res){
            $scope.assigned_employees = res;
        });
    }
    
    uploader.onAfterAddingFile = function(fileItem) {
           uploader.queue = [];
           uploader.queue[0] = fileItem;
    };
    
    $scope.clearPhotoQueue = function()
    {
        uploader.queue=[];
    }
    
    $scope.saveEmployee = function()
    {
         $scope.errors = [];
         $scope.successes = [];
         
         uploader.onBeforeUploadItem = function(item) {
            item.url = BASE+'employee/update/basic'
            item.formData.push($scope.form);
         };
         
         uploader.onCompleteAll = function() {
            $scope.successes.push('Information Updated');
            uploader.queue = [];
         };
         
         uploader.onSuccessItem = function(fileItem, response, status, headers) {
            $scope.form.photo   = response; 
        };
        
         if(uploader.queue.length > 0)
         {
            uploader.uploadAll();
            
         }else{
             
             var response = webservice.post(BASE+'employee/update/basic',$scope.form);
             
             response.success(function(res){
                 
                 for(i in res)
                {
                    
                    if(i == "error")
                        $scope.errors.push($sce.trustAsHtml(res[i][0]));
                    else
                        $scope.successes.push(res[i][0]);
                }
               
                $scope.showForm = 0; 
                loadAvailableEmployees();
             }).error(function(res){
                 for(i in res)
                        $scope.errors.push($sce.trustAsHtml(res[i][0]));
                   
                $("html,body").animate({ scrollTop: "0px" });
             });
             
         }
         $("html,body").animate({ scrollTop: "0px" });
         $scope.showForm = 0; 
    }
    
     
    
    $scope.viewEmployee = function(employee)
    {
        $scope.form = employee;
        $scope.showForm = 1;
        $scope.active_job = 0;
        $scope.edus = employee.education;
        $scope.exps = employee.work_experience;
       
    }
    
    $scope.resetAlert = function()
    {
        $scope.successes = [];
        $scope.errors = [];
    }
    
    loadAvailableEmployees();
    loadAssignedEmployees();
    
    /******* Education ******/
    
    $scope.edus = [{institution_name:'',pass_year:'',degree_name:'',grade:''}];
    
    $scope.rowEdu = function()
    {
        $scope.edus.push({institution_name:'',pass_year:'',degree_name:'',grade:''});
    }
    
    $scope.removeEduRow = function(index)
    {
        $scope.edus.splice(index,1);
    }
    
    $scope.saveEducation = function()
    {
        var response = webservice.post(BASE+'employee/update/edu',{edus:$scope.edus,id:$scope.form.id});
        response.success(function(res){
            
        }).error(function(res){
            
        });
    }
    
    
    /******* Work Experience ******/
    
    $scope.exps = [{work_title:'',org_name:'',year_exp:''}];
    
    $scope.rowExp = function()
    {
        $scope.exps.push({work_title:'',org_name:'',year_exp:''});
    }
    
    $scope.removeExpRow = function(index)
    {
        $scope.exps.splice(index,1);
    }
    
    $scope.saveExperience = function()
    {
        var response = webservice.post(BASE+'employee/update/exp',{exps:$scope.exps,id:$scope.form.id});
        response.success(function(res){
            
        }).error(function(res){
            
        });
    }
    
    /**** active jobs ****/
    
    $scope.active_job = 0;
    $scope.job_details = {department_id:'',designation_id:'',basic_salary:'',job_start:'',job_end:'',verifier:''};
    $scope.assignResource = function(employee)
    {
        $scope.form = employee;
        $scope.active_job = 1;
        $scope.showForm = 1;
        
        var response  = webservice.get(BASE+'departments.json');
        response.success(function(res){
            $scope.departments = res;   
            $("input[name='job_start'],input[name='job_end']").datepicker({ dateFormat:'yy-mm-dd'});
        });
        
    }
    
    $scope.getDesignations = function()
    {
        var response = webservice.get(BASE+'designations/'+$scope.job_details.department_id);
        response.success(function(res){
           $scope.designations = res; 
        }).error(function(res){
            
        });
    
    
    }
    
    $scope.saveAssignJob = function()
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'employee/update/assign',{id:$scope.form.id,job_details:$scope.job_details});
    
        response.success(function(res){
            $scope.successes = res.message;
            $scope.tab = {available_employees:0,assigned_employees:1}
        }).error(function(res){
            
        });
    }
    
    $scope.releaseResource = function(e)
    {
        $scope.successes = [];
        var response = webservice.post(BASE+'employee/update/release',{id:e.id});
        response.success(function(res){
            $scope.successes = res.message;
            $scope.tab = {available_employees:1,assigned_employees:0}
        }).error(function(res){
            
        });
    }
    
    $scope.getPhoto =function(e)
    {
        return BASE+'data/'+e.photo;
    }
    
    /***** sort ******/
    
    $scope.sortorder = "name";
    
    
    $scope.toggleSort = function(item)
    {
        switch(item)
        {
            case 'name':
                if($scope.sortorder == "name")
                    $scope.sortorder = "-name";
                else
                    $scope.sortorder = "name";
                break;
                
            case 'email':
                if($scope.sortorder == "email")
                    $scope.sortorder = "-email";
                else
                    $scope.sortorder = "email";
                break;
        }
        
    }
}]);