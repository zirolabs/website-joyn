<?php
class Lokasi_m extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	function get_coordinates()
	{
		$return = array();
		$query = $this->db->query("
			SELECT lat, lng
			FROM lokasi_driver
			WHERE status = 1
			AND lat IS NOT NULL
			AND lng IS NOT NULL
			");
		return $query->result();
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			foreach ($query->result() as $row) {
				array_push($return, $row);
			}
		}
		return $return;
	}
}