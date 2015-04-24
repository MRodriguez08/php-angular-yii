(function() { 
    'use strict';

    angular.module('angularYiiApp')
    .controller('CreateBrandController', ['$scope', '$log', '$state', 'BrandService', function ( $scope, $log, $state, BrandService) {
    	
    	$scope.error = false;
    	$scope.succes = false;
    	$scope.processing = true;
    	$scope.model = {};
    	
    	
    	$scope.create = function () {
            
    		BrandService.create($scope.model).then(function (response) {
    			bootbox.dialog({
    				  message: "Cliente ingresado con exito",
    				  title: "Clientes",
    				  buttons: {
    				    success: {
    				      label: "Aceptar",
    				      className: "btn-success",
    				      callback: function() {		
    				    	  $state.reload();
    				    	  $scope.model = {};
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