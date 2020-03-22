<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Layananpijat_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllLayananPijat() {
        $query = $this->db->query("SELECT * FROM `layanan_pijat`");
        return $query->result();
    }
	
	function getLayanan($id) {
        $query = $this->db->query("
                    SELECT * FROM `layanan_pijat` where id = '$id'
            ");
        return $query->result_array();
    }
	
	function insertLayanan($layanan, $harga, $namafoto) {
        $this->db->query("
                    INSERT INTO `layanan_pijat` (`id`, `layanan`, `harga`, `foto`) 
                    VALUES (NULL, '$layanan', '$harga', '$namafoto');
            ");
    }
	
	function hapusLayanan($id) {
        $this->db->query("DELETE FROM `layanan_pijat` WHERE `id` = $id");
    }

    function updateLayananPijat1($id,$layanan,$harga,$namafoto) {
        $this->db->query("UPDATE `layanan_pijat` SET `layanan` = '$layanan', `harga` = '$harga', `foto` = '$namafoto' WHERE `layanan_pijat`.`id` = $id;");
    }
	

    function updateLayananPijat2($id,$layanan,$harga) {
        $this->db->query("
                    UPDATE `layanan_pijat` 
                    SET `layanan` = '$layanan', `harga` = '$harga'
                    WHERE `layanan_pijat`.`id` = '$id';
            ");
    }

}

