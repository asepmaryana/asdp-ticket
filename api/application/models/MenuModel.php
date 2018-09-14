<?php
class MenuModel extends CI_Model
{
	public $table	= 'menu';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_menu($role_id) {
	    $this->db->select('m.*');
	    $this->db->from($this->table.' m');
	    $this->db->join('authority_menu am', 'am.menu_id = m.id', 'left');
	    $this->db->where('am.authority_id', $role_id);
	    $this->db->order_by('m.id', 'asc');
	    return $this->db->get();
	}
	
	public function get_child($parent_id) {
	    $this->db->where('parent_id', $parent_id);
	    $this->db->order_by('menu_order', 'asc');
	    return $this->db->get($this->table);
	}
	
	public function get_count($role_id='') {
		$this->db->select('count(m.id) as total');
		$this->db->join('authority_menu am', 'am.menu_id = m.id', 'left');
		if($role_id != '') $this->db->where('am.authority_id', $role_id);
		$rs = $this->db->get($this->table.' m');        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function get_paged_list($sort, $order, $limit = 10, $offset = 0) {
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table, $limit, $offset);
	}
	
	public function get_list($sort, $order) {
		$this->db->where_in('id', array(1,2,3));
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table);
	}
	
	public function get_by_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}
	
}
?>