<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Account extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('UsersModel');
    }
	
	public function update_post() {
		$id    = $this->uri->segment(3);
		$values = json_decode(file_get_contents('php://input'), true);
		if(isset($values['username'])) unset($values['username']);
		if(isset($values['password']) && $values['password'] != '') {		    
		    $rs  = $this->UsersModel->get_by_id($id);
		    if($rs->num_rows() > 0) {
		        $user = $rs->row();
		        if($user->password != md5($values['current'])) $this->response(['status'=>false, 'message'=>'Password aktif yang anda masukan salah.'], REST_Controller::HTTP_NOT_FOUND);
		        else {
		            $values['password']   = md5($values['password']);
		            unset($values['current']);
		            unset($values['confirm']);
		            $this->UsersModel->update($id, $values);
		            $this->response($values, REST_Controller::HTTP_OK);
		        }
		    }
		    else $this->response(['status'=>false, 'message'=>'Account tidak ditemukan.'], REST_Controller::HTTP_NOT_FOUND);
		    $rs->free_result();
		}
		else {
		    $this->UsersModel->update($id, $values);
		    $this->response($values, REST_Controller::HTTP_OK);
		}
	}
	
	public function lists_get() {
	    $authority_id      = $this->uri->segment(3);
	    $poli_id           = $this->uri->segment(4);
	    $values            = $this->UsersModel->get_auth_and_poli($authority_id, $poli_id)->result();
	    $this->response($values, REST_Controller::HTTP_OK);
	}
}
?>