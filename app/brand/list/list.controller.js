(function() { 
    'use strict';

    angular.module('angularYiiApp')
    .controller('ListBrandController', ['$scope', '$state', '$log', '$translate', 'BrandService', function ( $scope, $state, $log, $translate, BrandService) {
    	
    	/**
    	 * Update action
    	 */
    	$scope.delete = function( id ) {
    		
            bootbox.confirm("Are you sure?", function(result) {
                if (result){
                    BrandService.delete({id : id}).then(function (response) {
                    bootbox.dialog({
                              message: "Plan eliminado con exito",
                              title: "Planes",
                              buttons: {
                                success: {
                                  label: "Aceptar",
                                  className: "btn-success",
                                  callback: function() {		
                                      $state.reload();
                                      $scope.planModel = {};
                                  }
                                }
                              }
                    });		    	
                    }).catch(function(response) {
                        switch(response.status) {
                            case 500:
                                alert('Error interno de la aplicacion');
                                break;
                            case 400:
                                $scope.error = true;
                                $scope.errorMessage = response.data.message;
                                break;
                            default:
                        }
                        $scope.processing = false;
                    });
                }
            });
        };
        
    	/**
    	 * Update action
    	 */
    	$scope.go = function( rt , p1 ) {
            $state.go(rt , {id: p1});
        };
        
    	$scope.brandsList = '';
    	$scope.gridScope = $scope;
    	$scope.gridOptions = {
            enableFiltering: true,
            enableSorting: true,
            columnDefs: [
              { displayName: $translate.instant('brand.grid.id'), field: 'id', maxWidth : 20 },
              { displayName: $translate.instant('brand.grid.name'), field: 'name', minWidth : 80},
              { displayName: $translate.instant('brand.grid.nationality'), field: 'nationality', minWidth : 80 },
              { name: ' ', enableFiltering: false, enableSorting: false,enableHiding: false, cellTemplate:'<span class="grid-action-glyphicon glyphicon glyphicon-pencil" aria-hidden="true" ng-click="grid.appScope.go(\'customer.update\',row.entity.id)"></span>', maxWidth : 5 },  
              { name: '  ', enableFiltering: false, enableSorting: false,enableHiding: false, cellTemplate:'<span class="grid-action-glyphicon glyphicon glyphicon-remove" aria-hidden="true" ng-click="grid.appScope.delete(row.entity.id)"></span>', maxWidth : 5  }
            ],
            data: 'brandsList',
        };
    	
    	
    	
    	/**
    	 * Refresh grid action
    	 */
    	$scope.refresh = function () {        	
            $scope.updatingPlans = true;
            $scope.errorMessage = '';
            BrandService.getAll({} , function (response) {
                $scope.brandsList = response;
                $scope.updatingPlans = false;
            }, function (response) {
            	if (response.status == 401){
            		alert(response.data);            		
            	} else {            		
            		$scope.brandsList = response.data;
                    $scope.updatingPlans = false;
            	}                
            });
        };
        $scope.refresh();        
    }]);
})() ;