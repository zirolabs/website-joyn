<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mitra_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getEmailMfood($idMitra) {
        $query = $this->db->query("
                SELECT email_penanggung_jawab
                FROM `mitra_mmart_mfood`
                WHERE id = $idMitra
            ");
        return $query->result_array();
    }

    function getPendaftarMitraMfood() {
        //mengambil data mitra mfood
        $query = $this->db->query("
                SELECT a.id as idmitra , a.nama_pemilik , a.jenis_identitas, a.nomor_identitas, a.alamat_pemilik, a.kota, a.nama_penanggung_jawab, a.email_penanggung_jawab, a.telepon_penanggung_jawab, a.is_valid, b.id as idresto, b.nama_resto, b.alamat, b.deskripsi_resto 
                FROM `mitra_mmart_mfood` a , restoran b 
                WHERE a.jenis_lapak = 1 
                AND a.is_valid = 0
                AND a.lapak = b.id
            ");
        return $query->result();
    }

    function getAllMitraMfood() {
        //mengambil data mitra mfood
        $query = $this->db->query("
                SELECT a.id as idmitra , a.nama_pemilik , a.jenis_identitas, a.nomor_identitas, a.alamat_pemilik, a.kota, a.nama_penanggung_jawab, a.email_penanggung_jawab, a.telepon_penanggung_jawab, a.is_valid, b.id as idresto, b.nama_resto, b.alamat, b.deskripsi_resto 
                FROM `mitra_mmart_mfood` a , restoran b 
                WHERE a.jenis_lapak = 1 
                AND a.is_valid in ('1', '2')
                AND a.lapak = b.id
            ");
        return $query->result();
    }

    function updateStatusMfood($idmitra, $status, $idresto) {
        // 1 = aktif , 2 = Non Aktif , 3 = Delete  .... setiap ubah status mitra, ubah juga status restoranya

        if ($status == '1') {
            // update status mitra
            $this->db->query("
                UPDATE `mitra_mmart_mfood` SET `is_valid` = '1' WHERE `mitra_mmart_mfood`.`id` = $idmitra;
            ");
            // update status resto
            $this->db->query("
                UPDATE `restoran` SET `status` = '1' WHERE `id` = $idresto;
            ");
        } elseif ($status == '2') {
            // update status mitra
            $this->db->query("
                UPDATE `mitra_mmart_mfood` SET `is_valid` = '2' WHERE `mitra_mmart_mfood`.`id` = $idmitra;
            ");
            // update status resto
            $this->db->query("
                UPDATE `restoran` SET `status` = '2' WHERE `id` = $idresto;
            ");
        } elseif ($status == '3') {
            // update status mitra
            $this->db->query("
                UPDATE `mitra_mmart_mfood` SET `is_valid` = '3' WHERE `mitra_mmart_mfood`.`id` = $idmitra;
            ");
            // update status resto
            $this->db->query("
                UPDATE `restoran` SET `status` = '2' WHERE `id` = $idresto;
            ");
        }
    }

    function tolakPendaftaranMfood($idmitra, $idresto) {
        $this->db->query("DELETE FROM `mitra_mmart_mfood` WHERE `id` = $idmitra");
        $this->db->query("DELETE FROM `restoran` WHERE `id` = $idresto");
    }

    function validasiMfood($idMitra, $idResto) {

        $this->db->query("
                UPDATE `mitra_mmart_mfood` SET `is_valid` = '1' WHERE `id` = '$idMitra';
            ");

        $this->db->query("
                UPDATE `restoran` SET `status` = '1' WHERE `id` = '$idResto';
            ");
    }

}

