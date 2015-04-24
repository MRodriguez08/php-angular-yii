(function(){
    'use strict';

    angular.module('angularYiiApp')
        .config(function ($stateProvider) {
            $stateProvider
                .state('brand.list', {
                    parent: 'brand',
                    url: '/listBrand',
                    data: {
                        pageTitle: 'brand.title.list'
                    },
                    views: {
                        'content@': {
                            templateUrl: 'app/brand/list/list.html',
                            controller: 'ListBrandController'
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