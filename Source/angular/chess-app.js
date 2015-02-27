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
			templateUrl : 'templates/game.html'
		})
		.otherwise({
			redirectTp : '/about'
		})
	});