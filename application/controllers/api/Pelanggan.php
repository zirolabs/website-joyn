<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Pelanggan extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('models/Pelanggan_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get() {
        $this->response("Ok :)", 200);
    }

    function tes_koneksi_get() {
        $this->response("Ok :)", 200);
    }

    function tes_data_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $this->response($decoded_data->email, 200);
    }

    function login_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $reg_id = array(
            'reg_id' => $decoded_data->reg_id
        );

        $condition = array(
            'password' => sha1($decoded_data->password),
            'email' => $decoded_data->email
        );
        $check_banned = $this->Pelanggan_model->check_banned($decoded_data->email);
        if ($check_banned) {
            $message = array(
                'message' => 'banned',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
            $message = array();
            
            if ($cek_login->num_rows() > 0){
                $upd_regid = $this->Pelanggan_model->edit_profile($reg_id, $decoded_data->email);
                $get_pelanggan = $this->Pelanggan_model->get_data_pelanggan($condition);
                $message = array(
                    'message' => 'found',
                    'data' => $get_pelanggan->result()
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'message' => 'not found',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }

    function register_user_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $email = $dec_data->email;
        $check_exist = $this->Pelanggan_model->check_exist($email);
        if ($check_exist) {
            $message = array(
                'message' => 'user exist',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $count_user = $this->Pelanggan_model->count_user()->row('count') + 1;
            $data_signup = array(
                'id' => 'P' . $count_user,
                'nama_depan' => $dec_data->nama_depan,
                'nama_belakang' => $dec_data->nama_belakang,
                'email' => $dec_data->email,
                'no_telepon' => $dec_data->no_telepon,
                'password' => sha1($dec_data->password),
                'alamat' => $dec_data->alamat,
                'tgl_lahir' => $dec_data->tgl_lahir,
                'tempat_lahir' => $dec_data->tempat_lahir,
                'reg_id' => $dec_data->reg_id,
            );
            $signup = $this->Pelanggan_model->signup($data_signup);
            if ($signup) {
                $condition = array(
                    'password' => sha1($dec_data->password),
                    'email' => $dec_data->email
                );
                $datauser = $this->Pelanggan_model->get_data_pelanggan($condition);
                $message = array(
                    'message' => 'success',
                    'data' => $datauser->result()
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'message' => 'failed',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }

    function update_profile_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $data_profile = array(
            'nama_depan' => $dec_data->nama_depan,
            'nama_belakang' => $dec_data->nama_belakang,
            'no_telepon' => $dec_data->no_telepon,
            'alamat' => $dec_data->alamat,
            'tgl_lahir' => $dec_data->tgl_lahir,
            'tempat_lahir' => $dec_data->tempat_lahir
        );

        $upd_profile = $this->Pelanggan_model->edit_profile($data_profile, $dec_data->email);
        if ($upd_profile){
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function change_password_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $cond_pw = array(
            'email' => $dec_data->email,
            'password' => sha1($dec_data->current_password)
        );
        
        $check_password = $this->Pelanggan_model->check_password($cond_pw);
            
        if(!$check_password){
            $message = array(
                'message' => 'incorrect password',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            $data_profile = array(
                'id' => $dec_data->id,
                'email' => $dec_data->email,
                'password' => sha1($dec_data->new_password),
            );
            
            $upd_profil = $this->Pelanggan_model->edit_profile($data_profile, $dec_data->email);
            if($upd_profil){ 
                $message = array(
                    'message' => 'success',
                    'data' => []
                );
                $this->response($message, 200);
            }else{
                $message = array(
                    'message' => 'fail',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }
    
    function redeem_voucher_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $ava_voucher = array(
            'voucher'=>$dec_data->kode_voucher,
            'is_valid'=>'yes'
        );
        
        $is_available = $this->Pelanggan_model->check_available_voucher($ava_voucher);
        if($is_available->num_rows() > 0){
            $rede_voucher = array(
                'id_pelanggan' => $dec_data->id,
                'id_voucher' => $is_available->row('id'),
                'count_of_use' => $is_available->row('count_to_use')
            );
            $redeem_voucher = $this->Pelanggan_model->redeem_voucher($rede_voucher);
            
            if($redeem_voucher['status']){
                $message = array(
                    'message' => 'success',
                    'data' => $redeem_voucher['data']->result()
                );
                $this->response($message, 200);
            }else{
                $message = array(
                    'message' => 'has redeemed',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }else{
            $message = array(
                'message' => 'not found',
                'data' => []
            );
            $this->response($message, 200);
        }   
    }
    
    function banner_promosi_get(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $get_banner = $this->Pelanggan_model->get_banner_promotion();
        
        if($get_banner->num_rows() > 0){                
            $message = array(
                'message' => 'banner found',
                'data' => $get_banner->result()
            );
            $this->response($message, 200);
        }
    }

    function logout_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $logout = $this->Pelanggan_model->logout($dec_data->id);
        if($logout){
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function get_saldo_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $saldo = $this->Pelanggan_model->get_saldo($dec_data->id);
        $message = array(
            'message' => 'success',
            'data' => $saldo->row('saldo')
        );
        $this->response($message, 200);
    }
    
    function detail_fitur_get(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $biaya = $this->Pelanggan_model->get_biaya();
        $message = array(
            'data' => $biaya['fitur'],
            'diskon_mpay' => $biaya['diskon'],
            'mfood_mitra' => $biaya['promo_mfood']
        );
        $this->response($message, 200);
    }
    
    function verifikasi_topup_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $idUser = $dec_data->id;
        if($idUser == NULL){
            $idUser = $dec_data->id_user;        
        }
        
        $adate = $dec_data->id.'_'.date("yyyyMMdd_HHmmss");
        $url_foto = '/home/nkrilbtb/gorideme.fun/api/assets/berkas_topup/user/';
        
        $saving = $this->save_image($url_foto, $dec_data->bukti, $adate);
        
        if($saving){
            $data_topup = array(
                'id_user' => $dec_data->id,
                'no_rekening' => $dec_data->no_rekening,
                'atas_nama' => $dec_data->atas_nama,
                'jumlah' => $dec_data->jumlah,
                'bukti' => $adate.".jpg",
                'bank' => $dec_data->bank
            );
            $topup = $this->Pelanggan_model->verify_topup($data_topup);
            if($topup){
                $message = array(
                    'message' => 'success',
                    'data' => []
                );
                $this->response($message, 200);            
            }else{
                $message = array(
                    'message' => 'fail',
                    'data' => []
                );
                $this->response($message, 200);            
            }
        }else{
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200); 
        }   
    }
   
    function save_image($url_foto, $base, $name){
        if (isset($base)) {
            $image_name = $name.".jpg";
            // base64 encoded utf-8 string
            $binary = base64_decode($base);
            // binary, utf-8 bytes
            $success = file_put_contents($url_foto.$image_name, $binary);
//            $file = fopen($url_foto.$image_name, "w+"); 
//            fwrite($file, $binary);	
//            fclose($file);
//            $angle = 0;
//            $source = imagecreatefromstring($binary);
//            $rotate = imagerotate($source, $angle, 0); // if want to rotate the image
//            $success = imagejpeg($rotate, $url_foto.$image_name, 100);
//            imagedestroy($source);
            return $success;
        }else{
            return FALSE;
        }
   }
    
    function complete_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $cond = array(
            'transaksi.id_pelanggan' => $dec_data->id,
        );
        
        $hist = $this->Pelanggan_model->get_history_complete($cond);
        $message = array(
            'data' => $hist->result()
        );
        $this->response($message, 200);
    }
    
    function inprogress_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $cond = array(
            'transaksi.id_pelanggan' => $dec_data->id,
        );
        
        $hist = $this->Pelanggan_model->get_history_incomplete($cond);
        $message = array(
            'data' => $hist->result()
        );
        $this->response($message, 200);
    }
     
    function user_send_help_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $helpData = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'id_fitur' => $dec_data->id_fitur,
            'subjek' => $dec_data->subjek,
            'isi_bantuan' => $dec_data->isi_bantuan,
            'is_helped' => 0
        );
        
        $helpM = $this->Pelanggan_model->insert_help($helpData);
        if($helpM){
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function one_get($cust_id) {
        $this->db->where('id', $cust_id);
        $cust = $this->db->get('customer')->result();
        $response = array(
            "status" => true,
            "message" => $cust
        );
        $this->response($response, 200);
    }

    function my_location_post($id) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('customer');
        $hasil = $this->db->get();

        if ($id == $hasil->row()->id) {
            $data = array(
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude')
            );
            $this->db->where('id =', $id);
            $this->db->update('customer', $data);
            if (false) {
                $this->response(array('status' => 'failed'));
            } else {
                $this->db->where('id', $id);
                $query = $this->db->get('customer');
                $this->response($query->result(), 200);
            }
        } else {
            $status = array(
                'status' => false,
                'message' => 'login terlebih dahulu'
            );
            $this->response($status, 200);
        }
    }

    function driver_post() {
        $rad = 20;
        $lat = $this->input->post('latitude');
        $lng = $this->input->post('longitude'); //put a temporary number in as it wont pass the lng in the JSON
        
        $result = $this->db->query("SELECT*,
    ( 6371 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( latitude) ) ) ) AS distance
FROM driver
HAVING distance <= $rad
ORDER BY distance ASC");
        $this->response($result->result(), 200);
    }

    function my_transaction_get($stat) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('customer');
        $hasil = $this->db->get();
        if ($hasil->num_rows() == 1) {
            $this->db->select('transaction.*');
            $this->db->from('transaction');
            $this->db->where('transaction.status =' . $stat);
            $this->db->where('transaction.id_customer', $hasil->row()->id);
            $this->db->order_by('order_time', 'DESC');
            $driver = $this->db->get()->result();

            $this->response($driver, 200);
        } else {
            $status = array(
                'status' => false,
                'message' => 'crap thats somethings wrong'
            );
            $this->response($status, 200);
        }
    }

    function tracking_get($id) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('customer');
        $hasil = $this->db->get();
        if ($hasil->num_rows() == 1) {
            $this->db->select('transaction.from_latitude, transaction.from_longitude,transaction.to_latitude, 
            transaction.to_longitude, driver.latitude, driver.longitude, transaction.type');
            $this->db->from('transaction');
            $this->db->join('driver', 'driver.id = transaction.id_driver');
            $this->db->where('transaction.id', $id);
            $driver = $this->db->get()->result();

            $this->response($driver, 200);
        } else {
            $status = array(
                'status' => false,
                'message' => 'crap thats somethings wrong'
            );
            $this->response($status, 200);
        }
    }

    function all_transaction_get() {
        $this->db->select('transaction.*');
        $driver = $this->db->get('transaction')->result();

        $this->response($driver, 200);
    }

    function one_transaction_get($id) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('customer');
        $hasil = $this->db->get();
        if ($hasil->num_rows() == 1) {
            $this->db->select('transaction.*,driver.name, driver.phone, images.file as image');
            $this->db->from('transaction');
            $this->db->join('driver', 'driver.id = transaction.id_driver');
            $this->db->join('images', 'images.content_id = transaction.id_driver');
            $this->db->where('images.content_type', 'driver');
            $this->db->where('transaction.id', $id);
            $this->db->where('transaction.status >=' . '1');
            $driver = $this->db->get()->result();

            $this->response($driver, 200);
        } else {
            $status = array(
                'status' => false,
                'message' => 'crap thats somethings wrong'
            );
            $this->response($status, 200);
        }
    }

    function one_transaction_charge_get($id) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('customer');
        $hasil = $this->db->get();
        if ($hasil->num_rows() == 1) {
            $this->db->select('transaction_charge.*');
            $this->db->from('transaction_charge');
            $this->db->where('id_transaction =' . $id);
            $data = $this->db->get()->result();
            $this->response($data, 200);
        } else {
            $status = array(
                'status' => false,
                'message' => 'crap thats somethings wrong'
            );
            $this->response($status, 200);
        }
    }

    function cancel_transaction_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('customer');
        $hasil = $this->db->get();
        if ($hasil->num_rows() == 1) {
            $this->db->where('id', $this->input->post('id'));
            $this->db->delete('transaction');
            $status = array(
                'status' => true,
                'message' => 'Successed Delete Transaction'
            );
            $this->response($status, 200);
        } else {
            $status = array(
                'status' => false,
                'message' => 'crap thats somethings wrong'
            );
            $this->response($status, 200);
        }
    }

    function msort($array, $key, $sort_flags = SORT_REGULAR) {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = array();
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        // @TODO This should be fixed, now it will be sorted as string
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }
                asort($mapping, $sort_flags);
                $sorted = array();
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }
                return $sorted;
            }
        }
        return $array;
    }

    function trans_location_get() {
        $this->db->select('start_latitude as latitude,start_longitude as longitude,"start" as content');
        $start = $this->db->get('transaction');
        $this->db->select('end_latitude as latitude,end_longitude as longitude,"end" as content');
        $end = $this->db->get('transaction');
        $response = array(
            "markers" => array($start->result_array(), $end->result_array())
        );
        $this->response($response, 200);
    }

    private function send_gcm_post($result, $message, $status) {

        $this->db->where('id =', $message);
        $this->db->from('transaction');
        $deposit = $this->db->get()->last_row()->cost_deposit;
        $data = array('id' => $message);
        for ($i = 0; $i < ($result->num_rows()); $i++) {
            $this->load->library('gcm');
            $this->gcm->setMessage('Test ' . date('d.m.Y H:s:i'));
            $where = 'id = ' . $result->row($i)->id;
            $this->db->where($where);
            $update2 = $this->db->update('driver', array('status' => 0));
            //echo $result->row($i)->status;
            $this->gcm->addRecepient($result->row($i)->reg_id);
            if ($status == true) {
                $this->gcm->setData($data);
                $this->gcm->setTtl(500);
                $this->gcm->setTtl(false);
                $this->gcm->setGroup('Test');
                $this->gcm->setGroup(false);
            }
        }$this->gcm->send();
    }

    function coba_send_gcm_get($id) {

        $this->db->where('id =', '873');
        $this->db->from('transaction');
        $deposit = $this->db->get()->last_row()->cost_deposit;
        $data = array('id' => 873);
        //for ($i = 0; $i < ($result->num_rows()); $i++) {
        $this->load->library('gcm');
        $this->gcm->setMessage('Test ' . date('d.m.Y H:s:i'));
        $where = 'id = ' . $id;
        $this->db->where($where);
        $update2 = $this->db->update('driver', array('status' => 0));
        //echo $result->row($i)->status;

        $where = 'id = ' . $id;
        $this->db->from('driver');
        $this->db->where($where);
        $this->gcm->addRecepient($this->db->get()->last_row()->reg_id);
        //if ($status == true) {
        $this->gcm->setData($data);
        $this->gcm->setTtl(500);
        $this->gcm->setTtl(false);
        $this->gcm->setGroup('Test');
        $this->gcm->setGroup(false);



        //}
        //}
        $this->gcm->send();
    }

    function pickme_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");

            return false;
        }
        $time = date("Y-m-d H:i:s");
        if ($this->input->post('start_time') != "")
            $time = $this->input->post('start_time');

        $data = array(
            'id_driver' => 0,
            'id_customer' => $this->input->post('id_customer'),
            'from_longitude' => $this->input->post('from_longitude'),
            'from_latitude' => $this->input->post('from_latitude'),
            'from_contact_phone' => $this->input->post('from_contact_phone'),
            'from_contact_name' => $this->input->post('from_contact_name'),
            'from_location' => $this->input->post('from_location'),
            'from_location_details' => $this->input->post('from_location_details'),
            'from_instructions' => $this->input->post('from_instructions'),
            'to_longitude' => $this->input->post('to_longitude'),
            'to_latitude' => $this->input->post('to_latitude'),
            'to_contact_phone' => $this->input->post('to_contact_phone'),
            'to_contact_name' => $this->input->post('to_contact_name'),
            'to_location' => $this->input->post('to_location'),
            'to_location_details' => $this->input->post('to_location_details'),
            'to_instructions' => $this->input->post('to_instructions'),
            'id_extra_insurance' => $this->input->post('id_extra_insurance'),
            'loading_service' => $this->input->post('loading_service'),
            'price' => $this->input->post('price'),
            'item' => $this->input->post('item'),
            'status' => 0,
            'reg_id' => $this->input->post('reg_id'),
            'type' => $this->input->post('type'),
            'order_time' => date("Y-m-d H:i:s"),
            'start_time' => $time,
            'cost_deposit' => $this->input->post('deposit')
                // 'end_time' => $this->input->post('end_time')
        );
        $count = $this->input->post('distance');

        if (false) {
            $this->response(array('status' => 'failed'));
        } else {
            $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
            $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
            $this->db->where('reg_id', $this->input->post('reg_id'));
            $this->db->from('customer');
            $hasil = $this->db->get();
            if ($hasil->num_rows() == 1) {
                $type = $this->input->post('type');

                if ($type == "food") {
                    $type = "ojek";
                }

                $result = $this->finding_driver_get($this->input->post('from_latitude'), $this->input->post('from_longitude'), $type, $count, $this->input->post('deposit'));
                if ($result->num_rows() == 0) {
                    $status = array(
                        'status' => false,
                        'message' => 'Driver Sedang Tidak Aktif,' . $this->input->post('from_latitude')
                    );

                    $this->response($status, 200);
                } else {
                    $loc = array(
                        'latitude' => $this->input->post('my_lat'),
                        'longitude' => $this->input->post('my_long')
                    );

                    $this->db->insert('transaction', $data);
                    $this->db->where('email =', $_SERVER['PHP_AUTH_USER']);
                    $this->db->where('email =', $_SERVER['PHP_AUTH_USER']);
                    $this->db->update('customer', $loc);
                    $this->pickme_get($result);
                }

                // $this->response(array($data));
            } else {

                $status = array(
                    'status' => false,
                    'message' => 'Silahkan Login Kembali ' . ($_SERVER['PHP_AUTH_PW'])
                );
                $this->response($status, 200);
            }
        }
    }

    function pickme_get($result) {
        $id_trans = $this->db->get('transaction')->last_row()->id;
        $type = $this->db->get('transaction')->last_row()->type;
        $status = array(
            'status' => true,
            'message' => $result->result(),
            'trans' => $id_trans,
            'type' => $type,
        );

        $data3 = $this->db->query("select t.*, c.username as name, c.phone, e.price as extra_insurance from transaction t, 
	 	customer c, extra_insurance e where t.id_customer = c.id AND t.id_extra_insurance = e.id AND t.id=" . $id_trans)->result_array();
        $data2 = array();
        foreach ($data3 as $row) {
            $data2 = $row;
        }
        //$this->send_gcm_post($this->input->post('from_latitude'),$this->input->post('from_longitude'),$data2, true,$type);
        $this->send_gcm_post($result, $id_trans, true);
        $this->response($status, 200);
    }

    function rate_post() {
        $id = $this->input->post('id');
        $rate = $this->input->post('rate');
        $is_rated = 1;
        $status = array();
        $this->db->where('id', $id);
        $this->db->from('transaction');
        $id_driver = $this->db->get();
        if ($id_driver->num_rows() > 0) {
            $data = array('is_rated' => 1);
            $this->db->where('id', $id);
            $this->db->update('transaction', $data);
            $this->db->where('id', $id_driver->last_row()->id_driver);
            $this->db->from('driver');
            $rate += $this->db->get()->last_row()->rating;
            $this->db->where('id', $id_driver->last_row()->id_driver);
            $this->db->from('driver');
            $is_rated += $this->db->get()->last_row()->is_rated;
            $data2 = array('rating' => $rate, 'is_rated' => $is_rated);
            $this->db->where('id', $id_driver->last_row()->id_driver);
            $this->db->update('driver', $data2);
            $status = array(
                'status' => true,
                'message' => 'berhasil'
            );
        } else {
            $status = array(
                'status' => false,
                'message' => 'gagal'
            );
        }

        $this->response($status, 200);
    }

    function coba_get() {
       // $driver = $this->finding_driver_get(-7.9270961324576685, 112.6254291459918, "taxi", 1);
        $driver = $this->finding_driver_get(-0.887767, 119.871846, "taxi", 1);
        //$result = $this->db->query($driver);
        $data3 = $this->db->query("select t.*, c.username as name, e.price as extra_insurance from transaction t, 
	 	customer c, extra_insurance e where t.id_customer = c.id AND t.id_extra_insurance = e.id AND t.id=220")->result_array();
        $data2 = array();
        foreach ($data3 as $row) {
            $data2 = $row;
        }

        $this->send_gcm_post($driver, $data2, true);
        //$this->response($data2, 200);
    }

    function try_again_post() {
        $driver = $this->finding_driver_get($this->input->post('from_latitude'), $this->input->post('from_longitude'), $this->input->post('type'), $this->input->post('distance'), 5000);
        if ($driver->num_rows() == 0) {
            $status = array(
                'status' => false,
                'message' => 'Driver Sedang Tidak Aktif,' . $this->input->post('distance')
            );

            $this->response($status, 200);
        } else {
            $id_trans = $this->input->post('id');
            $type = $this->input->post('type');
            $status = array(
                'status' => true,
                'message' => $this->input->post('distance'),
                'trans' => $id_trans,
                'type' => $type
            );
            //$result = $this->db->query($driver);
            $data3 = $this->db->query("select t.*, c.username as name, e.price as extra_insurance from transaction t, 
		 	customer c, extra_insurance e where t.id_customer = c.id AND t.id_extra_insurance = e.id AND t.id=" . $id_trans)->result_array();
            $data2 = array();
            foreach ($data3 as $row) {
                $data2 = $row;
            }

            $this->send_gcm_post($driver, $id_trans, true);
            $this->response($status, 200);
        }
    }

    function finding_driver_get($lat, $lng, $type, $range, $deposit) {
        if ($range == 1) {
            $dist = "distance >=0 AND distance <1500";
        } else if ($range == 2) {
            $dist = "distance >=1500 AND distance <3000";
        } else if ($range == 3) {
            $dist = "distance >=3000 AND distance <4500";
        } else if ($range == 4) {
            $dist = "distance >=4500 AND distance <6000";
        } else if ($range == 5) {
            $dist = "distance >=6000 AND distance <7500";
        }
        $result = "SELECT id, name, username, reg_id, deposit, 
 	( 6371000* acos( cos( radians('" . $lat . "') ) * cos( radians( latitude ) ) * 
 	cos( radians( longitude ) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) *
 	 sin( radians( latitude) ) ) ) AS distance
	FROM driver WHERE status = 1
	AND type = '" . $type . "'
	AND deposit >= '" . $deposit . "'
	HAVING " . $dist . "
	ORDER BY distance ASC";
        //echo $dist;
        //$this->db->query($result);

        return $this->db->query($result);
    }

    function save_image_get($base, $type, $id, $name, $update) {
        if (isset($base)) {

            $image_name = $name . ".jpg";

            // base64 encoded utf-8 string
            $binary = base64_decode($base);

            // binary, utf-8 bytes

            $file = fopen(FCPATH . "/assets/images/" . $image_name, "w+");
            fwrite($file, $binary);
            if ($update) {
                $data = array(
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->where('content_type', $type);
                $this->db->where('content_id', $id);
                $this->db->update('images', $data);
            } else {
                $data = array(
                    'content_type' => $type,
                    'content_id' => $id,
                    'file' => 'assets/images/' . $name . '.jpg',
                    'created_at' => date("Y-m-d H:i:ds"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $this->db->insert('images', $data);
            }


            fclose($file);
        }
    }

    function insurance_get() {
        $extra_insurance = $this->db->get('extra_insurance')->result();
        $this->response($extra_insurance, 200);
    }

    function delete_transaction_get($id_driver) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $this->db->where('email', $_SERVER['PHP_AUTH_USER']);
        $this->db->where('password', sha1($_SERVER['PHP_AUTH_PW']));
        $this->db->from('driver');
        $hasil = $this->db->get();
        if ($hasil->num_rows() == 1) {
            $this->db->where('id_driver', $id_driver);
            $this->db->delete('transaction');
            $data = array(
                'deposit' => 0,
                'rating' => 0
            );
            $this->db->where('id', $id_driver);
            $this->db->update('driver', $data);
            $status = array(
                'status' => true,
                'message' => 'Successed Delete Transaction'
            );
            $this->response($status, 200);
        } else {
            $status = array(
                'status' => false,
                'message' => 'crap thats somethings wrong'
            );
            $this->response($status, 200);
        }
    }
    
    function check_version_post(){
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $getVer = $this->Pelanggan_model->getVersions();
        if($getVer > $dec_data->version){
            $message = array(
                'new_version' => 'yes',
                'message' => 'new version available',
                'data' => []
            );
//            $message = array(
//                'new_version' => 'maintenance',
//                'message' => 'Sedang dilakukan perawatan server',
//                'data' => []
//            );
            
            $this->response($message, 200);
        }else{
            $message = array(
                'new_version' => 'no',
                'message' => 'no new version available',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

}
