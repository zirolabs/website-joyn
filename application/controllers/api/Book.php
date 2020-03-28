<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Book extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('models/Book_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $msg = array(
            "msg"=>"Ok :)"
        );
        $this->response($msg, 200);
    }
    
    function list_driver_mride_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $near = $this->Book_model->get_near_driver_mride($dec_data->latitude, $dec_data->longitude);
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
        
    }
    
    function list_driver_mcar_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $near = $this->Book_model->get_near_driver_mcar($dec_data->latitude, $dec_data->longitude);
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }
    
    function list_driver_mmassage_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $near = $this->Book_model->get_near_driver_mmassage($dec_data->latitude, $dec_data->longitude);
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
        
    }
    
    function list_driver_mbox_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $near = $this->Book_model->get_near_driver_mbox($dec_data->latitude, $dec_data->longitude, $dec_data->kendaraan_angkut);
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }
    
    function list_driver_mservice_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $near = $this->Book_model->get_near_driver_mservice($dec_data->latitude, $dec_data->longitude, $dec_data->id_service);
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
        
    }
    
    function driver_accept_request_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $acc_req = $this->Book_model->accept_request($data_req);
        if($acc_req['status']){
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            if($acc_req['data'] == 'canceled'){
                $message = array(
                    'message' => 'canceled',
                    'data' => []
                );
                $this->response($message, 200);
            }else{
                $message = array(
                    'message' => 'unknown fail',
                    'data' => []
                );
                $this->response($message, 200);                
            }
        }
    }
    
    function driver_start_request_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $acc_req = $this->Book_model->start_request($data_req);
        if($acc_req['status']){
            $message = array(
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            if($acc_req['data'] == 'canceled'){
                $message = array(
                    'message' => 'canceled',
                    'data' => []
                );
                $this->response($message, 200);
            }else{
                $message = array(
                    'message' => 'unknown fail',
                    'data' => []
                );
                $this->response($message, 200);                
            }
        }
    }
    
    function driver_cancel_request_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $acc_req = $this->Book_model->driver_cancel_request($data_req);
        if($acc_req['status']){
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
    
    function user_cancel_transaction_post() {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_transaksi' => $dec_data->id_transaksi
        );
        
//        $cancel_req = $this->Book_model->user_cancel_request($data_req, $dec_data->id_driver);
        $cancel_req = $this->Book_model->user_cancel_request($data_req);
        if($cancel_req['status']){
            $message = array(   
                'message' => 'order canceled',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'cancel fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function driver_reject_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $driver_reject = $this->Book_model->reject_request($data_req);
        if($driver_reject){
            $message = array(
                'message' => 'reject success',
                'data' => []
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'has been rejected',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function driver_finish_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $data_tr = array(
            'id_driver' => $dec_data->id,
            'id' => $dec_data->id_transaksi
        );
       
        $finish_transaksi = $this->Book_model->finish_request($data_req, $data_tr);
        if($finish_transaksi['status']){
            $message = array(
                'message' => 'finish',
                'data' => $finish_transaksi['data'],
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data' => $finish_transaksi['data']
            );
            $this->response($message, 200);
        }
    }
    
    function driver_finish_transaksi_mmart_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $data_tr = array(
            'id_driver' => $dec_data->id,
            'id' => $dec_data->id_transaksi
        );
        
        $adate = $dec_data->id."_".$dec_data->id_transaksi;
        
        $url_foto = '/home/nkrilbtb/gorideme.fun/api/assets/berkas_struk_mmart/';
        $statImg = $this->save_image($url_foto, $dec_data->foto_struk, $adate);
        
        if($statImg){
            $data_akhir = array(
                'harga_akhir' => $dec_data->harga_akhir,
                'foto_struk' => $adate.".jpg"
            );
            
            $finish_transaksi = $this->Book_model->finish_request_mmart($data_req, $data_tr, $data_akhir);
            if($finish_transaksi['status']){
                $message = array(
                    'message' => 'finish',
                    'data' => $finish_transaksi['data'],
                );
                $this->response($message, 200);
            }else{
                $message = array(
                    'message' => 'finish',
                    'data' => $finish_transaksi['data']
                );
                $this->response($message, 200);
            }
        }else{
            $message = array(
                'message' => 'upload fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function driver_finish_transaksi_mfood_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $data_tr = array(
            'id_driver' => $dec_data->id,
            'id' => $dec_data->id_transaksi
        );
        
        $adate = $dec_data->id."_".$dec_data->id_transaksi;
        
        $url_foto = '/home/nkrilbtb/gorideme.fun/api/assets/berkas_struk_mfood/';
        $statImg = $this->save_image($url_foto, $dec_data->foto_struk, $adate);
        
        if($statImg){
            $data_akhir = array(
                'harga_akhir' => $dec_data->harga_akhir,
                'foto_struk' => $adate.".jpg"
            );
            
            $finish_transaksi = $this->Book_model->finish_request_mfood($data_req, $data_tr, $data_akhir);
            if($finish_transaksi['status']){
                $message = array(
                    'message' => 'finish',
                    'data' => $finish_transaksi['data'],
                );
                $this->response($message, 200);
            }else{
                $message = array(
                    'message' => 'finish',
                    'data' => $finish_transaksi['data']
                );
                $this->response($message, 200);
            }
        }else{
            $message = array(
                'message' => 'upload fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function user_rate_driver_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
       
        $data_rate = array();
        
        if($dec_data->catatan == ""){
            $data_rate = array(
                'id_pelanggan' => $dec_data->id_pelanggan,
                'id_driver' => $dec_data->id_driver,
                'rating' => $dec_data->rating,
                'id_transaksi' => $dec_data->id_transaksi
            );
        }else{
            $data_rate = array(
                'id_pelanggan' => $dec_data->id_pelanggan,
                'id_driver' => $dec_data->id_driver,
                'rating' => $dec_data->rating,
                'id_transaksi' => $dec_data->id_transaksi,
                'catatan' => $dec_data->catatan
            );
        }
        
        $finish_transaksi = $this->Book_model->rate_driver($data_rate);
        
        if($finish_transaksi){
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
    
    function driver_rate_user_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_rate = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'id_driver' => $dec_data->id_driver,
            'rating' => $dec_data->rating,
            'id_transaksi' => $dec_data->id_transaksi,
            'catatan' => $dec_data->catatan
        );
        $finish_transaksi = $this->Book_model->rate_pelanggan($data_rate);
        
        if($finish_transaksi){
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
    
    function get_fitur_mservice_get(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $fitur_mservice = $this->Book_model->get_fitur_mservice();
        $message = array(
            'message' => 'data mservice',
            'data' => $fitur_mservice
        );
        $this->response($message, 200);
    }
    
    function get_mstore_item_store_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_loc = array(
            'latitude'=> $dec_data->latitude,
            'longitude'=>$dec_data->longitude
        );
        
        $mmart = $this->Book_model->get_mstore_item_store($data_loc);
        $message = array(
            'message' => 'data mmart',
            'data' => $mmart
        );
        $this->response($message, 200);
    }
    
    function get_layanan_massage_get(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
                
        $mmassage = $this->Book_model->get_layanan_massage();
        $message = array(
            'message' => 'data massage',
            'data' => $mmassage->result()
        );
        $this->response($message, 200);
    }
    
    function get_data_restoran_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_loc = array(
            'latitude'=> $dec_data->latitude,
            'longitude'=>$dec_data->longitude
        );
        
        $mmart = $this->Book_model->get_data_restoran($data_loc);
        $message = array(
            'message' => 'success',
            'data' => $mmart
        );
        $this->response($message, 200);
    }

    function get_data_mservice_ac_get(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $mserv_ac = $this->Book_model->get_data_service_ac();
        $message = array(
            'message' => 'data mservice ac',
            'data' => $mserv_ac
        );
        $this->response($message, 200);
    }
    
    function search_restoran_or_food_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_search = array(
            'cari' => $dec_data->cari,
            'latitude' => $dec_data->latitude,
            'longitude' => $dec_data->longitude
        );
//        $mmart = $this->Book_model->search_restoran_or_food($data_search);
        $mmart = $this->Book_model->search_food_or_restoran($data_search);
        $message = array(
            'message' => 'data search',
            'data' => $mmart
        );
        $this->response($message, 200);
        
    }
    
    function search_store_or_item_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $data_search = array(
            'cari' => $dec_data->cari,
            'latitude' => $dec_data->latitude,
            'longitude' => $dec_data->longitude
        );
        $mmart = $this->Book_model->search_store_or_item($data_search);
        $message = array(
            'message' => 'data search',
            'data' => $mmart
        );
        $this->response($message, 200);   
    }
    
    function get_food_in_resto_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $mfood = $this->Book_model->get_food_in_resto($dec_data->id_resto);
        $message = array(
            'message' => 'data makanan',
            'data' => $mfood
        );
        $this->response($message, 200);
    }
    
    function get_resto_by_kategori_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $restoKat = $this->Book_model->get_resto_by_kategori($dec_data->id_kategori, $dec_data->latitude, $dec_data->longitude);
        $message = array(
            'message' => 'data restoran',
            'data' => $restoKat->result()
        );
        $this->response($message, 200);
    }
    
    function get_item_in_store_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $mmart = $this->Book_model->get_item_in_store($dec_data->id_toko);
        $message = array(
            'message' => 'data item',
            'data' => $mmart
        );
        $this->response($message, 200);
    }
    
    function request_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, $dec_data->order_fitur, $dec_data->harga);
        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => $dec_data->end_latitude,
            'end_longitude' => $dec_data->end_longitude,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'alamat_tujuan' => $dec_data->alamat_tujuan,
            'biaya_akhir' => $dec_data->harga,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $request = $this->Book_model->insert_transaksi($data_req);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data' => $request['data']
            );
            $this->response($message, 200);
        }
    }
    
    function request_transaksi_msend_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
                
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, $dec_data->order_fitur, $dec_data->harga);
        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => $dec_data->end_latitude,
            'end_longitude' => $dec_data->end_longitude,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga,
            'biaya_akhir' => $dec_data->harga,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'alamat_tujuan' => $dec_data->alamat_tujuan,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        
        $dataDetail = array(
            'nama_pengirim' => $dec_data->nama_pengirim,
            'telepon_pengirim' => $dec_data->telepon_pengirim,
            'nama_penerima' => $dec_data->nama_penerima,
            'telepon_penerima' => $dec_data->telepon_penerima,
            'nama_barang' => $dec_data->nama_barang
        );
        
        $request = $this->Book_model->insert_transaksi_msend($data_req, $dataDetail);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']->result()
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
    
    function request_transaksi_mmassage_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, 
                $dec_data->order_fitur, $dec_data->harga);
        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'jarak' => 0,
            'harga' => $dec_data->harga,
            'alamat_tujuan' => '-',
            'biaya_akhir' => $dec_data->harga,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => 0,
            'end_longitude' => 0,
            'prefer_gender' => $dec_data->prefer_gender,
            'pelanggan_gender' => $dec_data->pelanggan_gender,
            'kota' => $dec_data->kota,
            'tanggal_pelayanan' => $dec_data->tanggal_pelayanan,
            'lama_pelayanan' => $dec_data->lama_pelayanan,
            'massage_menu' => $dec_data->massage_menu,
            'jam_pelayanan' => $dec_data->jam_pelayanan,
            'catatan_tambahan' => $dec_data->catatan_tambahan,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $request = $this->Book_model->insert_transaksi_mmassage($data_req);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']->result(),
                'list_driver' => $request['list_pemijat']
            );
            $this->response($message, 200);
            
        }else{
            $message = array(
                'message' => 'fail',
                'data' => [],
                'list_driver' => []
            );
            $this->response($message, 200);
        }
    }

    function request_transaksi_mservice_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, 
                $dec_data->order_fitur, $dec_data->harga);
        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'jarak' => 0,
            'transaksi.harga' => $dec_data->harga,
            'biaya_akhir' => $dec_data->harga,
            'alamat_tujuan' => '-',
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => 0,
            'end_longitude' => 0,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $data_detail = array(
            'mservice_jenis' => $dec_data->id_jenis,
            'ac_type' => $dec_data->ac_type,
            'tanggal_pelayanan' => $dec_data->tanggal_pelayanan,
            'jam_pelayanan' => $dec_data->jam_pelayanan,
            'quantity' => $dec_data->quantity,
            'residential_type' => $dec_data->residential_type,
            'problem' => $dec_data->problem
        );
        
        $request = $this->Book_model->insert_transaksi_mservice($data_req, $data_detail);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']->result()
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
    
    function request_transaksi_mfood_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, 
                $dec_data->order_fitur, $dec_data->harga);
