<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class StatusRefund extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('StatusRefundModel');
    }
    
    public function lists_get() {
        $sort	= 'id_status_refund';
        $order	= 'asc';
        $rows   = $this->StatusRefundModel->get_list($sort, $order)->result();
        $this->response($rows, REST_Controller::HTTP_OK);
    }
}
?>