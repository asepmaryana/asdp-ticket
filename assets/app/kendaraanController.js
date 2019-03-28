angular.module('app.controller', ['ui.bootstrap','datatables'])
.controller('KendaraanController', ['$rootScope','$scope','$http','$stateParams','$modal','$cookies','$state', function($rootScope,$scope,$http,$stateParams,$modal,$cookies,$state){
	if($cookies.token == null) $state.go('signin');
	$rootScope.idKapal		= $stateParams.idKapal;
	$rootScope.idDermaga	= $stateParams.idDermaga;
	
	var id_layanan			= '2';
	var id_kapal			= $stateParams.idKapal;
	var id_dermaga			= $stateParams.idDermaga;
	
	$http.get(BASE_URL+'/api/kapal/info/'+$stateParams.idKapal).success(function(data){
		$rootScope.kapal = data;
	});
	$http.get(BASE_URL+'/api/dermaga/info/'+$stateParams.idDermaga).success(function(data){
		$rootScope.dermaga = data;
	});
	
	$rootScope.judul= 'Data Kendaraan';
	$scope.crit		= {tanggal:moment().format('YYYY-MM-DD'), status:'semua'};
	$scope.rows		= [];
	$scope.mode		= '';
	$scope.buildUrl	= function(crit) {
		return BASE_URL+'/api/tiket/lists/'+id_layanan+'/'+id_kapal+'/'+id_dermaga+'/'+crit.tanggal+'/'+crit.status;
	}
	$scope.view		= function(crit, doc) {
		if(doc == '') {
			$scope.mode		= 'show';
			$http.get($scope.buildUrl(crit)).success(function(data){
				$scope.rows = data;			
			});
		}
		else window.open($scope.buildUrl(crit)+'/'+doc);
	}
	$scope.print	= function(){
		$scope.mode		= 'print';
		var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {mode: mode,popClose: close};
        $("#printableKendaraan").printArea(options);
	}
	$scope.open = function (o, s) {
		var modalInstance = $modal.open({
			templateUrl: BASE_URL+'/assets/views/kendaraanDlg.html',
            controller: 'KendaraanDialogController',
			size: s,
			resolve: {
				data: function() {
					return o;
				}
			}
		});
		modalInstance.result.then(function(selectedObject) {
			
		});
	}
}])
.controller('KendaraanDialogController', ['$scope', '$http', '$modalInstance', 'data', function($scope, $http, $modalInstance, data){
	console.log(data);
	var original 	= data;
	$scope.data    	= angular.copy(data);
	$scope.rows		= [];
	$http.post(BASE_URL+'/api/kendaraan/penumpang', data).success(function(data){
		$scope.rows = data;			
	});
	$scope.cancel 	= function () {
		$modalInstance.dismiss('Close');
	};
	$scope.title = 'Data Penumpang Kendaraan';
	moment.locale('id');
	$scope.tanggal	= moment(data.tgl_berangkat).format('dddd[,] Do MMMM YYYY');
	
	$scope.buttonText = (angular.isDefined(data)) ? 'Update' : 'Save';
	$scope.isClean = function() {
		return angular.equals(original, $scope.data);
	}
}])
;