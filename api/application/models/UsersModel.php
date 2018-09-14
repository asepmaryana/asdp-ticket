<?php
class UsersModel extends CI_Model
{
	public $table	= 'acc_pengguna';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function login($username, $password)
	{
		$this->db->select('id_pengguna');
		$this->db->from($this->table);
		$this->db->where('nama_pengguna', $username);
		$this->db->where('sandi', $password);
		$rs = $this->db->get();
		if ($rs->num_rows() > 0) return $rs->row();
		return false;
	}
    
    public function getInfo($key) {
        $this->db->select('u.*');
        $this->db->from($this->table.' u');
        $this->db->join('acc_keys k', 'k.user_id=u.id_pengguna', 'left');
		$this->db->where('k.key', $key);
		$rs = $this->db->get();
        return $rs->row();
    }
    
    public function getUser($username) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('nama_pengguna', $username);
		$rs = $this->db->get();
        if ($rs->num_rows() > 0) return $rs->row();
		return false;
    }
    
    public function getUserByToken($token) {
        $this->db->select('u.*');
        $this->db->from($this->table);
        #$this->db->join('users_authority ua', 'ua.users_id=u.id');
        $this->db->join('acc_keys k', 'k.user_id=u.id_pengguna', 'left');
        $this->db->where('k.key', $token);
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) return $rs->row();
        return false;
    }
    
    public function save($user) {
        return $this->db->insert($this->table, $user);
    }
	
	public function get_by_id($id)
	{
		$this->db->select('u.*,p.deskripsi as role');
		$this->db->join('acc_peran p', 'u.id_peran=p.id_peran', 'left');
		$this->db->where('u.id_pengguna', $id);
		return $this->db->get($this->table.' u');
	}
	
	public function get_by_role($role_id)
	{
	    $this->db->select('u.id');
	    $this->db->join('acc_peran p', 'u.id_peran=p.id_peran', 'left');
		if(is_array($role_id) && count($role_id) > 0) $this->db->where_in('u.id_peran', $role_id);
	    if(!is_array($role_id) && $role_id != '') $this->db->where('u.id_peran', $role_id);
	    return $this->db->get($this->table.' u');
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_pengguna', $id);
		$this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_pengguna', $id);
		return $this->db->delete($this->table);
	}
	
	public function get_count($except, $name, $role_id) {
		$this->db->select('count(u.id_pengguna) as total');
		if(is_array($except) && count($except)>0) $this->db->where_not_in('u.id_pengguna', $except);
		if(!is_array($except) && $except != '') $this->db->where('u.id_pengguna !='.$except);
		if($name != '') $this->db->like('lower(u.nama_lengkap)', $name);
		if($role_id != '') $this->db->where('u.id_peran', $role_id);
		$rs = $this->db->get($this->table.' u');        		
        if($rs->num_rows() > 0) {
            $row = $rs->row();
            return $row->total;
        } else return 0;
	}
	
	public function get_paged_list($except, $name, $role_id, $sort, $order, $limit = 10, $offset = 0) {
		$this->db->select('u.*,p.deskripsi as role');
		$this->db->join('acc_peran p', 'u.id_peran=p.id_peran', 'left');
		if(is_array($except) && count($except)>0) $this->db->where_not_in('u.id_pengguna', $except);
		if(!is_array($except) && $except != '') $this->db->where('u.id_pengguna !='.$except);
		if($name != '') $this->db->like('lower(u.nama_lengkap)', $name);
		if($role_id != '') $this->db->where('u.id_peran', $role_id);
		if($sort != '' && $order != '') $this->db->order_by('u.'.$sort, $order);
        return $this->db->get($this->table.' u', $limit, $offset);
	}	
	
}
?>