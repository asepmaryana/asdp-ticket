<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class TiketSales extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('TiketSalesModel');
        $this->load->model('TiketSalesDetailModel');
        $this->load->model('TiketRefundModel');
        $this->load->model('TiketRefundDetailModel');
        $this->load->model('KapalModel');
        $this->load->model('DermagaModel');
        $this->load->model('TiketSalesRefundModel');
        $this->load->model('UsersModel');
    }
	
	public function cek_get() {
	    $kode  = $this->uri->segment(3);
	    $rs    = $this->TiketSalesModel->get_by_kode(trim($kode));
	    if($rs->num_rows() > 0) {
	        $row   = $rs->row();
	        $row->tgl_penjualan = date('d-m-Y H:i:s', strtotime($row->tgl_penjualan));
	        $row->tgl_berangkat = date('d-m-Y', strtotime($row->tgl_berangkat));
	        $details            = $this->TiketSalesDetailModel->get_list(['id_trx_tiket_sales'=>$row->id_trx_tiket_sales], '', '')->result();
	        #$row->details      = $details;
	        $row->details       = array();
	        $i = 0;
	        foreach ($details as $tiket) {
	            if($this->TiketRefundDetailModel->is_exists($tiket->id_trx_tiket_sales_detail)) continue;
	            else {
	                $row->details[$i] = $tiket;
	                $i++;
	            }
	        }
	        
	        #$tarif = 0;
	        #foreach ($row->details as $r) $tarif += $r->tarif;
	        #$row->tarif    = $tarif;
	        #$row->nominal  = $tarif * 0.75;
	        
	        if($row->id_status_pesan == '4') $this->set_response(['success'=>false, 'message'=>'Tiket Sudah/Sedang Dalam Proses Refund !', 'data'=>$row], REST_Controller::HTTP_OK);
	        else {
	            $time      = strtotime($row->tgl_berangkat);
	            $remain    = floor(($time - time())/86400);
	            if($remain >= 1) $this->set_response(['success'=>true, 'message'=>'Refund Siap Diproses.', 'data'=>$row], REST_Controller::HTTP_OK);
	            else $this->set_response(['success'=>false, 'message'=>'Masa Refund Sudah Berakhir !', 'data'=>$row], REST_Controller::HTTP_OK);
	        }
	    }
	    else $this->set_response(['success'=>false, 'message'=>'Tiket Tidak Ditemukan !'], REST_Controller::HTTP_NOT_FOUND);
	}
	
	public function update_post() {
	    $headers	= $this->input->request_headers();
	    $user		= $this->UsersModel->getInfo($headers[config_item('rest_key_name')]);
	    
	    $id        = $this->uri->segment(3);
	    $values    = json_decode(file_get_contents('php://input'), true);
	    
	    #update trx_tiket_sales
	    $this->TiketSalesModel->update($id, ['id_status_pesan'=>'4']);
	    
	    #insert or update trx_tiket_sales_refund
	    $rs = $this->TiketSalesRefundModel->get_by_tiket_sales($id);
	    
	    $data  = array();
	    $data['id_trx_tiket_sales_refund']    = $this->uuid->v4();;
	    $data['id_trx_tiket_sales']    = $id;
	    $data['id_status_pesan']       = $values['id_status_pesan'];
	    $data['id_pengguna']           = $user->ID_PENGGUNA;
	    $data['tgl_pengajuan']         = date('Y-m-d');
	    $data['waktu_pengajuan']       = date('H:i:s');
	    $data['nama_pemohon']          = $values['nama_pemohon'];
	    $data['id_jenis_identitas']    = $values['id_jenis_identitas'];
	    $data['nomor_identitas']       = $values['nomor_identitas'];
	    $data['nomor_telp']            = $values['nomor_telp'];
	    $data['id_bank']               = $values['id_bank'];
	    $data['rekening']              = $values['rekening'];
	    $data['atas_nama']             = $values['atas_nama'];
	    $data['alasan']                = $values['alasan'];
	    $data['total']                 = $values['tarif'];
	    $data['refund']                = $values['nominal'];
	    $data['id_status_refund']      = 1;
	    
	    if($rs->num_rows() > 0) {
	        $row = $rs->row();
	        $this->TiketSalesRefundModel->update($row->id_trx_tiket_sales_refund, $data);
	    }
	    else $this->TiketSalesRefundModel->save($data);
	    $this->set_response(['success'=>true, 'message'=>"Pengajuan Refund Telah Diproses.\nBukti Refund Silahkan Dicetak !"], REST_Controller::HTTP_OK);
	    $rs->free_result();
	}
}
?>