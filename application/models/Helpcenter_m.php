<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Helpcenter_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getHelpcenter() {
        $query = $this->db->query("
                SELECT * FROM `help_pelanggan` a, `pelanggan` b, fitur_promosi c 
                WHERE a.id_pelanggan = b.id 
                AND a.id_fitur = c.id            
");
        return $query->result();
    }

}