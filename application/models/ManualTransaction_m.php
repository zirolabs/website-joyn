<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ManualTransaction_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

    //    pelanggan ================================================
    function getPelanggan() {
        $query = $this->db->query("SELECT *
                                    FROM pelanggan a, saldo b 
                                    WHERE b.id_user = a.id");
        return $query->result();
    }

    function insertTransaksiPelanggan($tipe, $id, $nominal, $saldoakhir) {
        if ($tipe == 'pengurangan') {
            $query = $this->db->query("INSERT INTO `transaksi_pelanggan` (`nomor`, `id_pelanggan`, `debit`, `kredit`, `waktu`, `id_transaksi`, `tipe_transaksi`, `pakai_mpay`, `saldo`, `keterangan`) 
                VALUES (NULL, '$id', '$nominal', '0', CURRENT_TIMESTAMP, '0', '12', '0', '$saldoakhir', 'pengurangan saldo oleh admin');                
");
        } elseif ($tipe == 'penambahan') {
            $query = $this->db->query("
                INSERT INTO `transaksi_pelanggan` (`nomor`, `id_pelanggan`, `debit`, `kredit`, `waktu`, `id_transaksi`, `tipe_transaksi`, `pakai_mpay`, `saldo`, `keterangan`) 
                VALUES (NULL, '$id', '0', '$nominal', CURRENT_TIMESTAMP, '0', '11', '0', '$saldoakhir', 'penambahan saldo oleh admin');                  
");
        }
    }

    function updateSaldoPelanggan($id, $saldoakhir) {
        $query = $this->db->query("UPDATE `saldo` SET saldo = '$saldoakhir' ,`update_at`= CURRENT_TIMESTAMP WHERE id_user = '$id'");
    }

    //    driver ================================================
    function getDriver() {
        $query = $this->db->query("SELECT *
                                    FROM driver a, saldo b 
                                    WHERE b.id_user = a.id
                                    AND a.status = 1");
        return $query->result();
    }

    function insertTransaksiDriver($tipe, $id, $nominal, $saldoakhir) {
        if ($tipe == 'pengurangan') {
            $query = $this->db->query("   
                                INSERT INTO `transaksi_driver` (`nomor`, `id_driver`, `debit`, `kredit`, `waktu`, `id_transaksi`, `tipe_transaksi`, `saldo`, `keterangan`) 
                VALUES (NULL, '$id', '$nominal', '0', CURRENT_TIMESTAMP, '0', '11', '$saldoakhir', 'pengurangan saldo oleh admin');   
");
        } elseif ($tipe == 'penambahan') {
            $query = $this->db->query("
                INSERT INTO `transaksi_driver` (`nomor`, `id_driver`, `debit`, `kredit`, `waktu`, `id_transaksi`, `tipe_transaksi`, `saldo`, `keterangan`) 
                VALUES (NULL, '$id', '0', '$nominal', CURRENT_TIMESTAMP, '0', '11', '$saldoakhir', 'penambahan saldo oleh admin');                  
");
        }
    }

    function updateSaldoDriver($id, $saldoakhir) {
        $query = $this->db->query("UPDATE `saldo` SET saldo = '$saldoakhir' ,`update_at`= CURRENT_TIMESTAMP WHERE id_user = '$id'");
    }

}