<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Config extends REST_Controller 
{
	public function __construct() {
        parent::__construct();
        $this->load->model('UsersModel');
        $this->load->model('ConfigModel');
    }
	
    function list_get()
    {
        $page    		= $this->uri->segment(3);
        $size    		= $this->uri->segment(4);
        
        if(empty($page) || $page == '0') $page = 1;
        if(empty($size) || $size == '0') $size = 10;
        $offset  = ($page-1)*$size;
        
        $sort	= 'code';
        $order	= 'asc';
        
        $rows   = $this->ConfigModel->get_paged_list($sort, $order, $size, $offset)->result();
        $total  = $this->ConfigModel->get_count();
        $totalPage  = ceil($total/$size);
        $firstPage  = ($page == 0 || $page == 1) ? true : false;
        $lastPage   = ($page == $totalPage) ? true : false;
        $response   = array('content'=>$rows, 'totalPage'=>$totalPage, 'first'=>$firstPage, 'last'=>$lastPage, 'page'=>intval($page), 'total'=>$total);
        $this->response($response, REST_Controller::HTTP_OK);
    }
    
    public function save_post() {
        $values = json_decode(file_get_contents('php://input'), true);
        $id     = $this->ConfigModel->save($values);
        $values['id']   = $id;
        $this->response($values, REST_Controller::HTTP_OK);
    }
    
    public function update_post() {
        $id    = $this->uri->segment(3);
        $values = json_decode(file_get_contents('php://input'), true);
        $this->ConfigModel->update($id, $values);
        $this->response($values, REST_Controller::HTTP_OK);
    }
    
    public function delete_get() {
        $id    = $this->uri->segment(3);
        $this->ConfigModel->delete($id);
        $this->response([], REST_Controller::HTTP_OK);
    }
    
    public function find_get() {
        $config_id	= $this->uri->segment(3);
        $info   = $this->rest->db->select('*')->where('code', $config_id)->get('config')->row();
        $this->set_response($info, REST_Controller::HTTP_OK);
    }
}
?>