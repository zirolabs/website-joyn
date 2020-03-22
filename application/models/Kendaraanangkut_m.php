<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraanangkut_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getKendaraanAngkut() {
        $query = $this->db->query("SELECT * FROM `jenis_kendaraan`  WHERE `id` IN (3,4,5,6)");
        return $query->result_array();
    }

    function updateKendaraanAngkut($harga,$minimum,$id) {
        $this->db->query("UPDATE  `jenis_kendaraan` SET `harga` = '$harga', `hargaminimum_mbox` = '$minimum' WHERE  `id` = $id;");
    }

}

