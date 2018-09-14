<?php
class KeysModel extends CI_Model
{
	public $table	= 'acc_keys';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_by_id($id)
	{
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}
	
	public function get_by_key($key)
	{
		$this->db->where('key', $key);
		return $this->db->get($this->table);
	}
	
	public function get_by_user($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->get($this->table);
	}
	
	public function save($data)
	{
		return $this->db->insert($this->table, $data);		
	}
	
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}
	
	public function delete_key($key)
	{
		$this->db->where('key', $key);
		return $this->db->delete($this->table);
	}
}
?>