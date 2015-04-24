(function(){
  'use strict';

  angular.module('angularYiiApp')
  	.factory('BrandResource', function ($resource) {
  	    return $resource('services/brand/:id', {id:'@_id'}, {
  	    	update: {
  	          method: 'PUT' // this method issues a PUT request
  	        }
  	    });
  	});
  
})();