<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Driver_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function check_phone_number($number) {
        $cek = $this->db->query("SELECT id FROM driver where phone='$number'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist($no_telepon, $password) {
        $cek = $this->db->query("SELECT id FROM driver WHERE no_telepon='$no_telepon' AND password='$password'");
        if ($cek->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_banned($notelp) {
        $stat =  $this->db->query("SELECT id FROM driver WHERE status='3' AND no_telepon='$notelp'");
        if($stat->num_rows() == 1){
            return true;
        }else{
            return false;
        }
    }
    
    public function get_data_pelanggan($condition){
        $url_foto = base_url().'admin';
        $fotoDriver = 'fotodriver/';
        $fotoTeknisi = 'fotommassage/';
        $fotoPemijat = 'fotomservice/';
                       
        $this->db->select(""
                . "driver.*,"
                . "CASE driver.job
                    WHEN  '1'
                    THEN  CONCAT('$url_foto/fotodriver/', driver.foto, '')
                    WHEN  '2'
                    THEN  CONCAT('$url_foto/fotodriver/', driver.foto, '')
                    WHEN  '3'
                    THEN  CONCAT('$url_foto/fotommassage/', driver.foto, '')
                    WHEN  '4'
                    THEN  CONCAT('$url_foto/fotodriver/', driver.foto, '')
                    WHEN  '5'
                    THEN  CONCAT('$url_foto/fotomservice/', driver.foto, '')
                    END AS foto,"
                . "saldo");
        $this->db->from('driver');
        $this->db->join('saldo', 'saldo.id_user = driver.id');
        $this->db->where('driver.no_telepon', $condition['no_telepon']);
        $this->db->where('driver.password', $condition['password']);
        $getD = $this->db->get();
        
        $this->db->select('kendaraan.*, jenis_kendaraan.jenis_kendaraan');
        $this->db->from('kendaraan');
        $this->db->join('jenis_kendaraan', 'kendaraan.jenis = jenis_kendaraan.id');
        $this->db->join('driver', 'kendaraan.id = driver.kendaraan');
        $this->db->where('driver.no_telepon', $condition['no_telepon']);
        $getK = $this->db->get();
        
        $this->db->select('config_driver.*');
        $this->db->from('config_driver');
        $this->db->join('driver', 'config_driver.id_driver = driver.id');
        $this->db->where('driver.no_telepon', $condition['no_telepon']);
        $getC = $this->db->get();
        
        return array($getD, $getK, $getC);
    }
    
    public function signup($data_signup){
        $signup = $this->db->insert('driver', $data_signup);
        return $signup;
    }
    
    public function edit_profile($data, $email){
        $this->db->where('email', $email);
        $edit = $this->db->update('driver', $data);
        if($this->db->affected_rows() > 0){
            return array(true, true);
        }else{
            return array(true, false);        
        }
    }
    
    public function edit_reg_id($data, $no_telp){
        $this->db->where('no_telepon', $no_telp);
        $edit = $this->db->update('driver', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
    
    public function setting_profile($data, $id){     
        $this->db->where('id', $id);
        $edit = $this->db->update('driver', $data);
        if($this->db->affected_rows() > 0){
            return array(true, true);
        }else{
            return array(true, false);        
        }
    }
    
    public function setting_profile_email($data, $id){
//        if($this->check_exist($data['email'])){
//            return array(false, false);
//        }else{
            $this->db->where('id', $id);
            $edit = $this->db->update('driver', $data);
            if($this->db->affected_rows() > 0){
                return array(true, true);
            }else{
                return array(true, false);        
            }
//        }   
    }
    
    public function setting_kendaraan($data, $dataCond){
        $this->db->select('kendaraan');
        $this->db->from('driver');
        $this->db->where('id',$dataCond);
        $idK = $this->db->get()->row('kendaraan');
        
        $this->db->where('id', $idK);
        $edit = $this->db->update('kendaraan', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
    function edit_config($data, $id){    
        $this->db->where('id_driver', $id);
        $edit = $this->db->update('config_driver', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
    public function check_password($condition){
        $this->db->select('id');
        $this->db->from('driver');
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
        $this->db->from('driver');
        return $this->db->get();
    }

    public function logout($dataEdit, $id){

        $this->db->where('id', $id);
        $logDriver = $this->db->update('driver', array('reg_id'=> '0'));
        
        $this->db->where('id_driver', $id);
        $logout = $this->db->update('config_driver', $dataEdit);
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
        $this->db->select('*');
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
   
    public function withdrawal($data_with){
        $verify = $this->db->insert('withdraw', $data_with);
        if($this->db->affected_rows() == 1){
            return true;
        }else{
            return false;
        }
    }
        
    public function get_history_complete($data_user){
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
                . 'status_transaksi.status_transaksi as status,'
                . 'driver.nama_depan as nama_depan_driver,'
                . 'driver.nama_belakang as nama_belakang_driver,'
                . 'driver.no_telepon,'
                . 'driver.foto,'
                . 'driver.rating');
        $this->db->from('transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'status_transaksi.id = history_transaksi.status');
        $this->db->join('driver', 'driver.id = history_transaksi.id_driver');
        $this->db->join('fitur_goeks', 'fitur_goeks.id = transaksi.order_fitur');
        $this->db->where($data_user);
        $this->db->where("(history_transaksi.status = '3' OR history_transaksi.status = '5')", NULL, FALSE);
        $history = $this->db->get();
        return $history;
    }
    
    public function get_history_incomplete($data_user){
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
                . 'status_transaksi.status_transaksi as status,'
                . 'driver.nama_depan as nama_depan_driver,'
                . 'driver.nama_belakang as nama_belakang_driver,'
                . 'driver.no_telepon,'
                . 'driver.foto,'
                . 'driver.rating');
        $this->db->from('transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'status_transaksi.id = history_transaksi.status');
        $this->db->join('driver', 'driver.id = history_transaksi.id_driver');
        $this->db->join('fitur_goeks', 'fitur_goeks.id = transaksi.order_fitur');
        $this->db->where($data_user);
        $this->db->where("(history_transaksi.status = '1' OR history_transaksi.status = '2')", NULL, FALSE);
        $history = $this->db->get();
        return $history;
    }
    
    function get_biaya(){
        $this->db->select('id as id_fitur,'
                . 'fitur,'
                . 'biaya,'
                . 'keterangan_biaya,'
                . 'keterangan');
        return $this->db->get('fitur_goeks');
    }
    
    function set_my_Location($data_l){
        $data = array(
            'latitude' => $data_l['latitude'],
            'longitude' => $data_l['longitude']
        );
        $this->db->where('id_driver', $data_l['id_driver']);
        $upd = $this->db->update('config_driver', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
    function getVersions(){
        $this->db->select('version');
        $this->db->where('application', 1);
        $this->db->from('app_versions');
        $getV = $this->db->get();
        return $getV->row('version');
    }
    
    function get_feedback($id){
        $this->db->select(''
                . 'catatan,'
                . 'UNIX_TIMESTAMP(update_at) as update_at');
        $this->db->from('rating_driver');
        $this->db->where($id);
        $this->db->order_by('update_at', 'DESC');
        $getV = $this->db->get();
        return $getV->result();
    }
    
    function get_riwayat_transaksi_order($dataCond){
        $this->db->select(''
                . 'transaksi.id as id_transaksi,'
                . 'UNIX_TIMESTAMP(transaksi_driver.waktu) as waktu_riwayat,'
                . 'pelanggan.nama_depan,'
                . 'pelanggan.nama_belakang,'
                . 'transaksi.jarak,'
                . 'transaksi_driver.debit,'
                . 'transaksi_driver.kredit,'
                . 'transaksi_driver.saldo,'
                . 'transaksi_driver.tipe_transaksi,'
                . 'transaksi_driver.keterangan,'
                . 'fitur_goeks.id as id_fitur,'
                . 'fitur_goeks.fitur');
        $this->db->from('transaksi_driver');
        $this->db->join('transaksi', 'transaksi_driver.id_transaksi = transaksi.id');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->join('fitur_goeks', 'transaksi.order_fitur = fitur_goeks.id');
        $this->db->where($dataCond);
        $dataRT = $this->db->get();
        return $dataRT->result();
    }
    
    function get_riwayat_transaksi_no_order($dataCond){
        $this->db->select(''
                . '"-" as id_transaksi,'
                . 'UNIX_TIMESTAMP(transaksi_driver.waktu) as waktu_riwayat,'
                . '"-" as nama_depan,'
                . '"-" as nama_belakang,'
                . '"-" as jarak,'
                . 'transaksi_driver.debit,'
                . 'transaksi_driver.kredit,'
                . 'transaksi_driver.saldo,'
                . 'transaksi_driver.tipe_transaksi,'
                . '"-" as fitur,'
                . 'transaksi_driver.keterangan,'
                . '"-" as id_fitur');
        $this->db->from('transaksi_driver');
        $this->db->where($dataCond);
        $this->db->where('tipe_transaksi !=', '8');
        $this->db->where('tipe_transaksi !=', '6');
        $this->db->where('tipe_transaksi !=', '5');
        $dataRT = $this->db->get();
        return $dataRT->result();
    }
    
    function get_riwayat_transaksi($dataCond){
         
        $dataAll = array();
        $dataOrder = $this->get_riwayat_transaksi_order($dataCond);
        $dataNotOrder = $this->get_riwayat_transaksi_no_order($dataCond);
        
        foreach($dataOrder as $rowOr){
            array_push($dataAll, $rowOr);
        }
        foreach($dataNotOrder as $rowNor){
            array_push($dataAll, $rowNor);
        }
        return $dataAll;
    }
    
    function get_data_driver($id){
        $url_foto = base_url().'admin/fotodriver/';
        
        $this->db->select(""
                . "driver.*,"
                . "CONCAT('$url_foto', driver.foto, '') as foto,"
                . "saldo,"
                . "config_driver.status as status_config");
        $this->db->from('driver');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->where('driver.id', $id);
        $dataCon = $this->db->get();
        return array(
            'data_driver' => $dataCon,
            'status_order' => $this->check_status_order($id)
        );
    }
    
    function get_current_order($id, $idTrans){
        
        $this->db->select(''
                . 'transaksi.*,'
                . 'history_transaksi.status as status_order,'
                . 'pelanggan.nama_depan,'
                . 'pelanggan.nama_belakang,'
                . 'pelanggan.reg_id as reg_id_pelanggan,'
                . 'pelanggan.no_telepon as telepon');
        $this->db->from('history_transaksi');
        $this->db->join('transaksi', 'history_transaksi.id_transaksi = transaksi.id');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->where('history_transaksi.id_driver', $id);
        $this->db->where('history_transaksi.id_transaksi', $idTrans);
//        $this->db->where("(history_transaksi.status = '3' OR history_transaksi.status = '6')", NULL, FALSE);
        $dataCurr = $this->db->get();
        return $dataCurr;
    }
    
    function check_status_order($idDriver){
        $this->db->select(''
                . 'transaksi.*,'
                . 'history_transaksi.*,'
                . 'pelanggan.id,'
                . 'pelanggan.nama_depan,'
                . 'pelanggan.nama_belakang,'
                . 'pelanggan.no_telepon as telepon,'
                . 'pelanggan.reg_id as reg_id_pelanggan');
        $this->db->join('transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->where("(history_transaksi.status = '3' OR history_transaksi.status = '6')", NULL, FALSE);
        $this->db->where('history_transaksi.id_driver', $idDriver);
        $this->db->order_by('history_transaksi.nomor', 'DESC');
        $check = $this->db->get('history_transaksi', 1,0);
        return $check;
    }
    
    function change_status_driver($idD, $stat_order){
        
        
        $params = array(
            'status' => $stat_order
        );
        $this->db->where('id_driver', $idD);
        $upd = $this->db->update('config_driver', $params);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;        
        }
    }
    
}
