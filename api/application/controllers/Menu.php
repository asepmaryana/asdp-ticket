<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/REST_Controller.php';

class Menu extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->model('MenuModel');
    }
	
	public function index_get() {
		$this->set_response(array('success'=>true, 'version'=>phpversion()), REST_Controller::HTTP_OK);
	}
	
	public function role_get() {
	    $role_id   = $this->uri->segment(3);
	    $menus     = array();
	    $parents   = $this->MenuModel->get_menu($role_id)->result();
	    $i=0;
	    foreach ($parents as $p) {
	        $p->childs     = $this->MenuModel->get_child($p->id)->result();
	        foreach($p->childs as $s) {
	            $s->childs = $this->MenuModel->get_child($s->id)->result();
	        }
	        $menus[$i]     = $p;
	        $i++;
	    }
	    $this->set_response($parents, REST_Controller::HTTP_OK);
	}
}
?>