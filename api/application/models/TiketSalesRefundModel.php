<?php
class TiketSalesRefundModel extends CI_Model
{
	public $table	= 'trx_tiket_sales_refund';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_list($crit, $sort, $order) {
	    $this->db->select('tsr.id_trx_tiket_sales_refund as id,ts.kode_booking,ts.tgl_berangkat,tsd.nama,jk.jenis_kelamin,tsd.alamat,src.nama_cabang as asal,dst.nama_cabang as tujuan,sr.status_refund');
	    
	    $this->db->join('trx_tiket_sales ts', 'tsr.id_trx_tiket_sales=ts.id_trx_tiket_sales', 'left');
	    $this->db->join('trx_tiket_sales_detail tsd', 'ts.id_trx_tiket_sales=tsd.id_trx_tiket_sales', 'left');
	    $this->db->join('ref_status_refund sr', 'tsr.id_status_refund=sr.id_status_refund', 'left');
	    $this->db->join('ref_cabang src', 'ts.pelabuhan_asal=src.id_cabang', 'left');
	    $this->db->join('ref_cabang dst', 'ts.pelabuhan_tujuan=dst.id_cabang', 'left');
	    $this->db->join('ref_jenis_identitas jid', 'tsd.id_jenis_identitas=jid.id_jenis_identitas', 'left');
	    $this->db->join('ref_jenis_kelamin jk', 'tsd.id_jenis_kelamin=jk.id_jenis_kelamin', 'left');
	    $this->db->join('ref_jenis_layanan jl', 'ts.id_jenis_layanan=jl.id_jenis_layanan', 'left');
	    $this->db->join('ref_golongan gol', 'tsd.id_golongan=gol.id_golongan', 'left');
	    
	    if(isset($crit['kode_booking']) && $crit['kode_booking'] != '') $this->db->like('ts.kode_booking', $crit['kode_booking'], 'both');
	    if(isset($crit['tanggal']) && $crit['tanggal'] != '') $this->db->where('tsr.tgl_pengajuan', $crit['tanggal']);
	    if(isset($crit['status']) && $crit['status'] != '') $this->db->where('tsr.id_status_refund', $crit['status']);
	    
	    if($sort != '' && $order != '') $this->db->order_by($sort, $order);
	    return $this->db->get($this->table.' tsr');
	}
	
	public function get_by_id($id)
	{
	    $this->db->select('id_trx_tiket_sales_refund');
		$this->db->where('id_trx_tiket_sales_refund', $id);
		return $this->db->get($this->table);
	}
	
	public function get_by_tiket_sales($id_trx_tiket_sales)
	{
	    $this->db->select('tsr.id_trx_tiket_sales_refund,tsr.nama_pemohon,tsr.nomor_identitas,tsr.tgl_pengajuan,b.nama_bank,i.jenis_identitas,tsr.rekening,tsr.atas_nama,tsr.alasan');
	    $this->db->join('ref_bank b', 'tsr.id_bank=b.id_bank', 'left');
	    $this->db->join('ref_jenis_identitas i', 'tsr.id_jenis_identitas=i.id_jenis_identitas', 'left');
	    $this->db->where('tsr.id_trx_tiket_sales', $id_trx_tiket_sales);
	    return $this->db->get($this->table.' tsr');
	}
	
	public function get_by_kode_booking($kode_booking)
	{
	    $this->db->select('
        tsr.id_trx_tiket_sales_refund as id,
        ts.tgl_penjualan,
        ts.tgl_berangkat,
        src.nama_cabang as asal,
        dst.nama_cabang as tujuan,
        jl.layanan,
        sp.status_pesan,
        tsr.tgl_pengajuan,
        tsr.nama_pemohon,
        tsr.nomor_identitas,
        ji.jenis_identitas,
        tsr.nomor_telp,
        tsr.rekening,
        tsr.atas_nama,
        tsr.total,
        tsr.refund,
        tsr.alasan,
        sr.status_refund,
        tsr.id_status_refund,
        bank.nama_bank
        ');
	    
	    $this->db->join('trx_tiket_sales ts', 'tsr.id_trx_tiket_sales=tsr.id_trx_tiket_sales', 'left');
	    $this->db->join('ref_status_refund sr', 'tsr.id_status_refund=sr.id_status_refund', 'left');
	    $this->db->join('ref_cabang src', 'ts.pelabuhan_asal=src.id_cabang', 'left');
	    $this->db->join('ref_cabang dst', 'ts.pelabuhan_tujuan=dst.id_cabang', 'left');
	    $this->db->join('ref_jenis_layanan jl', 'ts.id_jenis_layanan=jl.id_jenis_layanan', 'left');
	    $this->db->join('ref_status_pesan sp', 'tsr.id_status_pesan=sp.id_status_pesan', 'left');
	    $this->db->join('ref_jenis_identitas ji', 'tsr.id_jenis_identitas=ji.id_jenis_identitas', 'left');
	    $this->db->join('ref_bank bank', 'tsr.id_bank=bank.id_bank', 'left');
	    
	    $this->db->where('ts.kode_booking', $kode_booking);
	    return $this->db->get($this->table.' tsr');
	}
	
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($id, $data)
	{
		$this->db->where('id_trx_tiket_sales_refund', $id);
		return $this->db->update($this->table, $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id_trx_tiket_sales_refund', $id);
		return $this->db->delete($this->table);
	}
	
}
?>