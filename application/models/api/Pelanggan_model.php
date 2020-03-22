<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends MY_Model {


    function __construct() {
        parent::__construct();
    }

    public function check_phone_number($number) {
        $cek = $this->db->query("SELECT id FROM pelanggan where phone='$number'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist($email) {
        $cek = $this->db->query("SELECT id FROM pelanggan where email='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_banned($email) {
        $stat =  $this->db->query("SELECT id FROM pelanggan WHERE status='3' AND email='$email'");
        if($stat->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }

    public function get_data_pelanggan($condition){
        $this->db->select('pelanggan.*, saldo.saldo');
        $this->db->from('pelanggan');
        $this->db->join('saldo', 'pelanggan.id = saldo.id_user');
        $this->db->where($condition);
        return $this->db->get();
    }

    public function signup($data_signup){
        $signup = $this->db->insert('pelanggan', $data_signup);
        
        $dataIns = array(
            'id_user'=>$data_signup['id'],
            'saldo'=>0
        );
        $insSaldo = $this->db->insert('saldo', $dataIns);
        return $signup;
    }

    public function edit_profile($data, $email){
        
        $this->db->where('email', $email);
        $edit = $this->db->update('pelanggan', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
    public function check_password($condition){
        $this->db->select('id');
        $this->db->from('pelanggan');
        $this->db->where($condition);
        $cek = $this->db->get();
        if($cek->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function count_user(){
        $this->db->select('count(id) as count');
        $this->db->from('pelanggan');
        return $this->db->get();
    }

    public function logout($id){
        $data = array(
            'reg_id' => '0'
        );
        
        $this->db->where('id', $id);
        $logout = $this->db->update('pelanggan', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
    public function get_saldo($id){
        $this->db->select('saldo');
        $this->db->from('saldo');
        $this->db->where('id_user', $id);
        $saldo = $this->db->get();
        return $saldo;
    }

    public function check_available_voucher($cond_voucher){
        $this->db->select('*');
        $this->db->from('voucher');
        $this->db->where($cond_voucher);
        $cek = $this->db->get();
        return $cek;
    }
    
    public function redeem_voucher($cond_voucher){
        $this->db->select('nomor');
        $this->db->from('redeemed_voucher');
        $this->db->where($cond_voucher);
        $cek = $this->db->get();
        if($cek->num_rows() == 0){
            $red_voucher = $this->db->insert('redeemed_voucher', $cond_voucher);
            if($this->db->affected_rows() == 1){
                $get_data = $this->get_data_redeem($cond_voucher);
                return array(
                        'status'=> true,
                        'data' => $get_data
                    );
            }else{
                return array(
                        'status'=> false,
                        'data' => []
                    );
            }
        }else{
            return array(
                    'status'=> false,
                    'data' => 'has redeemed'
                );
        }
    }
    
    public function get_data_redeem($red_voucher){
        $this->db->select(
                'redeemed_voucher.id_pelanggan,'
                .'redeemed_voucher.id_voucher,'
                .'voucher.voucher,'
                .'voucher.tanggal_expired,'
                .'voucher.keterangan');
        $this->db->from('redeemed_voucher');
        $this->db->join('voucher', 'redeemed_voucher.id_voucher = voucher.id');
        $this->db->where($red_voucher);
        $cek = $this->db->get();
        return $cek;
    }
    
    public function get_banner_promotion(){
        
        $url_foto = base_url().'../admin/fotopromosi/';
        
        $this->db->select(''
                . 'id,'
                . 'fitur_promosi,'
                . "CONCAT('$url_foto', foto, '') as foto");
        $this->db->from('promosi');
        $this->db->where('is_show', 'yes');
        $promo = $this->db->get();
        return $promo;
    }
    
    public function verify_topup($data_topup){
        $verify = $this->db->insert('topup', $data_topup);
        if($this->db->affected_rows() == 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function get_history_complete($data_user){
        $url_foto = base_url().'../admin/fotodriver/';
        $this->db->select('transaksi.id as id_transaksi,'
                . 'driver.id as id_driver,'
                . 'fitur_goeks.fitur as order_fitur,'
                . 'transaksi.start_latitude,'
                . 'transaksi.start_longitude,'
                . 'transaksi.end_latitude,'
                . 'transaksi.end_longitude,'
                . 'transaksi.waktu_order,'
                . 'transaksi.waktu_selesai,'
                . 'transaksi.waktu_selesai,'
                . 'transaksi.alamat_asal,'
                . 'transaksi.alamat_tujuan,'
                . 'transaksi.harga,'
                . 'transaksi.jarak,'
                . 'status_transaksi.status_transaksi as status,'
                . 'driver.nama_depan as nama_depan_driver,'
                . 'driver.nama_belakang as nama_belakang_driver,'
                . 'driver.no_telepon,'
                . "CONCAT('$url_foto', driver.foto, '') as foto,"
                . 'driver.rating,'
                . 'kendaraan.*');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'status_transaksi.id = history_transaksi.status');
        $this->db->join('driver', 'driver.id = history_transaksi.id_driver');
        $this->db->join('fitur_goeks', 'fitur_goeks.id = transaksi.order_fitur');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id');
        $this->db->where($data_user);
        $this->db->order_by('history_transaksi.nomor DESC');
        $this->db->where("(history_transaksi.status = '5' OR history_transaksi.status = '7' OR history_transaksi.status = '4')", NULL, FALSE);
        $history = $this->db->get('transaksi', 10, 0);
        return $history;
    }
    
    public function get_history_incomplete($data_user){
        $url_foto = base_url().'../admin/fotodriver/';
        
        $this->db->select('transaksi.id as id_transaksi,'
                . 'driver.id as id_driver,'
                . 'fitur_goeks.fitur as order_fitur,'
                . 'transaksi.start_latitude,'
                . 'transaksi.start_longitude,'
                . 'transaksi.end_latitude,'
                . 'transaksi.end_longitude,'
                . 'transaksi.waktu_order,'
                . 'transaksi.waktu_selesai,'
                . 'transaksi.waktu_selesai,'
                . 'transaksi.alamat_asal,'
                . 'transaksi.alamat_tujuan,'
                . 'transaksi.harga,'
                . 'transaksi.jarak,'
                . 'status_transaksi.status_transaksi as status,'
                . 'driver.nama_depan as nama_depan_driver,'
                . 'driver.nama_belakang as nama_belakang_driver,'
                . 'driver.no_telepon,'
                . "CONCAT('$url_foto', driver.foto, '') as foto,"
                . 'driver.rating,'
                . 'driver.reg_id,'
                . 'kendaraan.*');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'status_transaksi.id = history_transaksi.status');
        $this->db->join('driver', 'driver.id = history_transaksi.id_driver');
        $this->db->join('fitur_goeks', 'fitur_goeks.id = transaksi.order_fitur');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id');
        $this->db->where($data_user);
        $this->db->where("(history_transaksi.status = '1' OR history_transaksi.status = '3' OR history_transaksi.status = '6')", NULL, FALSE);
        $this->db->order_by('transaksi.id', 'DESC');
        $history = $this->db->get('transaksi', 10, 0);
        return $history;
    }
    
    function get_biaya(){
        $this->db->select('id as id_fitur,'
                . 'fitur,'
                . 'biaya,'
                . 'keterangan_biaya,'
                . 'biaya_minimum,'
                . 'keterangan');
        
        $biaya = $this->db->get('fitur_goeks');
        $tempBiayaAll = array();
        $tempBiaya = array();
        $queryDiskon = $this->diskon_mpay();
        
        $arrDiskon = array();
        $arrBiayaAkhir = array();
        foreach($queryDiskon->result() as $row){
            $dis = (100.0 - $row->nilai)/100;
            if($dis == 1){
                $dis = "1.0";
            }
            array_push($arrDiskon, $row->nilai."%");
            array_push($arrBiayaAkhir, $dis);
        }
            
        $i = 0;
        foreach($biaya->result() as $row){
            $tempBiaya = array(
                'id_fitur' => $row->id_fitur,
                'fitur' => $row->fitur,
                'biaya' => $row->biaya,
                'biaya_minimum' => $row->biaya_minimum,
                'keterangan_biaya' => $row->keterangan_biaya,
                'keterangan' => $row->keterangan,
                'diskon' => $arrDiskon[$i],
                'biaya_akhir' => $arrBiayaAkhir[$i]
            );
            array_push($tempBiayaAll, $tempBiaya);
            $i++;
        }
        
        $this->db->select('nilai');
        $this->db->where('voucher', 'MPAYDISKON1');
        $diskon = $this->db->get('voucher');
        $disk = array(
            'diskon'=> $diskon->row('nilai')."%",
            'biaya_akhir'=> (100 - $diskon->row('nilai'))/100
        );
        
        $this->db->select('*');
        $this->db->from('biaya_promo');
        $this->db->where('fitur', '3');
        $promo_mfood = $this->db->get('voucher');
        $promo = array(
            'id_fitur'=> $promo_mfood->row('fitur'),
            'biaya'=> $promo_mfood->row('biaya'),
            'biaya_minimum'=> $promo_mfood->row('biaya_minimum'),
            'keterangan_biaya'=> $promo_mfood->row('keterangan_biaya'),
            'diskon'=> $arrDiskon[8],
            'biaya_akhir'=>$arrBiayaAkhir[8]
        );
        $data = array(
            'fitur' => $tempBiayaAll,
            'promo_mfood' => $promo,
            'diskon' => $disk
        );
        
        return $data;
    }
    
    function diskon_mpay(){
//        $disk = $this->db->query("SELECT * FROM voucher WHERE voucher LIKE 'MPAYDISKON%'");
        $this->db->select('*');
        $this->db->from('voucher');
        $this->db->where("voucher LIKE 'MPAYDISKON%'");
        $this->db->order_by('id', 'asc');
        $disk = $this->db->get();
        
        $arrDisk = array();
        
        foreach($disk->result() as $row){
            $diskmpay = array(
                'fitur' => $row->untuk_fitur,
                'diskon' => $row->nilai."%",
                'biaya_akhir' => (100 - $row->nilai)/100
            );
            array_push($arrDisk, $diskmpay);
        }
        return $disk;
    }
    
    function insert_help($data){
        $ins = $this->db->insert('help_pelanggan', $data);
        return $ins;
    }
    
    function getVersions(){
        $this->db->select('version');
        $this->db->where('application', 0);
        $this->db->from('app_versions');
        $getV = $this->db->get();
        return $getV->row('version');
    }
}
