<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Identitas extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('IdentitasModel');
    }
    
    public function lists_get() {
        $sort	= 'id_jenis_identitas';
        $order	= 'asc';
        $rows   = $this->IdentitasModel->get_list($sort, $order)->result();
        $this->response($rows, REST_Controller::HTTP_OK);
    }
}
?>