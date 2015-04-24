(function(){
  'use strict';

  angular.module('angularYiiApp')
    .config(function ($stateProvider) {
        $stateProvider
            .state('brand.create', {
                parent: 'brand',
                url: '/createBrand',
                data: {
                    pageTitle: 'brand.title.create'
                },
                views: {
                    'content@': {
                        templateUrl: 'app/brand/create/create.html',
                        controller: 'CreateBrandController'
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