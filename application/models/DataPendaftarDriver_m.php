<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DataPendaftarDriver_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllDataPendaftarDriver() {
        $query = $this->db->query("
                SELECT * FROM berkas_lamaran_kerja a, kendaraan b, jenis_kendaraan c, driver_job d
                WHERE a.kendaraan = b.id 
                AND b.jenis = c.id
                AND a.job = d.id
                AND a.is_valid = 'no'
            ");
        return $query->result();
    }

    function getPendaftarDriverMotor() {
        $query = $this->db->query("
                SELECT * 
                FROM berkas_lamaran_kerja a, kendaraan b, jenis_kendaraan c, driver_job d
                WHERE a.kendaraan = b.id
                AND b.jenis = c.id
                AND a.job = d.id
                And a.job = 1
                AND a.is_valid =  'no'
            ");
        return $query->result();
    }

    function getPendaftarMcar() {
        $query = $this->db->query("
                SELECT * FROM berkas_lamaran_kerja a, kendaraan b, jenis_kendaraan c, driver_job d
                WHERE a.kendaraan = b.id 
                AND b.jenis = c.id
                AND a.job = d.id
                And a.job = 2
                AND a.is_valid = 'no'
            ");
        return $query->result();
    }

    function getPendaftarMbox() {
        $query = $this->db->query("
                SELECT * FROM berkas_lamaran_kerja a, kendaraan b, jenis_kendaraan c, driver_job d
                WHERE a.kendaraan = b.id 
                AND b.jenis = c.id
                AND a.job = d.id
                And a.job = 4
                AND a.is_valid = 'no'
            ");
        return $query->result();
    }

//    =============================================================

    function getDetilPendaftarDriver($idPelamar) {
        $query = $this->db->query("
                SELECT * 
                FROM berkas_lamaran_kerja a, kendaraan b, jenis_kendaraan c, driver_job d
                WHERE 
                a.kendaraan = b.id
                AND b.jenis = c.id
                AND a.job = d.id
                AND a.is_valid = 'no'
                AND a.nomor = '$idPelamar'
            ");
        return $query->result_array();
    }

    function validateDriver($idPelamar) {
        $query = $this->db->query("
                UPDATE 'berkas_lamaran_kerja' 
                SET 'is_valid' = 'valid' 
                WHERE 'nomor' = $idPelamar;
            ");
    }

    function tolakDriver($idPelamar) {
        $query = $this->db->query("
                UPDATE 'berkas_lamaran_kerja' 
                SET 'is_valid' = 'tidak valid' 
                WHERE 'nomor' = $idPelamar;
            ");
    }

    function insertDriver($namadepan, $namabelakang, $noktp, $tgllahir, $tempatlahir, $notlp, $email, $password, $foto, $job, $idkendaraan) {
        $countjml = $this->db->query("SELECT COUNT(id) as jumlah FROM driver");
        $nilai = $countjml->result_array();
        $nilaitambah = $nilai[0]['jumlah'] + 1 +71;

//        COPY FILE
//        server
        //$fileSekarang = base_url() . "fotodriver/$foto";
        $fileSekarang = $_SERVER['DOCUMENT_ROOT'] . "/asset/berkas_driver/foto_diri/$foto";
//        local host
        $fileBaru = "./fotodriver/foto$nilaitambah.jpg";
        $fotoServer = "foto$nilaitambah.jpg";
        copy($fileSekarang, $fileBaru);

//        INSERT DRIVER
        $idinsert = "D$nilaitambah";
        $query = $this->db->query("
            INSERT INTO 'driver' ('id', 'nama_depan', 'nama_belakang', 'no_ktp', 'tgl_lahir', 'tempat_lahir', 'no_telepon', 'email', 'password', 'foto', 'rating', 'job', 'kendaraan', 'reg_id', 'status') 
            VALUES ('$idinsert', '$namadepan', '$namabelakang', '$noktp', '$tgllahir', '$tempatlahir', '$notlp', '$email', '$password', '$fotoServer', '0', '$job', '$idkendaraan', '0', '1');
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
            'status' => 2
        );
        $this->db->insert('config_driver', $dataInsSetting);
    }

    function updateProporsiDriver($nomor, $persentase) {
        $this->db->query("UPDATE 'proporsi_biaya' 
            SET 'persentase_driver' = '$persentase' 
            WHERE 'proporsi_biaya'.'nomor' = $nomor;");
    }

}

?>
