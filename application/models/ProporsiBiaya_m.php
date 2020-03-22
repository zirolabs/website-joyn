<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProporsiBiaya_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getPersentaseDriver($idfitur) {
        $query = $this->db->query("SELECT persentase_driver FROM `proporsi_biaya` WHERE id_fitur=$idfitur");
        return $query->result_array();
    }
    
    function updateProportsiDriver($nomor, $persentase){
        $this->db->query("UPDATE `proporsi_biaya` 
            SET `persentase_driver` = '$persentase' 
            WHERE `proporsi_biaya`.`nomor` = $nomor;");
    }

}

?>
