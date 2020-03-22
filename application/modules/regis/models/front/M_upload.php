<?php
class M_upload extends CI_Model{
	function __construct(){
		$this->load->database();
	}

	function read($filter=null, $limit = 0, $offset = 0, $ar_sort = null){
		return $filter;
		
	}

	function insert($namatabel, $data_insert){
			$res = $this->db->insert($namatabel, $data_insert); 
			return $res;
	}

	function update($where, $value, $namatabel, $data_update){
			$res = $this->db->update($namatabel, $data_update, array($where => $value));
			return $res;
	}

	function select_table_order_limit($row, $namatabel, $order_trigger, $limit){
			$this->db->select($row);
			$this->db->from($namatabel);
			$this->db->order_by($order_trigger,"desc");
			$this->db->limit($limit); 
			$query = $this->db->get();
			return $query->result_array();

	}

	function select($row , $namatabel){
			$this->db->select($row);
			$this->db->from($namatabel);
			$query = $this->db->get();
			return $query->result_array();
	}

	function select_where($row , $namatabel, $where, $value){
			$this->db->select($row);
			$this->db->from($namatabel);
			$this->db->where($where, $value);
			$query = $this->db->get();
			return $query->result_array();
	}

	function select_get_jumlah($namatabel){
		$query = $this->db->get($namatabel);
		return $query->num_rows();
	}

	function select_get_jumlah_where($namatabel, $data_where){
		$query = $this->db->get_where($namatabel, $data_where);
		return $query->num_rows();
	}

        function select_get_no_telp_where($data_where1, $data_where2, $data_where3){
                $query = $this->db->get_where("berkas_lamaran_kerja", $data_where1);
		if($query->num_rows() == 0){
                    $query1 = $this->db->get_where("pendaftaran_mmassage", $data_where2);
                    if($query1->num_rows() == 0){
                        $query2 = $this->db->get_where("pendaftaran_acservice", $data_where3);
                        if($query2->num_rows() == 0){
                             return FALSE;
                        }else{
                             return TRUE;
                        }
                    }else{
                        return TRUE;
                    }
                }else{
                    return TRUE;
                }
	}

	function data($row, $number,$offset , $namatabel){
		$this->db->select($row);
		$this->db->from($namatabel);
		$this->db->order_by("tanggal","desc");
		$this->db->limit($number,$offset);
		return $query = $this->db->get()->result();		
	}

	function data_where($row,$namatabel,$where,$value, $number, $offset){
		$this->db->select($row);
		$this->db->from($namatabel);
		$this->db->where($where, $value);
		$this->db->order_by("tanggal","desc");
		$this->db->limit($number,$offset);
		$query = $this->db->get();
		return $query->result(); 		
	}
}
?>