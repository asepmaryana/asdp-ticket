<?php
class ConfigEmailModel extends CI_Model
{
	public $table	= 'config_email';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_count() {
		$this->db->select('count(smtp_host) as total');
		$rs = $this->db->get($this->table);        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function fetch()
	{
		return $this->db->get($this->table);
	}
	
	public function save($data)
	{
		return $this->db->insert($this->table, $data);
	}
	
	public function update($id, $data)
	{
		return $this->db->update($this->table, $data);
	}
}
?>