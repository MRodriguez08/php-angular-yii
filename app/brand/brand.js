
(function(){
    'use strict';

    angular.module('angularYiiApp')
        .config(function ($stateProvider) {
            $stateProvider
                .state('brand', {
                    abstract: true,
                    parent: 'site'
                });
        });

})();