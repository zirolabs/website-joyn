<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_m extends CI_Model {

    function __construct() {
        $this->load->database();
        $this->load->library('session');
    }

//====================================================================================================
    function getAllDriver() {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user , c.merek , c.tipe , e.jenis_kendaraan, c.nomor_kendaraan , c.warna , d.driver_job
                FROM driver a, `status_user` b , kendaraan c, driver_job d , jenis_kendaraan e
                WHERE a.status = b.id 
                AND a.kendaraan = c.id 
                AND a.job = d.id
                AND  c.jenis = e.id
                AND (a.status = 1 OR a.status = 3)
            ");
        return $query->result();
    }

    function getAllDriverMotor() {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user , c.merek , c.tipe , e.jenis_kendaraan, c.nomor_kendaraan , c.warna , d.driver_job
                FROM driver a, `status_user` b , kendaraan c, driver_job d , jenis_kendaraan e
                WHERE a.status = b.id 
                AND a.kendaraan = c.id 
                AND a.job = d.id
                AND  c.jenis = e.id
                AND (a.status = 1 OR a.status = 3)
                AND a.job = 1
            ");
        return $query->result();
    }

    function getAllDriverMcar() {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user , c.merek , c.tipe , e.jenis_kendaraan, c.nomor_kendaraan , c.warna , d.driver_job
                FROM driver a, `status_user` b , kendaraan c, driver_job d , jenis_kendaraan e
                WHERE a.status = b.id 
                AND a.kendaraan = c.id 
                AND a.job = d.id
                AND  c.jenis = e.id
                AND (a.status = 1 OR a.status = 3)
                AND a.job = 2
            ");
        return $query->result();
    }

    function getAllDriverMbox() {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user , c.merek , c.tipe , e.jenis_kendaraan, c.nomor_kendaraan , c.warna , d.driver_job
                FROM driver a, `status_user` b , kendaraan c, driver_job d , jenis_kendaraan e
                WHERE a.status = b.id 
                AND a.kendaraan = c.id 
                AND a.job = d.id
                AND  c.jenis = e.id
                AND (a.status = 1 OR a.status = 3)
                AND a.job = 4
            ");
        return $query->result();
    }

    function getAllMmassage() {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user ,d.driver_job
                FROM driver a, `status_user` b , driver_job d
                WHERE a.status = b.id 
                AND a.job = d.id
                AND (a.status = 1 OR a.status = 3)
                AND a.job = 3
            ");
        return $query->result();
    }

    function getAllMservice() {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user ,d.driver_job
                FROM driver a, `status_user` b , driver_job d
                WHERE a.status = b.id 
                AND a.job = d.id
                AND (a.status = 1 OR a.status = 3)
                AND a.job = 5
            ");
        return $query->result();
    }

//=======================================================================================================
    function resetPassword($idDriver) {
        $query = $this->db->query("UPDATE `driver` 
            SET `password` = 'fdda0c46f953c1a45bdc520849be1e4edf4e228c' 
            WHERE `driver`.`id` = '$idDriver';");
    }

//    ==========================================================================================

    function getJumlahDriverAktif() {
        $query = $this->db->query("
SELECT COUNT(id) AS jumlah FROM `driver` WHERE `status` = '1'
            ");
        return $query->result_array();
    }

    function getJumlahDriverNonAktif() {
        $query = $this->db->query("
SELECT COUNT(id) AS jumlah FROM `driver` WHERE `status` = '2'
            ");
        return $query->result_array();
    }

    function getJumlahDriverBanned() {
        $query = $this->db->query("
SELECT COUNT(id) AS jumlah FROM `driver` WHERE `status` = '3'
            ");
        return $query->result_array();
    }

    //    ==========================================================================================

    function getDriver($idDriver) {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, b.status_user , c.merek , c.tipe , e.jenis_kendaraan, c.nomor_kendaraan , c.warna , d.driver_job, a.kendaraan AS idkendaraan
                FROM driver a, `status_user` b , kendaraan c, driver_job d , jenis_kendaraan e
                WHERE a.status = b.id 
                AND a.kendaraan = c.id 
                AND a.job = d.id
                AND  c.jenis = e.id
                AND a.id = '$idDriver'
            ");
        return $query->result_array();
    }

    function getMmassage($id) {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, d.driver_job, b.status_user
                FROM driver a, `status_user` b ,driver_job d
                WHERE a.id = '$id'
                AND a.job = d.id
            ");
        return $query->result_array();
    }

    function getMservice($id) {
        $query = $this->db->query("
                SELECT a.id, a.nama_depan , a.nama_belakang, a.no_ktp, a.tgl_lahir, a.tempat_lahir, a.no_telepon, a.email, a.password, a.foto, a.rating, d.driver_job, b.status_user
                FROM driver a, `status_user` b ,driver_job d
                WHERE a.id = '$id'
                AND a.job = d.id
            ");
        return $query->result_array();
    }

    //    ==========================================================================================

    function getHistoryTransaksi($idDriver) {
        $query = $this->db->query("
                SELECT b.id , e.fitur , d.nama_depan, d.nama_belakang, c.status_transaksi, a.waktu
                FROM history_transaksi a, transaksi b , status_transaksi c , pelanggan d , fitur_goeks e
                WHERE a.status = c.id
                AND a.id_transaksi = b.id
                AND b.id_pelanggan = d.id
                AND b.order_fitur = e.id
                AND a.id_driver = '$idDriver'
                ORDER BY b.id DESC
                LIMIT 5
            ");
        return $query->result();
    }

    function getAllHistoryTransaksi() {
        $bulan = date("m");
        $tahun = date("Y");

        $query = $this->db->query("
                SELECT a.nomor , e.fitur , d.nama_depan, d.nama_belakang, d.no_telepon, c.status_transaksi, a.waktu, a.id_driver, b.pakai_mpay

                FROM 
                history_transaksi a, 
                transaksi b , 
                status_transaksi c , 
                pelanggan d , 
                fitur_goeks e

                WHERE a.status = c.id
                AND a.id_transaksi = b.id
                AND b.id_pelanggan = d.id
                AND b.order_fitur = e.id
                AND MONTH(a.waktu) = $bulan
                AND YEAR(a.waktu) = $tahun
                ORDER BY b.id DESC
                LIMIT 15
            ");
        return $query->result();
    }

    function getDetilHistoryTransaksi() {

        //$bulan = date("m");
        //$tahun = date("Y");
//        lihat tranasksi tanpa limit 15
        $query = $this->db->query("
                SELECT a.nomor , e.fitur , d.nama_depan, d.nama_belakang, d.no_telepon, c.status_transaksi, a.waktu, a.id_driver, b.pakai_mpay

                FROM 
                history_transaksi a, 
                transaksi b , 
                status_transaksi c , 
                pelanggan d , 
                fitur_goeks e

                WHERE a.status = c.id
                AND a.id_transaksi = b.id
                AND b.id_pelanggan = d.id
                AND b.order_fitur = e.id
                
                ORDER BY b.id DESC
            ");
        return $query->result();
    }
//AND MONTH(a.waktu) = $bulan
//AND YEAR(a.waktu) = $tahun

// CANCEL TRANSAKSI ===========================
    function listCancelTransaksi() {

        $bulan = date("m");
        $tahun = date("Y");
//        lihat tranasksi tanpa limit 15
        $query = $this->db->query("
                SELECT a.nomor , a.id_transaksi, a.id_driver, b.id_pelanggan, e.fitur , d.nama_depan, d.nama_belakang, d.no_telepon, c.status_transaksi, a.waktu, a.id_driver
                
                FROM 
                history_transaksi a, 
                transaksi b , 
                status_transaksi c , 
                pelanggan d , 
                fitur_goeks e

                WHERE a.status = c.id
                AND a.id_transaksi = b.id
                AND b.id_pelanggan = d.id
                AND b.order_fitur = e.id
                AND MONTH(a.waktu) = $bulan
                AND YEAR(a.waktu) = $tahun
                AND (a.status = 3 OR a.status = 6)
                ORDER BY b.id DESC
            ");
        return $query->result();
    }

    function cancelTransaksi($idHistoryTransaksi, $idTrans, $idDriver, $idPelanggan) {

//        query update status 3 to 5 
        $this->db->query("UPDATE `history_transaksi` SET `status` = '5' WHERE `nomor` = '$idHistoryTransaksi';");
        // API backend ke driver dan pelanggan
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://gorideme.fun/api/book/send_cancel_signal/" . $idDriver . "/" . $idPelanggan . "/" . $idTrans);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $stat = curl_exec($ch);
        curl_close($ch);
//        $this->response($stat, 200);
    }

    //========================================================================================
// JUMLAH TRANSAKSI ===================================
//    1 Mencari
//    2 bidding
//    3 success
//    4 rejected
//    5 canceled
//    6 start
//    7 finish
    function getTotalTransaksi($status) {
        $bulan = date("m");
        $tahun = date("Y");

        switch ($status) {
            case 1:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 1
            ");
                return $query->result_array();
                break;

            case 2:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 2
            ");
                return $query->result_array();
                break;

            case 3:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 3
            ");
                return $query->result_array();
                break;

            case 4:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 4
            ");
                return $query->result_array();
                break;

            case 5:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 5
            ");
                return $query->result_array();
                break;

            case 6:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 6
            ");
                return $query->result_array();
                break;

            case 7:
                $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
                AND status = 7
            ");
                return $query->result_array();
                break;

            default:
                break;
        }
    }

//  ==================================================




    function getTotalTransaksiBulanan($bulan, $tahun) {
//        lihat tranasksi tanpa limit 15
        $query = $this->db->query("
                SELECT COUNT(nomor) as jumlah
                FROM history_transaksi
                WHERE MONTH(waktu) = $bulan
                AND YEAR(waktu) = $tahun
            ");
        return $query->result_array();
    }

    function editStatus($id, $status, $nama_depan, $nama_belakang, $no_ktp, $tanggal_lahir, $tempat_lahir) {
        $query = $this->db->query("
                    UPDATE `driver` 
                    SET `nama_depan` = '$nama_depan', 
                    `nama_belakang` = '$nama_belakang', 
                    `no_ktp` = '$no_ktp', 
                    `tanggal_lahir` = '$tanggal_lahir', 
                    `tempat_lahir` = '$tempat_lahir', 
                    `status` = '$status' 
                    WHERE `id` = '$id';            
            ");
    }

    function editKendaraan($tipekendaraan, $merekkendaraan, $nokendaraan, $warnakendaraan, $idkendaraan) {
        $query = $this->db->query("   
            UPDATE `kendaraan` 
            SET 
            `merek` = '$merekkendaraan', 
            `tipe` = '$tipekendaraan', 
            `nomor_kendaraan` = '$nokendaraan', 
            `warna` = '$warnakendaraan' 
            WHERE `kendaraan`.`id` = $idkendaraan; 
            ");
    }

    function editStatusFoto($idDriver, $status, $namadepan, $namabelakang, $ktp, $dob, $tempatlahir, $foto) {
        $query = $this->db->query("
                    UPDATE `driver` 
                    SET `nama_depan` = '$namadepan', 
                    `nama_belakang` = '$namabelakang', 
                    `no_ktp` = '$ktp', 
                    `tgl_lahir` = '$dob', 
                    `tempat_lahir` = '$tempatlahir', 
                    `foto` = '$foto',
                    `status` = '$status' 
                    WHERE `id` = '$idDriver';                   
            ");
    }

    function getSaldoDriver($idDriver) {
        $query = $this->db->query("
                    SELECT * 
                    FROM `saldo` 
                    WHERE id_user = '$idDriver'                 
            ");
        return $query->result_array();
    }

     function hapusfoto($id)
        {
            $driver = $this->Driver_m->getAllDriver($id);

            if(isset($driver->driver))
            {
                unlink('/upload/foto_ktp/'.$driver->foto_ktp);
                $data['foto_ktp'] = "";
                unlink('/upload/foto_profil/'.$driver->foto_profil);
                $data['foto_profil'] = "";
                $this->Driver_m->editStatus($data, $driver->id);
                redirect('admin/barang/sunting');
            }
            else
              show_error('Data Profil tidak ada');
      }

}

?>
