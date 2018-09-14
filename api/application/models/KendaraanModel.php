<?php
class KendaraanModel extends CI_Model
{
	public $table	= 'adm_manifest';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_count() {
		$this->db->select('count(id_manifest) as total');
		$rs = $this->db->get($this->table);        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function get_paged_list($sort, $order, $limit = 10, $offset = 0) {
	    #$this->db->select('');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table, $limit, $offset);
	}
	
	public function get_list($sort, $order) {
	    #$this->db->select('id_peran,kode_peran,deskripsi');
		if($sort != '' && $order != '') $this->db->order_by($sort, $order);
        return $this->db->get($this->table);
	}
	
	public function get_by_id($id)
	{
	    #$this->db->select('id_peran,kode_peran,deskripsi');
		$this->db->where('id_peran', $id);
		return $this->db->get($this->table);
	}
	
	public function get_penumpang($crit)
	{
	    $this->db->select('md.nama,md.jenis_identitas,md.no_identitas,md.jenis_kelamin,md.usia');
	    $this->db->join('adm_manifest am', 'md.id_manifest=am.id_manifest', 'left');
	    $this->db->where('am.no_polisi', $crit['nopol']);
	    $this->db->where('CAST(am.tgl AS DATE) = ', $crit['tanggal']);
	    $this->db->order_by('md.nama', 'asc');
	    return $this->db->get($this->table.'_detail md');
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_manifest', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_manifest', $id);
		return $this->db->delete($this->table);
	}
	
}
?>