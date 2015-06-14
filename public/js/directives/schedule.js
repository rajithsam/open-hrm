angular.module('schedule',[])
.directive('scheduleRoster',function(){
    return{
        restrict:"EA",
        scope:{
            title:'=',
            
        },
        replace:true,
        templateUrl: BASE+'get-template/schedule',
        controller:function($scope,$http,$sce){
            var current_date_obj = new Date();
            $scope.cur_date = 1;
            $scope.days = ['Sunday','Monday','Tuesday','Wednessday','Thursday','Friday','Saturday'];
            $scope.months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            $scope.week = 4;
            var cur_date = 0;
            var thisYear = current_date_obj.getFullYear();
            var thisMonth = current_date_obj.getMonth();
            $scope.firstDateObj = new Date(thisYear,thisMonth,1);
            $scope.lastDateObj = new Date(thisYear, thisMonth+1,0);
            $scope.shifts = [];
            $scope.showFrm = 0;
            $scope.form = {employee:'',shift:'',shift_date:''};
            
            var getBlankField = function()
            {
                return blankCount = $scope.firstDateObj.getDay();

            }
            
            var drawRosterGrid = function()
            {   
                    var trHtml = '';
                    var blankCount = getBlankField();
                    if(blankCount)
                    {
                        trHtml += '<tr><td><ul><li>&nbsp</li>';
                        for(var shift in $scope.shifts)
                        {
                            var shfit_name = $scope.shifts[shift].shift_name;
                            trHtml += '<li>'+shfit_name+'</li>';
                        }
                        trHtml += '</ul></td>';
                        for(var i=0; i<blankCount; i++)
                        {
                            trHtml += '<td><span></span></td>';
                             cur_date++;
                             
                        }
                    }
                    
                
                
                for(var idate = $scope.firstDateObj.getDate(); idate<=$scope.lastDateObj.getDate();idate++)
                {
                    
                    
                     
                    if(cur_date%7 == 0)
                    {   
                       if(blankCount)
                       {
                        trHtml +='</tr>';     
                       }
                        
                        
                        trHtml +='<tr><td><ul><li>&nbsp</li>';
                        
                        for(var shift in $scope.shifts)
                        {
                            var shfit_name = $scope.shifts[shift].shift_name;
                            trHtml += '<li>'+shfit_name+'</li>';
                        }
                        trHtml +='</ul></td>';
                    }
                    
                    trHtml += '<td><span>'+$scope.months[$scope.firstDateObj.getMonth()]+'-'+idate+'</span><ul>';
                    for(var shift in $scope.shifts)
                    {
                        var shfit_name = $scope.shifts[shift].shift_name;
                        trHtml += '<li>&nbsp;</li>';
                    }
                    trHtml +='</ul></td>';
                    cur_date++
                }
                trHtml += '</tr>';
                
                
                $scope.trHtml = $sce.trustAsHtml(trHtml);
            }
            
            $http({
               url: BASE+'workshifts.json',
            }).success(function(res){
               $scope.shifts=res;

                
                drawRosterGrid();
            });
            
            $scope.prevMonth = function()
            {
                cur_date = 0;
                thisMonth = $scope.firstDateObj.getMonth()-1;
                thisYear = $scope.firstDateObj.getFullYear();
                $scope.firstDateObj = new Date(thisYear,thisMonth,1);
                drawRosterGrid();
                
                
            }
            
            $scope.nextMonth = function()
            {
                cur_date = 0;
                thisMonth = $scope.firstDateObj.getMonth()+1;
                thisYear = $scope.firstDateObj.getFullYear();
                $scope.firstDateObj = new Date(thisYear,thisMonth,1);
                drawRosterGrid();
                
            }
            
            $scope.assignShift = function()
            {
                $http({
                   url: BASE+'departments.json' 
                }).success(function(res){
                    
                    $scope.departments = res;
                    $scope.showFrm = 1;
                    
                    angular.element('.datepicker').datepicker({dateFormat:'yy-mm-dd'});
                        
                });
                
                
                $('html,body').animate({scorllTop:'0px'});   
            }
            
            $scope.getEmployeeByDepartment = function()
            {
                $http({
                    url:BASE+'employee/department/'+$scope.form.department
                }).success(function(res){
                    $scope.employees = res;
                });
            }
            
            $scope.saveAssignWorkShift = function()
            {
                $scope.successes = [];
                $http({
                   url : BASE+'employee/assign-work-shift',
                   data: $scope.form,
                   method:'post'
                }).success(function(res){
                    $scope.successes = res.message;
                });
            }
            
            $scope.closeFrm = function()
            {
                $scope.showFrm = 0;
                $scope.form = {employee:'',shift:'',shift_date:''};
            }
            
        }
    }
});