<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fiturgoeks_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

//    GET FUNCTION
    function getMride() {
        $query = $this->db->query("SELECT * FROM `layanan_pijat` WHERE fitur = 'm-ride'");
        return $query->result_array();
    }

    function getMcar() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-car'");
        return $query->result_array();
    }

    function getMfood() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-food'");
        return $query->result_array();
    }

    function getMmart() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-mart'");
        return $query->result_array();
    }

    function getMsend() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-send'");
        return $query->result_array();
    }

    function getMmassage() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-massage'");
        return $query->result_array();
    }

    function getMbox() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-box'");
        return $query->result_array();
    }

    function getMservice() {
        $query = $this->db->query("SELECT * FROM `fitur_goeks` WHERE fitur = 'm-service'");
        return $query->result_array();
    }
    
//    UPDATE FUNCTION

    function updateMride($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum'  WHERE fitur = 'm-ride'");
    }

    function updateMcar($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-car'");
    }

    function updateMfood($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-food'");
    }

    function updateMmart($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-mart'");
    }

    function updateMsend($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-send'");
    }

    function updateMmassage($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-massage'");
    }

    function updateMbox($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-box'");
    }

    function updateMservice($biaya, $biayaminimum) {
        $this->db->query("UPDATE `fitur_goeks` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE fitur = 'm-service'");
    }

}

?>
