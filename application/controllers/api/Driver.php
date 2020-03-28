<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Driver extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('models/Driver_model');
        date_default_timezone_set('Asia/Jakarta');
    }
    
    function index_get($isis){
        $this->response(sha1($isis),200);
//        $this->load->view("api");
    }
    
    function login_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        
        $dataEdit = array(
            'reg_id' => $decoded_data->reg_id
        );
        
        $dataConf = array(
            'status' => 4
        );
        
        $condition = array(
            'password' => sha1($decoded_data->password),
            'no_telepon' => $decoded_data->no_telepon
        );
        
        $check_banned = $this->Driver_model->check_banned($decoded_data->no_telepon);
        if ($check_banned) {
            $message = array(
                'message' => 'banned',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $cek_exist = $this->Driver_model->check_exist($decoded_data->no_telepon, sha1($decoded_data->password));
            $message = array();

            if ($cek_exist){
                $upd_regid = $this->Driver_model->edit_reg_id($dataEdit, $decoded_data->no_telepon);
                $cek_login = $this->Driver_model->get_data_pelanggan($condition);
                $upd_config = $this->Driver_model->edit_config($dataConf, $cek_login[0]->row('id'));
                
                $message = array(
                    'message' => 'found',
                    'data_pelanggan'=>$cek_login[0]->result(),
                    'data_kendaraan'=>$cek_login[1]->result(),
                    'data_config'=>$cek_login[2]->result()
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
    
    function generateSaldo_get(){
//        
//        $data = array();
//        for($i=3; $i<=17; $i++){
//            $dataOne = array(
//                'id_user'=>'P'.$i,
//                'saldo'=>0
//            );
//            array_push($data, $dataOne);
//        }
//        $this->db->insert_batch('saldo', $data);
//        if($this->db->affected_rows() > 0){
//            return true;
//        }else{
//            return false;
//        }
//        $this->response($data, 200);
    }
    
    function update_profile_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $whatUpd = $dec_data->whatUpd;
        
        $adate = 'foto'.substr($dec_data->id, 1);
        $data_updF = array(
            $whatUpd => $adate.".jpg",
            'update_at' => date('Y-m-d H:i:s')
        );
        $url_foto = '/home/nkrilbtb/gorideme.fun/admin/fotodriver/';
        
        if($whatUpd == 'foto'){
            $statImg = $this->save_image($url_foto, $dec_data->value, $adate);
//            $statImg = FALSE;
            if($statImg){
                $upd_profile = $this->Driver_model->edit_profile($data_updF, $dec_data->email);
            }else{
                $upd_profile  = array(true, false);
            }
        }else if($whatUpd == 'password'){
            $data_upd = array(
                $whatUpd => sha1($dec_data->value)
            );
            $upd_profile = $this->Driver_model->setting_profile($data_upd, $dec_data->id_driver);
        }else if($whatUpd == 'email'){
            $data_upd = array(
                $whatUpd => $dec_data->value
            );
            $upd_profile = $this->Driver_model->setting_profile_email($data_upd, $dec_data->id_driver);
        }
        
        if ($upd_profile[0]){
            if($upd_profile[1]){
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
        } else {
            $message = array(
                'message' => 'email exist',
                'data' => 'Email sudah terdaftar'
            );
            $this->response($message, 200);
        }
    }
    
    function update_akun_bank_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $whatUpd = $dec_data->whatUpd;
        $data_updF = array(
            'nama_bank' => $dec_data->nama_bank,
            'atas_nama' => $dec_data->atas_nama,
            'rekening_bank' => $dec_data->rekening_bank,
            'update_at' => date('Y-m-d H:i:s')
        );
        $upd_profile = $this->Driver_model->edit_profile($data_updF, $dec_data->email);
        if($upd_profile[1]){
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
    
    function update_kendaraan_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $data_updF = array(
            'merek' => $dec_data->merek,
            'tipe' => $dec_data->tipe,
            'nomor_kendaraan' => $dec_data->nomor_kendaraan,
            'warna' => $dec_data->warna
        );
        
        $upd_kendaraan = $this->Driver_model->setting_kendaraan($data_updF, $dec_data->id_driver);
      
        if($upd_kendaraan){
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data' => 'Tidak ada perubahan dalam data'
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
   
   function turning_on_bekerja_post(){
       if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $is_turn = $dec_data->is_turn;
        $dataEdit = array();
        if($is_turn){
            $dataEdit = array(
                'status' => 1
            );
            $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id_driver);
            if($upd_regid){
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
            $dataEdit = array(
                'status' => 4
            );
            $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id_driver);
            if($upd_regid){
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
    
    function my_location_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
//        
//        $this->db->where('email',$_SERVER['PHP_AUTH_USER']);
//        $this->db->where('password',sha1($_SERVER['PHP_AUTH_PW']));
//        
//        $this->db->from('driver');
//        $hasil= $this->db->get();
        $data = array(
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
                'id_driver' => $this->input->post('id_driver')
            );
        $ins = $this->Driver_model->set_my_location($data);
        
        if($ins){
            $message = array(
                'message' => 'location updated',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function check_version_post(){
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        
            $getVer = $this->Driver_model->getVersions();
            if($getVer > $dec_data->version){
                    $message = array(
                        'new_version' => 'yes',
                        'message' => 'Aplikasi driver ini sudah tidak didukung dan beralih ke aplikasi yang baru. Dimohon untuk melakukan uninstall aplikasi dan mendownload ulang di playstore dengan kata kunci "goeks Driver".',
                        'data' => []
                    );
                    $this->response($message, 200);
            }else {
                $message = array(
                    'new_version' => 'no',
                    'message' => 'no new version available',
                    'data' => []
                );
                $this->response($message, 200);
            }            
        // }

    }
    
    function verifikasi_topup_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        
        $adate = $dec_data->id.'_'.date("yyyyMMdd_HHmmss");
        $url_foto = '/home/nkrilbtb/gorideme.fun/api/assets/berkas_topup/driver/';

        $save = $this->save_image($url_foto, $dec_data->bukti, $adate);
        if($save){
            $data_topup = array(
                'id_user' => $dec_data->id,
                'no_rekening' => $dec_data->no_rekening,
                'atas_nama' => $dec_data->atas_nama,
                'jumlah' => $dec_data->jumlah,
                'bukti' => $adate.".jpg",
                'bank' =>$dec_data->bank
            );

            $topup = $this->Driver_model->verify_topup($data_topup);
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

    function withdrawal_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_with = array(
            'id_driver' => $dec_data->id_driver,
            'jumlah' => $dec_data->jumlah
        );
        
        $topup = $this->Driver_model->withdrawal($data_with);
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
    }

    function update_uang_belanja_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $dataEdit = array(
            'id_driver'=>$dec_data->id_driver,
            'uang_belanja'=>$dec_data->id_uang
        );
        
        $upd_uang = $this->Driver_model->edit_config($dataEdit, $dec_data->id_driver);
        if($upd_uang){
            $message = array(
                'message' => 'success',
                'data'=>[]
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data'=>[]
            );
            $this->response($message, 200);
        }
    }
    
    function get_feedback_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $condition = array(
            'id_driver' => $dec_data->id
        );
        
        $feed = $this->Driver_model->get_feedback($condition);
        if($feed){
            $message = array(
                'message' => 'success',
                'data' => $feed
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
    
    function get_riwayat_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])){
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $condition = array(
            'transaksi_driver.id_driver' => $dec_data->id
        );
        
        $grt = $this->Driver_model->get_riwayat_transaksi($condition);
        if(sizeof($grt) > 0){
            $message = array(
                'message' => 'success',
                'data' => $grt
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
    
    function logout_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $dataEdit = array(
            'status' => 5
        );
        
        $logout = $this->Driver_model->logout($dataEdit, $decoded_data->id);
        if ($logout) {
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function send_message_to_driver($id_driver, $message){ 
    }
    
    function syncronizing_account_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $getDataDriver = $this->Driver_model->get_data_driver($dec_data->id);
        if($getDataDriver['status_order']->num_rows() > 0){
            $stat = 0;
            if($getDataDriver['status_order']->row('status') == 3){
                $stat = 2;
            }else{
                $stat = 3;
            }
            
            $getTrans = $this->Driver_model->change_status_driver($dec_data->id, $stat);
            
            $message = array(
                'message' => 'success',
                'driver_status'=> $stat,
                'data_driver' => $getDataDriver['data_driver']->result(),
                'data_transaksi' => $getDataDriver['status_order']->result()
            );
            $this->respponse($message, 200);
        }else{
            $message = array(
                'message' => 'success',
                'driver_status'=> $getDataDriver['data_driver']->row('status_config'),
                'data_driver' => $getDataDriver['data_driver']->result(),
                'data_transaksi' => []
            );
            $this->response($message, 200);
        }
    }
   
}