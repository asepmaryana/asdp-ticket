'use strict';

angular.module('app', ['ui.router', 'oc.lazyLoad', 'ngAnimate', 'ngCookies', 'ui.bootstrap', 'ui.select2','app.constant', 'app.controller', 'app.directive', 'angularMoment'])
.run(function($rootScope, $state, $interval, $timeout, $cookies, $http, amMoment) {	
	amMoment.changeLocale('id');
	$rootScope.$on('loading:show', function() { $(".preloader").show(); });
	$rootScope.$on('loading:hide', function() { $(".preloader").hide(); });
	$rootScope.$on('$locationChangeStart', function(event, next, prev) {});
	$rootScope.$on('session-expired', function(event, args) {
		$rootScope.$broadcast('timer-disabled', {});
		delete $rootScope.user;
		delete $cookies.token;
		delete $http.defaults.headers.common['X-Authorization'];
		$timeout( function(){ window.location.href = BASE_URL; }, 1000);
	});
	$rootScope.$on('auth-not-authenticated', function(event, args) {
		delete $cookies.token;
		$state.go('signin');
	});
	$rootScope.$on('timer-disabled', function(event, args) {
		if (angular.isDefined($rootScope.jamTimer)) $interval.cancel($rootScope.jamTimer);
	});
})
.filter('tanggal', function () { 
    return function (text) {    	
        return (text == '0000-00-00') ? '' : moment(text).format('DD-MM-YYYY');
    };    
})
.config(function($stateProvider,$urlRouterProvider,$httpProvider) {
	
    //$urlRouterProvider.when('/app', '/app/entrance');
    $urlRouterProvider.otherwise('/welcome/signin');
    
    $stateProvider
		.state('welcome', {
	    	abstract: true,
	    	url: '/welcome',
	    	templateUrl: 'assets/views/welcome.html',
	    	controller: 'WelcomeController'
	    })
	    .state('signin', {
	    	url: '/signin',
			parent: 'welcome',
	    	templateUrl: 'assets/views/signin.html',
	    	controller: 'SignInController'
	    })
		.state('reset', {
	    	url: '/reset',
			parent: 'welcome',
	    	templateUrl: 'assets/views/reset.html',
	    	controller: 'ResetController'
	    })
		.state('select', {
	    	url: '/select',
			parent: 'welcome',
	    	templateUrl: 'assets/views/select.html',
	    	controller: 'SelectController'
	    })
	    .state('app', {
	    	abstract: true,
	    	url: '/app',
	    	templateUrl: 'assets/views/home.html',
	    	controller: 'HomeController'
	    })
	    .state('app.entrance', {
        	url: '/entrance/:idKapal/:idDermaga',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/entrance.html',
					controller: 'EntranceController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/entranceController.js']);
				}]
        	}
        })
        .state('app.penumpang', {
        	url: '/penumpang/:idKapal/:idDermaga',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/penumpang.html',
					controller: 'PenumpangController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/penumpangController.js']);
				}]
        	}
        })
        .state('app.kendaraan', {
        	url: '/kendaraan/:idKapal/:idDermaga',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/kendaraan.html',
					controller: 'KendaraanController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/kendaraanController.js']);
				}]
        	}
        })
        .state('app.rekap', {
        	url: '/rekap/:idKapal/:idDermaga',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/rekap.html',
					controller: 'RekapController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/rekapController.js']);
				}]
        	}
        })
        .state('app.refundSubmission', {
        	url: '/refund/submission',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/refundSubmission.html',
					controller: 'RefundSubmissionController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/refundSubmissionController.js']);
				}]
        	}
        })
        .state('app.refundList', {
        	url: '/refund/list',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/refundList.html',
					controller: 'RefundListController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/refundListController.js']);
				}]
        	}
        })
        .state('app.refundPrint', {
        	url: '/refund/print',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/refundPrint.html',
					controller: 'RefundPrintController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/refundPrintController.js']);
				}]
        	}
        })
        .state('app.refundProcess', {
        	url: '/refund/process',
        	parent: 'app',
			views:{
				'page':{
					templateUrl: 'assets/views/refundProcess.html',
					controller: 'RefundProcessController',
				}
			},
        	resolve: {
        		loadModule: ['$ocLazyLoad', function($ocLazyLoad){
					return $ocLazyLoad.load(['assets/app/refundProcessController.js']);
				}]
        	}
        })
        ;
    
    $httpProvider.interceptors.push(['$rootScope', '$q', '$cookies', 'EVENTS', function ($rootScope, $q, $cookies, EVENTS) {
		return {
			'request': function (config) {
				$rootScope.$broadcast('loading:show');
				config.headers = config.headers || {};
				return config;
			},
			'response': function(response) {
				$rootScope.$broadcast('loading:hide');
				return response;
			},
			'responseError': function (response) {
				$rootScope.$broadcast('loading:hide');
				$rootScope.$broadcast({
					401: EVENTS.notAuthenticated,
					403: EVENTS.notAuthorized,
					500: EVENTS.internalError
				}[response.status], response);
								
				return $q.reject(response);
			}
		};
    }]);
    
  })
  ;