<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Kendaraan extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('KendaraanModel');
    }
	
	public function penumpang_post() {
	    #$nopol     = $this->uri->segment(3);
	    #$tanggal   = $this->uri->segment(4);
	    #$crit      = ['nopol'=>$nopol, 'tanggal'=>$tanggal];
	    $values = json_decode(file_get_contents('php://input'), true);
	    $rows   = $this->KendaraanModel->get_penumpang(['nopol'=>$values['no_polisi'], 'tanggal'=>$values['tgl_berangkat']])->result();
		$this->response($rows, REST_Controller::HTTP_OK);
	}	
}
?>