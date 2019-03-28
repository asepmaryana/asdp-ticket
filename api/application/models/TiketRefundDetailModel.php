<?php
class TiketRefundDetailModel extends CI_Model
{
	public $table	= 'trx_tiket_refund_detail';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function is_exists($id_trx_tiket_sales_detail)
	{
	    $this->db->select('trd.id_trx_tiket_sales_detail');
	    $this->db->where('trd.id_trx_tiket_sales_detail', $id_trx_tiket_sales_detail);
	    $rs = $this->db->get($this->table.' trd');
	    $exists = ($rs->num_rows() > 0) ? true : false;
	    $rs->free_result();
	    return $exists;
	}
	
	public function get_by_id($id_trx_tiket_refund_detail)
	{
	    $this->db->select('trd.id_trx_tiket_sales_detail,trd.id_trx_tiket_refund,trd.id_status_refund,trd.refund,tsd.tarif');
	    $this->db->join('trx_tiket_sales_detail tsd', 'trd.id_trx_tiket_sales_detail=tsd.id_trx_tiket_sales_detail', 'left');
	    $this->db->where('trd.id_trx_tiket_refund_detail', $id_trx_tiket_refund_detail);
	    return $this->db->get($this->table.' trd');
	}
	
	public function get_by_tiket_refund($id_trx_tiket_refund)
	{
	    $this->db->select('trd.id_trx_tiket_sales_detail,trd.id_trx_tiket_refund,trd.id_status_refund,trd.refund,tsd.tarif');
	    $this->db->join('trx_tiket_sales_detail tsd', 'trd.id_trx_tiket_sales_detail=tsd.id_trx_tiket_sales_detail', 'left');
	    $this->db->where('trd.id_trx_tiket_refund', $id_trx_tiket_refund);
	    return $this->db->get($this->table.' trd');
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_trx_tiket_refund_detail', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_trx_tiket_refund_detail', $id);
		return $this->db->delete($this->table);
	}
	
	public function delete_by_tiket_refund($id_trx_tiket_refund)
	{
	    $this->db->where('id_trx_tiket_refund', $id_trx_tiket_refund);
	    return $this->db->delete($this->table);
	}
	
}
?>