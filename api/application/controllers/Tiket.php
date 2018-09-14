<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Tiket extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('TiketSalesDetailModel');
        $this->load->model('KapalModel');
        $this->load->model('DermagaModel');
    }
	
	public function cek_get() {
	    $kode  = $this->uri->segment(3);
	    $rs    = $this->TiketSalesDetailModel->get_by_kode(trim($kode));
	    if($rs->num_rows() > 0) {
	        $row   = $rs->row();
	        $this->set_response(['success'=>true, 'message'=>'Data Ditemukan', 'data'=>$row], REST_Controller::HTTP_OK);
	    }
	    else $this->set_response(['success'=>false, 'message'=>'Data Tidak Ada'], REST_Controller::HTTP_NOT_FOUND);
	}
	
	public function cek_post() {
	    $this->set_response(array('success'=>true, 'message'=>'ok'), REST_Controller::HTTP_OK);
	}
	
	public function lists_get() {
	    $id_layanan    = $this->uri->segment(3);
	    $id_kapal      = $this->uri->segment(4);
	    $id_dermaga    = $this->uri->segment(5);
	    $tanggal       = $this->uri->segment(6);
	    $status        = $this->uri->segment(7);
	    
	    if($id_layanan == '_') $id_layanan = '';
	    if($id_kapal == '_') $id_kapal = '';
	    if($id_dermaga == '_') $id_dermaga = '';
	    if($tanggal == '_') $tanggal = '';
	    if($status == '_') $status = '';
	    
	    $crit   = ['id_layanan'=>$id_layanan,'id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'status'=>$status];
	    $sort	= 'tsd.kode_boarding';
	    $order	= 'asc';

	    $rows   = $this->TiketSalesDetailModel->get_list($crit, $sort, $order)->result();
		$this->response($rows, REST_Controller::HTTP_OK);
	}
	
	public function rekap_get() {
	    $id_kapal      = $this->uri->segment(3);
	    $id_dermaga    = $this->uri->segment(4);
	    $tanggal       = $this->uri->segment(5);
	    $jam           = $this->uri->segment(6);
	    $doc           = $this->uri->segment(7);
	    
	    if($id_kapal == '_') $id_kapal = '';
	    if($id_dermaga == '_') $id_dermaga = '';
	    if($tanggal == '_') $tanggal = '';
	    if($jam == '_') $jam = '';
	    
	    $crit   = ['id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'jam'=>$jam];
	    
	    $rekap     = array();
	    $rekap['pen']    = array();
	    $rekap['pen']['dewasa']    = array();
	    $rekap['pen']['dewasa']['laki']      = 0;
	    $rekap['pen']['dewasa']['perempuan'] = 0;
	    $rekap['pen']['anak']        = 0;
	    $rekap['pen']['balita']      = 0;
	    
	    #penumpang dewasa laki2
	    $pdl  = $this->TiketSalesDetailModel->get_rekap(['id_layanan'=>1,'id_golongan'=>1,'id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'jam'=>$jam, 'id_kelamin'=>1])->row();
	    if($pdl) $rekap['pen']['dewasa']['laki'] = $pdl->total;
	    
	    #penumpang dewasa perempuan
	    $pdp  = $this->TiketSalesDetailModel->get_rekap(['id_layanan'=>1,'id_golongan'=>1,'id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'jam'=>$jam, 'id_kelamin'=>2])->row();
	    if($pdp) $rekap['pen']['dewasa']['perempuan'] = $pdp->total;
	    
	    #penumpang anak
	    $pa  = $this->TiketSalesDetailModel->get_rekap(['id_layanan'=>1,'id_golongan'=>2,'id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'jam'=>$jam])->row();
	    if($pa) $rekap['pen']['anak'] = $pa->total;
	    
	    #penumpang balita
	    $pb  = $this->TiketSalesDetailModel->get_rekap(['id_layanan'=>1,'id_golongan'=>3,'id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'jam'=>$jam])->row();
	    if($pb) $rekap['pen']['balita'] = $pb->total;
	    
	    $rekap['pen']['total'] = $rekap['pen']['dewasa']['laki']+$rekap['pen']['dewasa']['perempuan']+$rekap['pen']['anak']+$rekap['pen']['balita'];
	    
	    ### Kendaraan
	    $rekap['ken']    = array('I'=>0,'II'=>0,'III'=>0,'IVa'=>0,'IVb'=>0,'Va'=>0,'Vb'=>0,'VIa'=>0,'VIb'=>0,'VII'=>0,'VIII'=>0,'IX'=>0);
	    $kens  = $this->TiketSalesDetailModel->get_rekap(['id_layanan'=>2,'id_kapal'=>$id_kapal,'id_dermaga'=>$id_dermaga,'tanggal'=>$tanggal,'jam'=>$jam])->result();
	    $total = 0;
	    foreach ($kens as $k) {
	        $total += $k->total;
	        if($k->id_golongan == 4)   $rekap['ken']['I'] = $k->total;
	        elseif($k->id_golongan == 5)   $rekap['ken']['II'] = $k->total;
	        elseif($k->id_golongan == 6)   $rekap['ken']['III'] = $k->total;
	        elseif($k->id_golongan == 7)   $rekap['ken']['IVa'] = $k->total;
	        elseif($k->id_golongan == 8)   $rekap['ken']['IVb'] = $k->total;
	        elseif($k->id_golongan == 9)   $rekap['ken']['Va'] = $k->total;
	        elseif($k->id_golongan == 10)   $rekap['ken']['Vb'] = $k->total;
	        elseif($k->id_golongan == 11)   $rekap['ken']['VIa'] = $k->total;
	        elseif($k->id_golongan == 12)   $rekap['ken']['VIb'] = $k->total;
	        elseif($k->id_golongan == 13)   $rekap['ken']['VII'] = $k->total;
	        elseif($k->id_golongan == 14)   $rekap['ken']['VIII'] = $k->total;
	        elseif($k->id_golongan == 15)   $rekap['ken']['IX'] = $k->total;
	    }
	    $rekap['ken']['total'] = $total;
	    
	    if($doc == '') $this->response($rekap, REST_Controller::HTTP_OK);
	    else {
	        
	        $rekap['tanggal']  = ($tanggal == '') ? '' : tgl_rev($tanggal);
	        $rekap['jam']      = ($jam == '') ? '' : $jam;
	        $rekap['kapal']    = '';
	        $rekap['dermaga']  = '';
	        if($id_kapal != '') {
	            $kap   = $this->KapalModel->get_by_id($id_kapal)->row();
	            if($kap) $rekap['kapal']   = $kap->nama_kapal;
	        }
	        if($id_dermaga != '') {
	            $der   = $this->DermagaModel->get_by_id($id_dermaga)->row();
	            if($der) $rekap['dermaga']   = $der->dermaga;
	        }
	        
	        $this->load->library('M_pdf');
	        $mpdf = $this->m_pdf->load([
	            'mode' => 'utf-8',
	            'format' => 'A4'
	        ]);
	        $html = $this->load->view('template', $rekap, true);
	        $stylesheet = file_get_contents('../assets/plugin/bootstrap/css/bootstrap.css');
	        $mpdf->WriteHTML($stylesheet,1);
	        $mpdf->SetHTMLHeader('<img src="../assets/images/header.png" width="100%" border="0"/>');
	        $mpdf->WriteHTML($html);
	        $mpdf->Output('Rekap.'.date('YmdHis').'.pdf', 'D');
	    }
	}
	
	public function save_post() {
		$values = json_decode(file_get_contents('php://input'), true);
		$id     = $this->TiketSalesDetailModel->save($values);
        $values['id']   = $id;
        $this->response($values, REST_Controller::HTTP_OK);
	}
	
	public function update_post() {
		$id    = $this->uri->segment(3);
        $values = json_decode(file_get_contents('php://input'), true);
        $values['masuk_kapal']  = date('Y-m-d H:i:s');
        $this->TiketSalesDetailModel->update($id, $values);
        $this->response($values, REST_Controller::HTTP_OK);
	}
	
	public function delete_get() {
		$id    = $this->uri->segment(3);
		$this->TiketSalesDetailModel->delete($id);
        $this->response([], REST_Controller::HTTP_OK);
	}
	
}
?>