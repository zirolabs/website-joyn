<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    function getAllWithdraw() {
        $query = $this->db->query("
                SELECT
                a.id as id_withdraw,
                b.id,
                b.nama_depan,
                b.nama_belakang,
                b.no_telepon,
                b.email,
                b.nama_bank,
                b.rekening_bank,
                b.atas_nama,
                a.jumlah,
                a.waktu,
                a.status

                FROM
                withdraw a, 
                driver b

                WHERE a.id_driver = b.id
                AND a.status = 1
            ");
        return $query->result();
    }

    function batalWithdraw($id) {
        $query = $this->db->query("
            UPDATE `withdraw` 
            SET `status` = '3' 
            WHERE `withdraw`.`id` = $id;
            ");
    }

    function getJumlahSaldo($iddriver) {
        $query = $this->db->query("SELECT saldo FROM `saldo` WHERE id_user = '$iddriver'");
        return $query->result_array();
    }

    function approveWithdraw($id, $iddriver, $jumlah, $saldo) {

//update withdraw = sukses =======================================================
        $this->db->query("
            UPDATE `withdraw` 
            SET `status` = '2' 
            WHERE `withdraw`.`id` = $id;
            ");

// inisialisasi saldo awal dan akhir ======================================================
        $saldoawal = $saldo;
        $saldopengurangan = $jumlah;
        $saldoakhir = $saldoawal - $saldopengurangan;
        //        echo "   saldo awal = $saldoawal | saldo pengurangan = $saldopengurangan | saldo akhir = $saldoakhir";
// update saldo akhir ==============================================================
        $this->db->query(" UPDATE `saldo` SET `saldo` = '$saldoakhir' , `update_at` = CURRENT_TIME( ) WHERE `id_user` = '$iddriver';");


// insert transaksi driver (debet / pengurangan) ===================================
        $this->db->query("
            INSERT INTO `transaksi_driver` (`nomor`, `id_driver`, `debit`, `kredit`, `waktu`, `id_transaksi`, `tipe_transaksi`, `saldo`, `keterangan`) 
            VALUES (NULL, '$iddriver', '$saldopengurangan', '0', CURRENT_TIMESTAMP, '0', '10', '$saldoakhir', NULL)            
"       );
    }

}