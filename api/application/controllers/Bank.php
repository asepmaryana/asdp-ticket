<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Bank extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('BankModel');
    }
    
    public function lists_get() {
        $sort	= 'nama_bank';
        $order	= 'asc';
        $rows   = $this->BankModel->get_list($sort, $order)->result();
        $this->response($rows, REST_Controller::HTTP_OK);
    }
}
?>