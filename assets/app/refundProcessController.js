angular.module('app.controller', ['ui.bootstrap'])
.controller('RefundProcessController', ['$rootScope','$scope','$http','$cookies','$state', function($rootScope,$scope,$http,$cookies,$state){
	if($cookies.token == null) $state.go('signin');
	$scope.data		= null;
	$scope.kode		= '';
	$rootScope.judul= 'Refund Process';
	
	$scope.lookup	= function(kode) {		
		//console.log(kode);
		$scope.booking	= kode;
		$http.get(BASE_URL+'/api/tiketRefund/cek/'+kode)
		.success(function(res){
			$scope.mode	= 'form';
			$scope.data = res.data;
			$scope.data.rute = res.data.asal+' - '+res.data.tujuan;
			$scope.data.rekening = res.data.rekening+' ( '+res.data.nama_bank+' )';
			$scope.data.nomor_identitas = res.data.nomor_identitas+ ' ( '+res.data.jenis_identitas+' )';
			$scope.data.success = res.success;
			$scope.data.message = res.message;
		})
		.error(function(res){
			$scope.mode	= '';
			$scope.data	= null;
			$scope.data	= res;
			$scope.data.success = res.success;
			$scope.data.message = res.message;
			swal('Exception', res.message);
		});
		$scope.kode = '';
	}
	$scope.clear	= function(){
		$scope.data	= null;
		$scope.kode	= '';
		$scope.booking = '';
	}
	$scope.enterPressed = function (keyEvent) {
		if (keyEvent.keyCode == 13) $scope.lookup($scope.kode);
	};
	$scope.save		= function(o){
		swal({
			title: "Konfirmasi",
			text: "Anda yakin akan melakukan update refund ?",
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
				$http.post(BASE_URL+'/api/tiketRefund/update/'+o.id, o)
		        .success(function(resp){
		        	swal('Success', resp.message);
		        	$scope.clear();
		        })
		        .error(function(resp){
		        	swal('Exception', resp.message);
		        });
			}
		});
	}
}])
;