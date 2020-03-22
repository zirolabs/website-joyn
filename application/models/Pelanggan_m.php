<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllPelanggan() {
        $query = $this->db->query("
                SELECT
                id,
                nama_depan,
                nama_belakang,
                email,
                no_telepon,
                alamat,
                created_on, status,
                (select count(id) from transaksi where id_pelanggan = pelanggan.id) as jumlah_transaksi
                FROM pelanggan
                WHERE (status = 1 OR status = 3)
            ");
        return $query->result();
    }

    function editStatusPelanggan($id, $status) {
        $this->db->query("UPDATE `pelanggan` SET `status` = '$status' WHERE `pelanggan`.`id` = '$id';");
    }

    function getJumlahPelangganAktif() {
        $query = $this->db->query("
SELECT COUNT(id) AS jumlah FROM `pelanggan` WHERE `status` = '1';
            ");
        return $query->result_array();
    }

    function getJumlahPelangganNonAktif() {
                $query = $this->db->query("
SELECT COUNT(id) AS jumlah FROM `pelanggan` WHERE `status` = '2';
            ");
        return $query->result_array();
    }

    function getJumlahPelangganBanned() {
                $query = $this->db->query("
SELECT COUNT(id) AS jumlah FROM `pelanggan` WHERE `status` = '3';
            ");
        return $query->result_array();
    }

}