var legalGameQuit = false;
var app = angular.module("ChessApp", ['ngRoute'])
.config(function($routeProvider, $locationProvider) {
	$routeProvider
		.when('/about', {
			templateUrl : 'templates/about.html'
		})
		.when('/profile', {
			templateUrl : 'templates/profile.html',
			controller : 'UserProfileCtrl'
		})
		.when('/profile/:userId', {
			templateUrl : 'templates/profile.html',
			controller : 'UserProfileCtrl'
		})
		.when('/profile/:userId', {
			templateUrl : 'templates/profile.html',
			controller : 'UserProfileCtrl'
		})
		.when('/', {
			redirectTo : '/about'
		})
		.when('/game/:gameId', {
			templateUrl : 'templates/game.html',
			controller : 'GameStateCtrl'
		})
		.otherwise({
			redirectTp : '/about'
		})
	})
.run(['$http', '$rootScope', '$sce', '$location', '$route','$window',
    function($http, $rootScope, $sce, $location, $route,$window) {
		$rootScope.isOnGamePage = false;
		$rootScope.msg = 'Leaving the page will quit you from the game. Are you sure you want to leave?';
        //$rootScope.$on('$routeChangeStart', function(event, next, current) {
//			if(current != null && current.templateUrl == "templates/game.html" && next != null && next.templateUrl.indexOf("templates/game.html") < 0 && !legalGameQuit)
//			{
//				if(!confirm($rootScope.msg))
//				{
//					event.preventDefault();
//				    return;
//				}
//				else
//					$rootScope.processLeaveGame();
//			}
//			if(legalGameQuit)
//				legalGameQuit = false;
//        });
//		$rootScope.$on('$routeChangeSuccess', function(event, current, previous) {
//			if(current != null && current.templateUrl =="templates/game.html")
//				$rootScope.isOnGamePage = true;
//			else
//				$rootScope.isOnGamePage = false;
//        });
//		$(window).on('beforeunload', function(){
//			if($rootScope.isOnGamePage && !legalGameQuit)
//				return $rootScope.msg;
//		});
//		$(window).on('unload', function(){
//			if($rootScope.isOnGamePage && !legalGameQuit)
//				return $rootScope.processLeaveGame();
//			if(legalGameQuit)
//				legalGameQuit = false;
//		});
//		$rootScope.processLeaveGame = function(){
//			console.log("leaving");
//		};
    }]);