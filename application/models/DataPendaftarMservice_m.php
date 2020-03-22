<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DataPendaftarMservice_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllDataPendaftarMservice() {
        $query = $this->db->query("
            SELECT * 
            FROM pendaftaran_acservice 
            WHERE is_valid = 0
            ");
        return $query->result();
    }

    function getDetilPendaftarMservice($idPelamar) {
        $query = $this->db->query("
            SELECT * 
            FROM pendaftaran_acservice 
            WHERE is_valid = 0
            AND nomor = '$idPelamar'
            ");
        return $query->result_array();
    }

//      VALIDASI ===============================================================
    function validateMservice($idPelamar) {
        $query = $this->db->query("
        UPDATE pendaftaran_acservice 
        SET `is_valid` = '1' 
        WHERE `nomor` = $idPelamar;
            ");
    }

    function insertMservice($namadepan, $noktp, $tgllahir, $tempatlahir, $notlp, $email, $password, $foto, $job, $gender, $keahlian) {
        $countjml = $this->db->query("SELECT COUNT(id) as jumlah FROM driver WHERE id LIKE 'T%'");
        $nilai = $countjml->result_array();
        $nilaitambah = $nilai[0]['jumlah'] + 1;

//        COPY FILE
//        server
        $fileSekarang = $_SERVER['DOCUMENT_ROOT'] . "/asset/berkas_mservice/foto_diri/$foto";
        $fileBaru = "./fotomservice/foto$nilaitambah.jpg";
        $fotoServer = "foto$nilaitambah.jpg";
        copy($fileSekarang, $fileBaru);

//        INSERT DRIVER
        $idinsert = "T$nilaitambah";
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
            INSERT INTO teknisi_in_jenis_service (id_service, id_teknisi) 
            VALUES ('" . implode("' , '$idinsert'), ('", $wordArray) . "' , '$idinsert')");
    }

//    TOLAK ==================================================================================
    function tolakMservice($idPelamar) {
        $query = $this->db->query("
        UPDATE pendaftaran_acservice
        SET `is_valid` = '2' 
        WHERE `nomor` = $idPelamar;
            ");
    }

}