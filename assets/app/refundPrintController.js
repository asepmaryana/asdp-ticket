angular.module('app.controller', ['ui.bootstrap'])
.controller('RefundPrintController', ['$rootScope','$scope','$http','$cookies','$state','$timeout', function($rootScope,$scope,$http,$cookies,$state,$timeout){
	if($cookies.token == null) $state.go('signin');

    $scope.total	= 0;
    $scope.nominal	= 0;
	$scope.kode		= '';
	$scope.mode		= '';
	$scope.refund	= null;
	$rootScope.judul= 'Cetak Refund';
	
	$scope.lookup			= function(kode) {
		$http.get(BASE_URL+'/api/tiketRefund/cek/'+kode)
		.success(function(res){
			$scope.mode	= 'print';
			$scope.refund	= res;
			$scope.refund.rute	= res.asal+' - '+res.tujuan;
		})
		.error(function(res){
			$scope.mode	= '';
			$scope.refund	= null;
			swal('Exception', res.message);
		});
		$scope.kode = '';
	}
	$scope.clear	= function(){
		$scope.mode	= '';
		$scope.refund	= null;
		$scope.kode	= '';
	}
	$scope.enterPressed = function (keyEvent) {
		if (keyEvent.keyCode == 13) $scope.lookup($scope.kode);
	};
	$scope.print	= function(){
		var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {mode: mode,popClose: close};
        $("#printTiketRefund").printArea(options);
	}
	$scope.finish	= function(){
		$scope.clear();
	}
}])
;