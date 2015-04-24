(function() { 
    'use strict';

    angular.module('angularYiiApp')
    .controller('UpdateBrandController', ['$scope', '$log', '$state', '$stateParams', 'BrandService', function ( $scope, $log, $state, $stateParams, BrandService) {
    	
    	var i = $stateParams.id;    	
    	$scope.error = false;
    	$scope.succes = false;
    	$scope.processing = true;
    	$scope.planModel = {};    	

        BrandService.get({id : $stateParams.id}).then(function (response) {
            $scope.model = response;
        }).catch(function(response) {
            alert('Error interno de la aplicacion');
            $scope.processing = false;
        });    	 	
    	
    	$scope.update = function () {
    		BrandService.update($scope.model).then(function (response) {
    			bootbox.dialog({
    				  message: "Cliente modificado con exito",
    				  title: "Clientes",
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
    		
        };      
        
    }]);
})() ;