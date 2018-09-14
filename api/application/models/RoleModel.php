<?php
class RoleModel extends CI_Model
{
	public $table	= 'acc_peran';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_count() {
		$this->db->select('count(id_peran) as total');
		$rs = $this->db->get($this->table);        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function get_paged_list($sort, $order, $limit = 10, $offset = 0) {
	    $this->db->select('id_peran,kode_peran,deskripsi');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table, $limit, $offset);
	}
	
	public function get_list($sort, $order) {
	    $this->db->select('id_peran,kode_peran,deskripsi');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table);
	}
	
	public function get_by_id($id)
	{
	    $this->db->select('id_peran,kode_peran,deskripsi');
		$this->db->where('id_peran', $id);
		return $this->db->get($this->table);
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_peran', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_peran', $id);
		return $this->db->delete($this->table);
	}
	
}
?>