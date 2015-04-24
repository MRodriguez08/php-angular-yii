(function(){
  'use strict';

  angular.module('angularYiiApp')
    .config(function ($stateProvider) {
        $stateProvider
            .state('brand.update', {
                parent: 'brand',
                url: '/updateBrand/:id',
                data: {
                    pageTitle: 'brand.title.update'
                },
                views: {
                    'content@': {
                        templateUrl: 'app/brand/update/update.html',
                        controller: 'UpdateBrandController'
                    }
                },
                resolve: {
                    translatePartialLoader: ['$translate', '$translatePartialLoader', function ($translate, $translatePartialLoader) {
                        $translatePartialLoader.addPart('brand');
                        return $translate.refresh();
                    }]
                }
            });
    });

})();