//        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga + $dec_data->total_biaya_belanja,
            'biaya_akhir' => $dec_data->harga,
            'alamat_tujuan' => $dec_data->alamat_resto,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => $dec_data->toko_latitude,
            'end_longitude' => $dec_data->toko_longitude,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $data_detail = array(
            'id_resto' => $dec_data->id_resto,
            'total_biaya' => $dec_data->total_biaya_belanja,
            'harga_akhir' => $dec_data->total_biaya_belanja
        );
        
        $request = $this->Book_model->insert_transaksi_mfood($data_req, $data_detail, $dec_data->pesanan);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']
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
    
    function request_transaksi_mstore_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, 
                $dec_data->order_fitur, $dec_data->harga);
//        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga,
            'biaya_akhir' => $dec_data->harga,
            'alamat_tujuan' => $dec_data->alamat_toko,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => $dec_data->toko_latitude,
            'end_longitude' => $dec_data->toko_longitude,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $data_detail = array(
            'id_toko' => $dec_data->id_toko,
            'total_biaya' => $dec_data->total_biaya_belanja
        );
        
        $request = $this->Book_model->insert_transaksi_mstore($data_req, $data_detail, $dec_data->pesanan);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']
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
        
    function request_transaksi_mbox_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
                
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, $dec_data->order_fitur, $dec_data->harga);
        
        $castinglat = 0;
        $castinglng = 0;
        if($dec_data->end_latitude == '-'){
            $castinglat = 0;
            $castinglng = 0;
        }else{
            $castinglat = $dec_data->end_latitude;
            $castinglng = $dec_data->end_longitude;
        }
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => $castinglat,
            'end_longitude' => $castinglng,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga,
            'biaya_akhir' => $dec_data->harga,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'alamat_tujuan' => $dec_data->alamat_tujuan,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $d = new DateTime($dec_data->tanggal_pelayanan." ".$dec_data->jam_pelayanan);
        
        $dataDetail = array(
            'nama_barang'=>$dec_data->nama_barang,
            'kendaraan_angkut'=>$dec_data->kendaraan_angkut,
            'tanggal_pelayanan'=>$dec_data->tanggal_pelayanan,
            'jam_pelayanan'=>$dec_data->jam_pelayanan,
            'nama_pengirim' => $dec_data->nama_pengirim,
            'telepon_pengirim' => $dec_data->telepon_pengirim,
            'waktu_pelayanan'=> $d->getTimestamp()*1000,
            'asuransi'=> $dec_data->asuransi,
            'shipper'=> $dec_data->shipper
        );
        
        $request = $this->Book_model->insert_transaksi_mbox($data_req, $dataDetail, $dec_data->destinasi);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data'],
                'list_destinasi' => $request['list_destinasi']
            );
            $this->response($message, 200);   
        }else{
            $message = array(
                'message' => 'fail',
                'data' => $request['data'],
                'list_destinasi' => $request['list_destinasi']
            );
            $this->response($message, 200);
        }
    }
    
    function request_transaksi_mmart_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }else{
            $cek = $this->Book_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if($cek){
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);  
            }
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $check_promo = $this->Book_model->check_biaya_kode_promo($dec_data->id_pelanggan, 
                $dec_data->order_fitur, $dec_data->harga);
