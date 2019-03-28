<?php
class StatusRefundModel extends CI_Model
{
	public $table	= 'ref_status_refund';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_count() {
		$this->db->select('count(id_status_refund) as total');
		$rs = $this->db->get($this->table);        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function get_list($sort, $order) {
	    $this->db->select('id_status_refund,status_refund');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table);
	}
	
	public function get_by_id($id)
	{
	    $this->db->select('id_status_refund,status_refund');
		$this->db->where('id_status_refund', $id);
		return $this->db->get($this->table);
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_status_refund', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_status_refund', $id);
		return $this->db->delete($this->table);
	}
}
?>