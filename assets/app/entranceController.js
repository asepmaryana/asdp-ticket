angular.module('app.controller', ['ui.bootstrap'])
.controller('EntranceController', ['$rootScope','$scope','$http','$stateParams', function($rootScope,$scope,$http,$stateParams){
	
	$rootScope.idKapal		= $stateParams.idKapal;
	$rootScope.idDermaga	= $stateParams.idDermaga;
	
	$http.get(BASE_URL+'/api/kapal/info/'+$rootScope.idKapal).success(function(data){
		$rootScope.kapal = data;
	});
	$http.get(BASE_URL+'/api/dermaga/info/'+$rootScope.idDermaga).success(function(data){
		$rootScope.dermaga = data;
	});
	
	$scope.data		= null;
	$scope.kode		= '';
	$scope.boarding	= '';
	$rootScope.judul= 'Entrance Checking';
	
	$scope.lookup			= function(kode) {		
		console.log(kode);
		$scope.boarding	= kode;
		$http.get(BASE_URL+'/api/tiket/cek/'+kode)
		.success(function(res){
			$scope.data = res.data;
			$scope.data.rute = res.data.asal+' - '+res.data.tujuan;
			$scope.data.identitas = res.data.jenis_identitas+' - '+res.data.no_identitas;
			$scope.data.success = res.success;
			
			//update if masuk_kapal is null
			if(res.data.masuk_kapal == null) {
				var param	= {id_kapal:$stateParams.idKapal,id_dermaga:$stateParams.idDermaga};
				$http.post(BASE_URL+'/api/tiket/update/'+res.data.id, param)
                .success(function(resp){
                	//swal('Success', resp.message);                	
                })
                .error(function(resp){
                	swal('Exception', resp.message);
                });
			}
		})
		.error(function(res){
			//swal('Exception', res.message);
			$scope.data	= null;
			$scope.data	= res;
		});
		$scope.kode = '';
	}
	$scope.clear	= function(){
		$scope.data	= null;
		$scope.kode	= '';
	}
	$scope.enterPressed = function (keyEvent) {
		if (keyEvent.keyCode == 13) $scope.lookup($scope.kode);
	};	
}])
;