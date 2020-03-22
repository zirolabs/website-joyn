<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Biayapromo_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getBiayaPromoMfood() {
        $query = $this->db->query("
                SELECT * FROM `biaya_promo` where fitur = 3
            ");
        return $query->result_array();
    }

    function updateBiayaPromoMfood($biaya, $biayaminimum) {
        $query = $this->db->query("
                UPDATE `biaya_promo` SET `biaya` = '$biaya' , `biaya_minimum` = '$biayaminimum' WHERE `biaya_promo`.`fitur` = 3;
            ");
    }

}