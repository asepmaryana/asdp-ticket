'use strict';

angular.module('app.controller', ['app.constant', 'ngCookies'])
.controller('WelcomeController', ['$rootScope','$scope', '$state', '$http', function ($rootScope, $scope, $state, $http){
	
}])
.controller('SignInController', ['$rootScope','$scope', '$state', '$http', '$cookies', function ($rootScope, $scope, $state, $http, $cookies){
	if($cookies.token != null) $state.go('select');
	$scope.data	= {username:'', password:'', remember:'0'};
	$scope.enterPressed = function (keyEvent) {
		if (keyEvent.keyCode == 13) $scope.login($scope.data);
	};
	$scope.login	= function(data) {
		if(data.username == '') swal('Exception', 'Username belum diisi !');
		else if(data.password == '') swal('Exception', 'Password belum diisi !');
		else 
		{
			//$state.go('select');
			$http.post(BASE_URL + '/api/auth/login', data)
			.success(function(res){
				$cookies.token = res.token;
				$http.defaults.headers.common['X-Authorization'] = res.token;
				$state.go('select');
			})
			.error(function(res){
				swal('Exception', res.message);
			});
		}
	};
}])
.controller('ResetController', ['$rootScope','$scope', '$location', '$http', '$cookies', function ($rootScope, $scope, $location, $http, $cookies){
	if($cookies.token != null) $state.go('select');
	$scope.data	= {username:''};
	$scope.enterPressed = function (keyEvent) {
		if (keyEvent.keyCode == 13) $scope.reset($scope.data);
	};
	$scope.reset = function(data){
		if(data.username == '') swal('Exception', 'Email belum anda isi !');
		else {
			$http.post(BASE_URL + '/api/auth/reset', data)
			.success(function(res){
				swal('Success', res.message);
				$state.go('signin');
			})
			.error(function(res){
				swal('Exception', res.message);
			});
		}
	}
}])
.controller('SelectController', ['$rootScope','$scope','$location','$http','$cookies','$state', function ($rootScope, $scope, $location, $http, $cookies,$state){
	if($cookies.token != null) $state.go('select');
	else $state.go('signin');
	
	$scope.data		= {id_kapal:'',id_dermaga:''};
	$scope.kapals	= [];
	$scope.dermagas	= [];
	$http.get(BASE_URL+'/api/kapal/lists').success(function(data){
		$scope.kapals = data;
	});
	$http.get(BASE_URL+'/api/dermaga/lists').success(function(data){
		$scope.dermagas = data;
	});
	$scope.go		= function(data) {
		$location.path('/app/entrance/'+data.id_kapal+'/'+data.id_dermaga);
	}
}])
.controller('HomeController', ['$rootScope','$scope','$http','$interval','$timeout','$location','$cookies','EVENTS', function ($rootScope,$scope,$http,$interval,$timeout,$location,$cookies,EVENTS) {
	
	$rootScope.kapal	= '';
	$rootScope.dermaga	= '';
	$rootScope.judul	= '';
	
	if($cookies.token == null) $state.go('signin');
	$rootScope.user = {};
	$http.get(BASE_URL+'/api/auth/info').success(function(data){
		$rootScope.user = data;
		userInfo = data;
	});
	$scope.logout = function () {
		swal({
			title: "Konfirmasi",
			text: "Apakah anda mau keluar ?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			showCancelButton: true,
		    confirmButtonColor: '#DD6B55',
		    confirmButtonText: 'Ya',
		    cancelButtonText: 'Tidak',
		    closeOnConfirm: true,
		    closeOnCancel: true
		},
		function(isConfirm){
			if (isConfirm) {
				$http.get(BASE_URL + '/api/auth/logout')
				.success(function (res) {
					swal('Success', 'Anda telah berhasil logout.');
					$rootScope.$broadcast('session-expired', {});
				})
				.error(function (res) {
					$rootScope.$broadcast('session-expired', {});
				});
			}
		});
	};
	$scope.$on(EVENTS.notAuthorized, function(event) {
		//swal('Exception', 'Anda tidak diijinkan untuk membuka resource tersebut.');
		$rootScope.$broadcast('session-expired', {});
	});
	$scope.$on(EVENTS.notAuthenticated, function(event) {
		swal('Exception', 'Sesi anda telah berakhir, silahkan login kembali.');
		$rootScope.$broadcast('session-expired', {});
	});
	$scope.$on(EVENTS.internalError, function(event) {
		swal('Exception', 'Error di sisi server.');
	});
	$scope.$on(EVENTS.profileChanged, function(event, args) {
		$rootScope.user = args.user;
	});
	$scope.redirect	= function(milis) {
		$timeout( function(){ window.location.href = BASE_URL; }, milis);
	}
	$rootScope.jamTimer = $interval(function () {
		moment.locale('id');
		$rootScope.tanggal	= moment().format('dddd[,] Do-MM-YYYY');
		$rootScope.jam		= moment().format('HH:mm:ss');
	}, 1000);
}])
;