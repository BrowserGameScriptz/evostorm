var evostormApp = angular.module('evostormApp', ['ngRoute']);


evostormApp.config(function ($routeProvider) {
    $routeProvider.when('/', {
        templateUrl: 'app/pages/map.html',
        controller: 'MapController'
    })
        .when('/buildings', {
            templateUrl: 'app/pages/buildings.html',
            controller: 'BuildingsController'
        })
        .when('/missions', {
            templateUrl: 'app/pages/missions.html',
            controller: 'MissionsController'
        })
        .when('/tiles/:tile_id', {
            templateUrl: 'app/pages/tile.html',
            controller: 'TilesController'
        })
});


evostormApp.directive("statsBox", function () {
    return {
        restrict: 'E',
        templateUrl: 'app/stats/directives/statsbox.html',
        replace: true
    }
});

evostormApp.directive("logoutBox", function () {
    return {
        restrict: 'E',
        templateUrl: 'app/auth/directives/logoutbox.html',
        replace: true
    }
});

evostormApp.directive("mainMenu", function () {
    return {
        restrict: 'E',
        templateUrl: 'app/menu/directives/mainmenu.html',
        replace: true
    }
});

evostormApp.controller('StatsController', ['$scope', '$http', '$timeout', '$interval', function ($scope, $http, $timeout, $interval) {
    var main = this;

    $scope.resources = [];

    $scope.geUserResources = function () {
        $http.post('/api/user/resources').success(function (data) {
            $scope.resources = data;
        });
    }

    $timeout($scope.geUserResources);
    $interval($scope.geUserResources, 60000);

}]);


evostormApp.controller('AuthController', ['$scope', '$http', '$window', function ($scope, $http, $window) {
    var main = this;

    $scope.logout = function () {
        $http.post('/logout').success(function (data) {
            $window.location.href = '/';
        });
    };

}]);

evostormApp.controller('MapController', ['$scope', '$http', '$timeout', '$location', function ($scope, $http, $timeout, $location) {

    $scope.geUserMap = function () {
        $http.post('/api/user/map').success(function (data) {
            var map = bonsai.run(document.getElementById('main-map'), {
                url: '/js/user-map-renderer.js',
                mapData: data,
                width: 1100,
                height: 1000
            });

            // emitted before code gets executed
            map.on('load', function () {
                // receive event from the runner context
                map.on('message:tile_click', function (data) {
                    $location.path('/tiles/' + data.id);
                    $scope.$apply();
                });
            });
        });
    }

    $timeout($scope.geUserMap);

}]);

evostormApp.controller('BuildingsController', ['$scope', '$http', '$window', function ($scope, $http, $window) {
    $scope.buildings = [];

    $http.post('/api/user/buildings').success(function (data) {
        if (data.error) {
            alert(data.error);
        } else {
            $scope.buildings = data.buildings;
        }
    });

}]);

evostormApp.controller('MissionsController', ['$scope', '$http', '$window', function ($scope, $http, $window, $timeout) {
    $scope.missions_in_progress = [];
    $scope.missions_ended = [];

    $http.post('/api/user/missions').success(function (data) {
        if (data.error) {
            alert(data.error);
        } else {
            $scope.missions_in_progress = data.missions_in_progress;
            $scope.missions_ended = data.missions_ended;
        }
    });

    $scope.abortMission = function (mission_id) {
        if (confirm("Are you sure you want to abort this mission?")) {
            $http.post('/api/user/mission/abort/' + mission_id).success(function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    $scope.tile = data;
                }
            });
        }
    }
}]);

evostormApp.controller('TilesController', ['$scope', '$routeParams', '$timeout', '$http', '$route', function ($scope, $routeParams, $timeout, $http, $route) {
    $scope.tile = [];

    $scope.geTileInfo = function () {
        $http.post('/api/tile/info/' + $routeParams.tile_id).success(function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                $scope.tile = data;
            }
        });
    }

    $scope.build = function (building_level_id, tile_id) {
        $http.post('/api/build/' + building_level_id + '/' + tile_id).success(function (data) {
            if (data.error) {
                alert(data.error);
            } else if (data.success) {
                $route.reload();
            }
        });
    }

    $scope.captureMission = function (tile_id) {
        $http.post('/api/mission/capture/' + tile_id).success(function (data) {
            if (data.error) {
                alert(data.error);
            } else if (data.success) {
                $route.reload();
            }
        });
    }

    $scope.estimateMission = function (tile_id) {
        $http.post('/api/mission/estimate_resources/' + tile_id).success(function (data) {
            if (data.error) {
                alert(data.error);
            } else if (data.success) {
                $route.reload();
            }
        });
    }

    $timeout($scope.geTileInfo);
}]);