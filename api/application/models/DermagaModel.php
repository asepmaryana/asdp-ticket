<?php
class DermagaModel extends CI_Model
{
	public $table	= 'ref_dermaga';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_count() {
		$this->db->select('count(id_dermaga) as total');
		$rs = $this->db->get($this->table);        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function get_paged_list($sort, $order, $limit = 10, $offset = 0) {
	    $this->db->select('d.id_dermaga,d.dermaga,d.id_cabang,c.nama_cabang');
	    $this->db->join('ref_cabang c', 'd.id_cabang=c.id_cabang');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table.' d', $limit, $offset);
	}
	
	public function get_list($sort, $order) {
	    $this->db->select('d.id_dermaga,d.dermaga,d.id_cabang,c.nama_cabang');
	    $this->db->join('ref_cabang c', 'd.id_cabang=c.id_cabang');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table.' d');
	}
	
	public function get_by_id($id)
	{
	    $this->db->select('id_dermaga,dermaga');
		$this->db->where('id_dermaga', $id);
		return $this->db->get($this->table);
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_dermaga', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_dermaga', $id);
		return $this->db->delete($this->table);
	}
}
?>