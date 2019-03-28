<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class TiketRefundDetail extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('TiketRefundDetailModel');
    }
	
    public function find_get(){
        $tiket_refund_id = $this->uri->segment(3);
        $row    = $this->TiketRefundDetailModel->get_by_tiket_refund($tiket_refund_id)->result();
        $this->response($row, REST_Controller::HTTP_OK);
    }
}
?>