//        
        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_toko,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga,
            'biaya_akhir' => $dec_data->harga + $dec_data->estimasi_biaya,
            'alamat_tujuan' => $dec_data->alamat_asal,
            'end_latitude' => $dec_data->start_latitude,
            'end_longitude' => $dec_data->start_longitude,
            'start_latitude' => $dec_data->toko_latitude,
            'start_longitude' => $dec_data->toko_longitude,
            'kode_promo' => $check_promo['kode_promo'],
            'kredit_promo' => $check_promo['kredit_promo'],
            'pakai_mpay' => $dec_data->pakai_mpay
        );
        
        $data_detail = array(
            'nama_toko' => $dec_data->nama_toko,
            'estimasi_biaya' => $dec_data->estimasi_biaya,
            'harga_akhir' => $dec_data->estimasi_biaya
        );
        
        $request = $this->Book_model->insert_transaksi_mmart($data_req, $data_detail, $dec_data->pesanan);
        if($request['status']){
            $message = array(
                'message' => 'success',
                'data' => $request['data']
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
    
    function get_data_transaksi_mmart_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_transaksi_mmart($dec_data->id_transaksi);
        
        if($getData['status']){
            $message = array(
                'message' => 'success',
                'data_transaksi' => $getData['data_transaksi'],
                'list_barang' => $getData['list_barang'],
                'list_driver' => $getData['list_driver']
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
    
    function get_data_transaksi_mfood_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_history_mfood($dec_data->id_transaksi);
        
        if($getData['message'] == 'success'){
//            $message = array(
//                'message' => 'success',
//                'data_transaksi' => $getData['data_transaksi'],
//                'list_barang' => $getData['list_barang'],
//                'list_driver' => $getData['list_driver']
//            );
            $this->response($getData, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200);
        }
    }
    
    function get_data_transaksi_mbox_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_order_mbox($dec_data->id_transaksi);
        
        if($getData['status']){
            $message = array(
                'message' => 'success',
                'data_transaksi' => $getData['data_transaksi'],
                'list_destinasi' => $getData['list_destinasi'],
                'list_driver' => $getData['list_driver']
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
    
    function get_data_transaksi_msend_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_order_msend($dec_data->id_transaksi);
        
        
        if($getData['status']){
            $message = array(
                'message' => 'success',
                'data_transaksi' => $getData['data_transaksi'],
                'list_driver' => $getData['list_driver']
            );
            $this->response($message, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data_transaksi' => [],
                'list_driver' => []
            );
            $this->response($message, 200);
        }
        
    }
    
    function get_data_transaksi_mservice_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_order_mservice($dec_data->id_transaksi);
        
        if($getData['message'] == 'success'){
            $this->response($getData, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data_transaksi' => [],
                'list_driver' => [],
            );
            $this->response($message, 200);
        }        
    }
    
    function get_data_transaksi_mmassage_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_transaksi_mmassage($dec_data->id_transaksi);
        $message = array(
            'message' => 'success',
            'data_transaksi' => $getData->result()
        );
        $this->response($message, 200);        
    }
    
    function get_data_order_mmassage_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $getData = $this->Book_model->get_data_history_mmassage($dec_data->id_transaksi);
        
        if($getData['message'] == 'success'){
            $this->response($getData, 200);
        }else{
            $message = array(
                'message' => 'fail',
                'data_transaksi' => []
            );
            $this->response($message, 200);
        }        
    }

    function get_kendaraan_angkut_get(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $get_angkutan = $this->Book_model->get_kendaraan_angkut();
        $message = array(
            'message' => 'kendaraan angkut',
            'data' => $get_angkutan->result()
        );
        $this->response($message, 200);
        
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
    
    function cancel_transaction_get($idDriver, $idUser, $idTrans){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://gorideme.fun/api/book/send_cancel_signal/".$idDriver."/".$idUser."/".$idTrans);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $stat = curl_exec($ch);
        curl_close($ch);
//        $this->response($stat, 200);
    }
    
    function send_cancel_signal_get($idD, $idUser, $idTrans){
        $reg_idD = $this->Book_model->get_reg_id_driver($idD);
        $reg_idP = $this->Book_model->get_reg_id_pelanggan($idUser);
        $dataCancel = array("response" => "2", "type" => "1", "id_transaksi" => $idTrans, "id_driver" => $idD);
        $this->load->library('fcm');
        $this->fcm->addRecepient($reg_idD);
        $this->fcm->addRecepient($reg_idP);
        $this->fcm->setData($dataCancel);
//        $this->fcm->setNotification($notif);
        $this->fcm->setTtl(500);
        $this->fcm->setGroup(false);
        $status = $this->fcm->send();
    }

    function coba_send_fcm_get($id) {
        $reg_id = $this->Book_model->get_reg_id_driver($id);
        $message = array("title" => "Mangoesky", "body" => "Sisa Kuota anda 30 GB");
        $notif = array("title" => "Tes Notif", "text" => "Notifikasi", "sound" => "Notifications");
        $this->load->library('fcm');
        $this->fcm->setMessage('Test ' . date('d.m.Y H:s:i'));
        $this->fcm->addRecepient($reg_id);
//        $this->fcm->setData($message);
        $this->fcm->setNotification($notif);
        $this->fcm->setTtl(500);
        $this->fcm->setGroup(false);
        $status = $this->fcm->send();
//        $message = array(
//            'message' => 'FCM '.$status,
//            'data' => $reg_id
//        );
//        $this->response($message, 200);
        return $status;
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

    function save_image($url_foto, $base, $name){
        if (isset($base)) {
            $image_name = $name.".jpg";
            // base64 encoded utf-8 string
            $binary = base64_decode($base);
            // binary, utf-8 bytes
            $success = file_put_contents($url_foto.$image_name, $binary);
            return $success;
        }else{
            return FALSE;
        }
   }
   
    function get_additional_mbox_get(){ 
        $add = $this->Book_model->get_additional_config('7');
        $message = array(
            'message' => 'success',
            'data' => $add
        );
        $this->response($message, 200);
    }
    
    function check_status_transaksi_post(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $dataTrans = array(
            'id_transaksi' => $dec_data->id_transaksi
        );
        
        $getStatus = $this->Book_model->check_status($dataTrans);
//        if($getStatus['status']){
            $this->response($getStatus, 200);
//        }
//        $message = array(
//            'status' => true,
//            'data' => $getStatus
//        );
//        $this->response($message, 200);
    }
    
    function liat_lokasi_driver_get($id_driver){
        
        $getLoc = $this->Book_model->get_driver_location($id_driver);
        $message = array(
            'status' => true,
            'data' => $getLoc->result()
        );
        $this->response($message, 200);
    }
      
}
