<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kategoriresto_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllKategori() {
        $query = $this->db->query("
                    SELECT * FROM `kategori_resto`
            ");
        return $query->result();
    }

    function getKategori($idKategori) {
        $query = $this->db->query("
                    SELECT * FROM `kategori_resto` where id = '$idKategori'
            ");
        return $query->result_array();
    }

    function insertKategori($kategori, $namafoto) {
        $this->db->query("
                    INSERT INTO `kategori_resto` (`id`, `kategori`, `foto`) 
                    VALUES (NULL, '$kategori', '$namafoto');
            ");
    }

    function editKategori1($idketegori, $kategori, $namafoto) {
        $this->db->query("
            UPDATE `kategori_resto` 
            SET `kategori` = '$kategori', `foto` = '$namafoto' 
            WHERE `kategori_resto`.`id` = '$idketegori';
       ");
    }
	
	function hapusKategori($id) {
        $this->db->query("DELETE FROM `kategori_resto` WHERE `id` = $id");
    }

    function editKategori2($idketegori, $kategori) {
        $this->db->query("
                    UPDATE `kategori_resto` 
                    SET `kategori` = '$kategori' 
                    WHERE `kategori_resto`.`id` = '$idketegori';
            ");
    }

}