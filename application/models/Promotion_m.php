<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllPromotion() {
        $query = $this->db->query("
            SELECT a.id, a.tanggal_dibuat, a.tanggal_berakhir, a.foto, a.is_show, a.action, b.fitur
            FROM `promosi` a, fitur_goeks b
            WHERE a.fitur_promosi = b.id
");
        return $query->result();
    }

    function jumlahPromotion() {
        $query = $this->db->query("SELECT COUNT(id) as jumlah FROM promosi");
        return $query->result_array();
    }

    function tambahPromotion($fiturpromosi, $new_name) {
        $this->db->query("
            INSERT INTO `promosi` (`id`, `tanggal_dibuat`, `tanggal_berakhir`, `fitur_promosi`, `foto`, `is_show`, `action`) 
            VALUES (NULL, CURDATE(), CURDATE(), '$fiturpromosi', '$new_name', 'yes', '$fiturpromosi');
");
    }

    function hapusPromotion($id) {
        $this->db->query("DELETE FROM `promosi` WHERE `id` = $id");
    }

    // ============== PROMOTION_MFOOD =========================
    function getAllNamaResto() {
        $query = $this->db->query("
            SELECT nama_resto
            FROM restoran 
        ");
        return $query->result();
    }

    function getIDResto($namarestoran) {
        $query = $this->db->query("
            SELECT id
            FROM restoran 
            WHERE nama_resto LIKE \"$namarestoran\"
        ");
        return $query->result_array();
    }

    function getAllBannerMfood() {
        $query = $this->db->query("
            SELECT a.id, a.keterangan,a.foto,a.id_resto,a.is_show,b.nama_resto
            FROM promosi_mfood a, restoran b
            WHERE a.id_resto = b.id
        ");
        return $query->result();
    }

    function BannerMfoodTurnon($id) {
        $query = $this->db->query("
            UPDATE `promosi_mfood` SET `is_show` = '1' WHERE `promosi_mfood`.`id` = $id;
        ");
    }

    function BannerMfoodTurnoff($id) {
        $query = $this->db->query("
            UPDATE `promosi_mfood` SET `is_show` = '0' WHERE `promosi_mfood`.`id` = $id;
        ");
    }

    function hapusBannerMfood($id) {
        $query = $this->db->query("
            DELETE FROM promosi_mfood WHERE id = '$id'
        ");
    }

    function tambahBannerMfood($keterangan, $foto, $idresto) {
        $query = $this->db->query("
                    INSERT INTO `promosi_mfood` (`id`, `keterangan`, `foto`, `id_resto`, `is_show`) 
                    VALUES (NULL, '$keterangan', '$foto', '$idresto', '1');
        ");
    }

}

?>
