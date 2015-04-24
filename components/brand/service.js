(function(){
  'use strict';

  angular.module('angularYiiApp')
    .factory('BrandService', ['$rootScope', '$http', 'BrandResource', function ($rootScope, $http, BrandResource) {
        return {
            getAll: function (data, callback) {
                var cb = callback || angular.noop;

                return BrandResource.query(data,
                    function (response) {
                        return cb(response);
                    },
                    function (err) {
                        return cb(err);
                    }.bind(this)).$promise;
            },
            get: function (data, callback) {
                var cb = callback || angular.noop;

                return BrandResource.get(data,
                    function (response) {
                        return cb(response);
                    },
                    function (err) {
                        return cb(err);
                    }.bind(this)).$promise;
            },
            create: function (data, callback) {
                var cb = callback || angular.noop;

                return BrandResource.save(data,
                    function (response) {
                        return cb(response);
                    },
                    function (err) {
                        return cb(err);
                    }.bind(this)).$promise;
            },
            update: function (data, callback) {
                var cb = callback || angular.noop;

                return BrandResource.update(data,
                    function (response) {
                        return cb(response);
                    },
                    function (err) {
                        return cb(err);
                    }.bind(this)).$promise;
            },
            delete: function (data, callback) {
                var cb = callback || angular.noop;

                return BrandResource.delete(data,
                    function (response) {
                        return cb(response);
                    },
                    function (err) {
                        return cb(err);
                    }.bind(this)).$promise;
            },
        };
    }]);
  
})();