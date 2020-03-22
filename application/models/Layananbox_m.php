<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Layananbox_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllLayananBox() {
        $query = $this->db->query("SELECT * FROM `jenis_kendaraan` where id>=3");
        return $query->result();
    }
	
	function getLayanan($id) {
        $query = $this->db->query("
                    SELECT * FROM `jenis_kendaraan` where id = '$id'
            ");
        return $query->result_array();
    }
	
	function insertLayanan($jenis, $harga, $hargaminimum, $dimensi, $maxweight, $namafoto) {
        $this->db->query("
                    INSERT INTO `jenis_kendaraan` (`id`, `jenis_kendaraan`, `harga`, `hargaminimum_mbox`, `dimensi_kendaraan`, `maxweight_kendaraan`, `foto_kendaraan`) 
                    VALUES (NULL, '$jenis', '$harga', '$hargaminimum', '$dimensi', '$maxweight', '$namafoto');
            ");
    }
	
	function hapusLayanan($id) {
        $this->db->query("DELETE FROM `jenis_kendaraan` WHERE `id` = $id");
    }

    function updateLayananBox1($id,$jenis, $harga, $hargaminimum, $dimensi, $maxweight, $namafoto) {
        $this->db->query("UPDATE `jenis_kendaraan` SET `jenis_kendaraan` = '$jenis', `harga` = '$harga', `hargaminimum_mbox` = '$hargaminimum', `dimensi_kendaraan` = '$dimensi', `maxweight_kendaraan` = '$maxweight', `foto_kendaraan` = '$namafoto' WHERE `jenis_kendaraan`.`id` = $id;");
    }
	

    function updateLayananBox2($id,$jenis, $harga, $hargaminimum, $dimensi, $maxweight) {
        $this->db->query("UPDATE `jenis_kendaraan` SET `jenis_kendaraan` = '$jenis', `harga` = '$harga', `hargaminimum_mbox` = '$hargaminimum', `dimensi_kendaraan` = '$dimensi', `maxweight_kendaraan` = '$maxweight' WHERE `jenis_kendaraan`.`id` = $id;");
    }

}

