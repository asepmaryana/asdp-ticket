angular.module('app.controller', ['ui.bootstrap'])
.controller('RefundSubmissionController', ['$rootScope','$scope','$http','$cookies','$state','$stateParams','$timeout', function($rootScope,$scope,$http,$cookies,$state,$stateParams,$timeout){
	if($cookies.token == null) $state.go('signin');
	
	$scope.tikets = [];
    $scope.unselectedTiket = [];
    $scope.selectedTiket = [];
    $scope.total	= 0;
    $scope.nominal	= 0;
	$scope.data		= null;
	$scope.kode		= '';
	$scope.mode		= '';
	$scope.refund	= null;
	$rootScope.judul= 'Pengajuan Refund';
	
	$scope.printSelected  = function(){
		console.log('selected: ');
		console.log($scope.selectedTiket);
		console.log('total = '+$scope.total);
		console.log('refund = '+$scope.nominal);
	}
	
	$scope.selectAllTiket = function($event){
        if($event.target.checked){
            for ( var i = 0; i < $scope.unselectedTiket.length; i++) {
                var p = $scope.unselectedTiket[i];
                if($scope.selectedTiket.indexOf(p.id_trx_tiket_sales_detail) < 0){
                	$scope.tikets.push(p);
                    $scope.selectedTiket.push(p.id_trx_tiket_sales_detail);
                    $scope.total += parseInt(p.tarif);
                    $scope.nominal = $scope.total * (75/100);
                }
            }
        } else {
        	$scope.tikets = [];
            $scope.selectedTiket = [];
            $scope.total 	= 0;
            $scope.nominal	= 0;
        }
        $scope.printSelected();
    }
	
	$scope.updateSelectedTiket = function($event, r){
        var checkbox = $event.target;
        if(checkbox.checked  && $scope.selectedTiket.indexOf(r.id_trx_tiket_sales_detail) < 0){
        	$scope.tikets.push(r);
            $scope.selectedTiket.push(r.id_trx_tiket_sales_detail);
            $scope.total += parseInt(r.tarif);
        } else {
        	$scope.tikets.splice($scope.tikets.indexOf(r), 1);
            $scope.selectedTiket.splice($scope.selectedTiket.indexOf(r.id_trx_tiket_sales_detail), 1);
            $scope.total -= parseInt(r.tarif);
        }
        $scope.nominal = $scope.total * (75/100);
        $scope.printSelected();
    }
    
    $scope.isTiketSelected = function(r){
        return $scope.selectedTiket.indexOf(r.id_trx_tiket_sales_detail) >= 0;
    }

    $scope.isAllTiketSelected = function(){
        return $scope.unselectedTiket.length === $scope.selectedTiket.length;
    }
    
	$scope.lookup			= function(kode) {		
		//console.log(kode);
		$scope.booking	= kode;
		$http.get(BASE_URL+'/api/tiketSales/cek/'+kode)
		.success(function(res){
			$scope.mode	= 'form';
			$scope.data = res.data;
			$scope.data.rute = res.data.asal+' - '+res.data.tujuan;
			$scope.data.success = res.success;
			$scope.data.message = res.message;
			for(var i=0; i<res.data.details.length; i++) $scope.unselectedTiket.push(res.data.details[i]);
			
			//refund
			$http.get(BASE_URL+'/api/tiketRefund/find/'+res.data.id_trx_tiket_sales)
			.success(function(refund){
				if(angular.isDefined(refund.id_trx_tiket_refund))
				{
					$scope.data.id_jenis_identitas = refund.id_jenis_identitas;
					$scope.data.nomor_identitas = refund.nomor_identitas;
					$scope.data.nama_pemohon = refund.nama_pemohon;
					$scope.data.nomor_telp = refund.nomor_telp;
					$scope.data.id_bank = refund.id_bank;
					$scope.data.rekening = refund.rekening;
					$scope.data.atas_nama = refund.atas_nama;
					$scope.data.alasan = refund.alasan;
					
					/*
					//refund detail				
					$http.get(BASE_URL+'/api/tiketRefundDetail/find/'+refund.id_trx_tiket_refund)
					.success(function(rows){
						for(var i=0; i<rows.length; i++) {
							if($scope.selectedTiket.indexOf(rows[i].id_trx_tiket_sales_detail) < 0) {
								$scope.tikets.push(rows[i]);
								$scope.selectedTiket.push(rows[i].id_trx_tiket_sales_detail);
								$scope.total += parseInt(rows[i].tarif);
								$scope.nominal += parseInt(rows[i].refund);
							}
						}
					})
					.error(function(res){
						$scope.selectedTiket = [];
						$scope.total = 0;
						$scope.nominal = 0;
					});
					*/
				}
			})
			.error(function(res){
				$scope.data.id_jenis_identitas = null;
				$scope.data.nomor_identitas = null;
				$scope.data.nama_pemohon = null;
				$scope.data.nomor_telp = null;
				$scope.data.id_bank = null;
				$scope.data.rekening = null;
				$scope.data.atas_nama = null;
				$scope.data.alasan = null;
				$scope.selectedTiket = [];
				$scope.total = 0;
				$scope.nominal = 0;
			});
		})
		.error(function(res){
			$scope.mode	= '';
			$scope.data	= null;
			$scope.data	= res;
			$scope.data.success = res.success;
			$scope.data.message = res.message;
			$scope.selectedTiket = [];
			$scope.unselectedTiket	= [];
            $scope.total 	= 0;
            $scope.nominal	= 0;
		});
		$scope.kode = '';
	}
	$scope.clear	= function(){
		$scope.data	= null;
		$scope.kode	= '';
		$scope.booking = '';
		$scope.tikets = [];
		$scope.selectedTiket = [];
		$scope.unselectedTiket = [];
	    $scope.total 	= 0;
        $scope.nominal	= 0;
	}
	$scope.enterPressed = function (keyEvent) {
		if (keyEvent.keyCode == 13) $scope.lookup($scope.kode);
	};
	
	$scope.identitass	= [];
	$scope.banks	= [];
	
	$http.get(BASE_URL+'/api/identitas/lists').success(function(data){
		$scope.identitass = data;
	});
	$http.get(BASE_URL+'/api/bank/lists').success(function(data){
		$scope.banks = data;
	});
	
	$scope.save		= function(o){
		if($scope.selectedTiket.length > 0) {
			o.refunds	= $scope.tikets;
			console.log(o);
			
			$http.post(BASE_URL+'/api/tiketRefund/proses/'+o.id_trx_tiket_sales, o)
	        .success(function(resp){
	        	$scope.refund	= o;
	        	$http.get(BASE_URL+'/api/tiketRefund/info/'+o.id_trx_tiket_sales).success(function(info){
	        		$scope.refund.tgl_pengajuan = info.tgl_pengajuan;
	        		$scope.refund.nama_bank = info.nama_bank;
	        		$scope.refund.rekening = info.rekening;
	        		$scope.refund.atas_nama = info.atas_nama;
	        		$scope.refund.alasan = info.alasan;
	        		$scope.refund.total	 = $scope.total;
	        		$scope.refund.nominal = $scope.nominal;
	        		console.log($scope.refund);
	        		
	        		$scope.mode	= 'print';
	            	swal('Success', resp.message);
	            	$timeout(function(){ $scope.print(); }, 3000);
	            	//$scope.clear();
	        	});
	        })
	        .error(function(resp){
	        	$scope.mode	= 'form';
	        	swal('Exception', resp.message);
	        });
		}
		else swal('Exception', 'Belum ada tiket yang dipilih !');
	}
	var original 	= $scope.data;
	$scope.isClean = function() {
		return angular.equals(original, $scope.data);
	}
	$scope.print	= function(){
		var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {mode: mode,popClose: close};
        $("#printableAreaStruk").printArea(options);
	}
	$scope.finish	= function(){
		$scope.clear();
		$scope.mode	= '';
	}
}])
;