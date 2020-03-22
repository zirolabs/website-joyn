<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DataPendaftarMmassage_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllDataPendaftarMmassage() {
        $query = $this->db->query("
            SELECT * 
            FROM pendaftaran_mmassage 
            WHERE is_valid = 0
            ");
        return $query->result();
    }

    function getDetilPendaftarMmassage($idPelamar) {
        $query = $this->db->query("
            SELECT * 
            FROM pendaftaran_mmassage 
            WHERE is_valid = 0
            AND nomor = '$idPelamar'
            ");
        return $query->result_array();
    }

//      VALIDASI ===============================================================
    function validateMmassage($idPelamar) {
        $query = $this->db->query("
        UPDATE `pendaftaran_mmassage` 
        SET `is_valid` = '1' 
        WHERE `nomor` = $idPelamar;
            ");
    }

    function insertMmassage($namadepan, $noktp, $tgllahir, $tempatlahir, $notlp, $email, $password, $foto, $job, $gender, $keahlian) {
        $countjml = $this->db->query("SELECT COUNT(id) as jumlah FROM driver WHERE id LIKE 'M%'");
        $nilai = $countjml->result_array();
        $nilaitambah = $nilai[0]['jumlah'] + 1 + 35;

//        COPY FILE
//        server
        $fileSekarang = $_SERVER['DOCUMENT_ROOT'] . "/asset/berkas_mmassage/foto_diri/$foto";
        $fileBaru = "./fotommassage/foto$nilaitambah.jpg";
        $fotoServer = "foto$nilaitambah.jpg";
        copy($fileSekarang, $fileBaru);

//        INSERT DRIVER
        $idinsert = "M$nilaitambah";
        $query = $this->db->query("
            INSERT INTO `driver` (`id`, `nama_depan`, `nama_belakang`, `no_ktp`, `tgl_lahir`, `tempat_lahir`, `no_telepon`, `email`, `password`, `foto`, `rating`, `job`, `gender`, `nama_bank`, `rekening_bank`, `atas_nama`, `created_at`, `update_at`, `reg_id`, `status`) 
            VALUES ('$idinsert', '$namadepan', '', '$noktp', '$tgllahir', '$tempatlahir', '$notlp', '$email', '$password', '$fotoServer', '0', '$job', '$gender', NULL, NULL, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL, '1')            
            ");

//        INSERT SALDO
        $dataInsSaldo = array(
            'id_user' => $idinsert,
            'saldo' => 0
        );
        $this->db->insert('saldo', $dataInsSaldo);

//          INSERT CONFIG DRIVER
        $dataInsSetting = array(
            'id_driver' => $idinsert,
            'latitude' => 0,
            'longitude' => 0,
            'uang_belanja' => 1,
            'status' => 5
        );
        $this->db->insert('config_driver', $dataInsSetting);

//          INSERT PEMIJAT IN KEAHLIAN
        $wordArray = explode(",", $keahlian);
        $query = $this->db->query("
            INSERT INTO pemijat_in_keahlian (id_layanan_pijat, id_pemijat) 
            VALUES ('" . implode("' , '$idinsert'), ('", $wordArray) . "' , '$idinsert')");
    }

//    TOLAK ==================================================================================
    function tolakMmassage($idPelamar) {
        $query = $this->db->query("
        UPDATE `pendaftaran_mmassage` 
        SET `is_valid` = '2' 
        WHERE `nomor` = $idPelamar;
            ");
    }

}