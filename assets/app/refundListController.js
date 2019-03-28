angular.module('app.controller', ['ui.bootstrap'])
.controller('RefundListController', ['$rootScope','$scope','$http','$cookies','$state','$stateParams', function($rootScope,$scope,$http,$cookies,$state,$stateParams){
	if($cookies.token == null) $state.go('signin');
	$rootScope.judul= 'Daftar Refund';
	$scope.crit		= {kode_booking:'',tanggal:moment().format('YYYY-MM-DD'),id_status_refund:''};
	$scope.status	= [];
	$scope.rows		= [];
	$scope.mode		= '';
	$http.get(BASE_URL+'/api/statusRefund/lists').success(function(data){
		$scope.status = data;
	});
	$scope.buildUrl	= function() {
		
		var kode_booking 	= $scope.crit.kode_booking;
		var tanggal 		= $scope.crit.tanggal;
		var status 			= $scope.crit.id_status_refund;
		
		if(kode_booking == '') kode_booking = '_';
        if(kode_booking != '_') kode_booking = kode_booking.replace(/ /, '_');
		if(tanggal == '') tanggal = '_';
		if(status == '') status = '_';
		
		return BASE_URL+'/api/tiketRefund/lists/'+kode_booking+'/'+tanggal+'/'+status;
	}
	$scope.view		= function(crit, doc) {
		if(doc == '') {
			$scope.mode		= 'show';
			$http.get($scope.buildUrl()).success(function(data){
				$scope.rows = data;			
			});
		}
		else window.open($scope.buildUrl()+'/'+doc);
	}
	$scope.print	= function(){
		$scope.mode		= 'print';
		var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {mode: mode,popClose: close};
        $("#printableTiketRefund").printArea(options);
	}
}])
;