<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Role extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('RoleModel');
    }
	
	public function index_get() {
		$this->set_response(array('success'=>true, 'message'=>'ok'), REST_Controller::HTTP_OK);
	}
	
	public function lists_get() {
		$sort	= 'id_peran';
		$order	= 'asc';
		$rows   = $this->RoleModel->get_list($sort, $order)->result();
		$this->response($rows, REST_Controller::HTTP_OK);
	}
	
	public function save_post() {
		$values = json_decode(file_get_contents('php://input'), true);
		$id     = $this->RoleModel->save($values);
        $values['id']   = $id;
        $this->response($values, REST_Controller::HTTP_OK);
	}
	
	public function update_post() {
		$id    = $this->uri->segment(3);
        $values = json_decode(file_get_contents('php://input'), true);
        $this->RoleModel->update($id, $values);
        $this->response($values, REST_Controller::HTTP_OK);
	}
	
	public function delete_get() {
		$id    = $this->uri->segment(3);
		$this->RoleModel->delete($id);
        $this->response([], REST_Controller::HTTP_OK);
	}
	
}
?>