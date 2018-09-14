angular.module('app.controller', ['ui.bootstrap','datatables'])
.controller('PenumpangController', ['$rootScope','$scope','$http','$stateParams', function($rootScope,$scope,$http,$stateParams){
	
	$rootScope.idKapal		= $stateParams.idKapal;
	$rootScope.idDermaga	= $stateParams.idDermaga;
	
	var id_layanan			= '1';
	var id_kapal			= $stateParams.idKapal;
	var id_dermaga			= $stateParams.idDermaga;
	
	$http.get(BASE_URL+'/api/kapal/info/'+$stateParams.idKapal).success(function(data){
		$rootScope.kapal = data;
	});
	$http.get(BASE_URL+'/api/dermaga/info/'+$stateParams.idDermaga).success(function(data){
		$rootScope.dermaga = data;
	});
	
	$rootScope.judul= 'Data Penumpang';
	$scope.crit		= {tanggal:moment().format('YYYY-MM-DD'), status:'semua'};
	$scope.rows		= [];
	$scope.mode		= '';
	$scope.buildUrl	= function(crit) {
		console.log(BASE_URL+'/api/tiket/list/'+id_layanan+'/'+id_kapal+'/'+id_dermaga+'/'+crit.tanggal+'/'+crit.status);
		return BASE_URL+'/api/tiket/lists/'+id_layanan+'/'+id_kapal+'/'+id_dermaga+'/'+crit.tanggal+'/'+crit.status;
	}
	$scope.view		= function(crit) {
		$scope.mode		= 'show';
		$http.get($scope.buildUrl(crit)).success(function(data){
			$scope.rows = data;			
		});
	}
}])
;