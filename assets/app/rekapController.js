angular.module('app.controller', ['ui.bootstrap','datatables'])
.controller('RekapController', ['$rootScope','$scope','$http','$stateParams', function($rootScope,$scope,$http,$stateParams){
	
	$rootScope.idKapal		= $stateParams.idKapal;
	$rootScope.idDermaga	= $stateParams.idDermaga;
	
	var id_kapal			= $stateParams.idKapal;
	var id_dermaga			= $stateParams.idDermaga;
	
	$http.get(BASE_URL+'/api/kapal/info/'+$stateParams.idKapal).success(function(data){
		$rootScope.kapal = data;
	});
	$http.get(BASE_URL+'/api/dermaga/info/'+$stateParams.idDermaga).success(function(data){
		$rootScope.dermaga = data;
	});
	
	$rootScope.judul= 'Rekapitulasi';
	$scope.crit		= {tanggal:moment().format('YYYY-MM-DD'), jam:moment().format('HH:mm')};
	$scope.rows		= [];
	$scope.mode		= '';
	$scope.buildUrl	= function(crit) {
		console.log(BASE_URL+'/api/tiket/rekap/'+id_kapal+'/'+id_dermaga+'/'+crit.tanggal+'/'+crit.jam);
		return BASE_URL+'/api/tiket/rekap/'+id_kapal+'/'+id_dermaga+'/'+crit.tanggal+'/'+crit.jam;
	}
	$scope.view		= function(crit, doc) {
		if(doc == 'pdf') window.open($scope.buildUrl(crit)+'/'+doc);
		else {
			$scope.mode		= 'show';
			$http.get($scope.buildUrl(crit)).success(function(data){
				$scope.data = data;			
			});
		}
	}
}])
;