<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class TiketRefund extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('TiketRefundModel');
        $this->load->model('TiketRefundDetailModel');
        $this->load->model('TiketSalesRefundModel');
        $this->load->model('StatusRefundModel');
        $this->load->model('UsersModel');
        
    }
	
    public function cek_get() {
        $kode  = $this->uri->segment(3);
        $rs    = $this->TiketRefundModel->get_by_kode(trim($kode));
        if($rs->num_rows() > 0) {
            $row    = $rs->row();
            $rsd    = $this->TiketRefundModel->count_total_refund($row->id_trx_tiket_refund);
            if($rsd->num_rows() > 0) {
                $sum    = $rsd->row();
                $row->total     = $sum->total;
                $row->nominal   = $sum->nominal;
            }
            else {
                $row->total     = 0;
                $row->nominal   = 0;
            }
            $rsd->free_result();
            $this->set_response($row, REST_Controller::HTTP_OK);
        }
        else $this->set_response(['success'=>false, 'message'=>'Tiket Tidak Ditemukan !'], REST_Controller::HTTP_NOT_FOUND);
        $rs->free_result();
    }
    
    public function lists_get() {
        $kode_booking   = $this->uri->segment(3);
        $tanggal        = $this->uri->segment(4);
        $status         = $this->uri->segment(5);
        $doc            = $this->uri->segment(6);
        
        if($kode_booking == '_') $kode_booking = '';
        if($tanggal == '_') $tanggal = '';
        if($status == '_') $status = '';
        $kode_booking   = str_replace('_', ' ', $kode_booking);
        $kode_booking   = trim($kode_booking);
        
        $crit   = ['kode_booking'=>$kode_booking,'tanggal'=>$tanggal,'status'=>$status];
        $sort	= 'trd.id_trx_tiket_sales_detail';
        $order	= 'asc';
        
        $rows   = $this->TiketRefundModel->get_list($crit, $sort, $order)->result();
        if($status != '') {
            $sr     = $this->StatusRefundModel->get_by_id($status)->row();
            $status = $sr->status_refund;
        }
        else $status = 'SEMUA';
        
        if ($doc == 'xls') {
            require_once APPPATH.'/third_party/phpexcel/PHPExcel/IOFactory.php';
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load(APPPATH."/templates/refund.xlsx");
            
            $objPHPExcel->getActiveSheet()->setCellValue('C3', ': '.tgl_rev($tanggal));
            $objPHPExcel->getActiveSheet()->setCellValue('C4', ': '.strtoupper($status));
            
            $objWorksheet  = $objPHPExcel->getActiveSheet();
            $start         = 8;
            $r=$start;
            $c=0;
            foreach ($rows as $row) {
                $c++;
                $objWorksheet->insertNewRowBefore($r, 1);
                
                $objWorksheet->setCellValue('A'.$r, $c);
                $objWorksheet->setCellValue('B'.$r, $row->kode_booking);
                $objWorksheet->setCellValue('C'.$r, $row->asal.' - '.$row->tujuan);
                $objWorksheet->setCellValue('D'.$r, tgl_rev($row->tgl_berangkat));
                $objWorksheet->setCellValue('E'.$r, $row->nama);
                $objWorksheet->setCellValue('F'.$r, $row->jenis_kelamin);
                $objWorksheet->setCellValue('G'.$r, $row->alamat);
                $objWorksheet->setCellValue('H'.$r, $row->status_refund);
                
                $r++;
            }
            $stop  = $start+count($rows)-1;
            if(count($rows) > 0) $objWorksheet->removeRow($start-1);
            download_excel($objPHPExcel, 'Refund-Tiket.'.$tanggal);
        }
        elseif ($doc == 'pdf') {
            $data  = array();
            $data['tanggal']   = tgl_rev($tanggal);
            $data['status']    = strtoupper($status);
            $data['rows']      = $rows;
            
            $this->load->library('M_pdf');
            $mpdf = $this->m_pdf->load(['mode' => 'utf-8', 'format' => 'A4-L']);
            $html = $this->load->view('refund', $data, true);
            
            $stylesheet = file_get_contents('../assets/plugin/bootstrap/css/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            #$mpdf->SetHTMLHeader('<img src="../assets/images/header.png" width="100%" border="0"/>');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Refund-Tiket.'.$tanggal.'.pdf', 'D');
        }
        else $this->response($rows, REST_Controller::HTTP_OK);
    }
    
    public function info_get(){
        $id_trx_tiket_sales = $this->uri->segment(3);
        $row    = $this->TiketRefundModel->get_by_tiket_sales($id_trx_tiket_sales)->row();
        $this->response($row, REST_Controller::HTTP_OK);
    }
    /*
    public function cek_get(){
        $kode_booking   = $this->uri->segment(3);
        $rs    = $this->TiketSalesRefundModel->get_by_kode_booking(trim($kode_booking));
        if($rs->num_rows() > 0) {
            $row   = $rs->row();
            $this->set_response(['success'=>true, 'message'=>'Data Ditemukan', 'data'=>$row], REST_Controller::HTTP_OK);
        }
        else $this->set_response(['success'=>false, 'message'=>'Data Tidak Ada'], REST_Controller::HTTP_NOT_FOUND);
        $rs->free_result();
    }
    */
    public function proses_post() {
        $headers	= $this->input->request_headers();
        $user		= $this->UsersModel->getInfo($headers[config_item('rest_key_name')]);
        
        $id_trx_tiket_sales   = $this->uri->segment(3);
        $values = json_decode(file_get_contents('php://input'), true);
        
        $data = array();
        $data['id_trx_tiket_sales']    = $id_trx_tiket_sales;
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
        $data['id_status_refund']      = 3;
        
        $id_trx_tiket_refund           = '';
        
        $rs = $this->TiketRefundModel->get_by_tiket_sales($id_trx_tiket_sales);
        if($rs->num_rows() > 0) {
            #update
            $row = $rs->row();
            $id_trx_tiket_refund = $row->id_trx_tiket_refund;
            $this->TiketRefundModel->update($id_trx_tiket_refund, $data);
            
            #delete and insert
            #$this->TiketRefundDetailModel->delete_by_tiket_refund($id_trx_tiket_refund);
        }
        else {
            #insert
            $id_trx_tiket_refund = $this->TiketRefundModel->save($data);
        }
        $rs->free_result();
        
        #insert detail
        foreach ($values['refunds'] as $r)
        {
            $details    = array();
            $details['id_trx_tiket_sales_detail']   = $r['id_trx_tiket_sales_detail'];
            $details['id_trx_tiket_refund']         = $id_trx_tiket_refund;
            $details['id_status_refund']            = 3;
            $details['refund']                      = intval($r['tarif']) * 0.75;
            
            $this->TiketRefundDetailModel->save($details);
        }
        
        $this->set_response(['success'=>true, 'message'=>'Proses Refund Berhasil.'], REST_Controller::HTTP_OK);
        
        /*
        if($this->TiketSalesRefundModel->update($id, $refund)) {
            $this->set_response(['success'=>true, 'message'=>'Proses Update Refund Berhasil.'], REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response(['success'=>false, 'message'=>'Proses Update Refund Gagal !'], REST_Controller::HTTP_NOT_FOUND);
        }
        */
    }
    
    public function find_get(){
        $tiket_sales_id = $this->uri->segment(3);
        $rs    = $this->TiketRefundModel->get_by_tiket_sales($tiket_sales_id);
        if($rs->num_rows() > 0) 
        {
            $row = $rs->row();
            $this->response($row, REST_Controller::HTTP_OK);
        }
        else $this->response(null, REST_Controller::HTTP_OK);
    }
}
?>