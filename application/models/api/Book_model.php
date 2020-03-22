<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }
    
    function check_banned_user($email){
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where('email', $email);
        $this->db->where("(status = '2' OR status = '3')", NULL, FALSE);
//        $this->db->where('status', '3');
        $cek = $this->db->get();
        if($cek->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function get_near_driver_mride($lat, $lng){
        $range = 3;
        $url_foto = base_url().'../admin/fotodriver/';
        
        $result = $this->db->query("
            SELECT d.id as id, d.nama_depan, d.nama_belakang, ld.latitude, ld.longitude, ld.update_at,
            k.merek, k.nomor_kendaraan, k.warna, k.tipe, s.saldo, ub.nominal as budget_belanja,
            d.no_telepon, CONCAT('$url_foto', d.foto, '') as foto, d.reg_id, dj.driver_job,
                (6371 * acos(cos(radians($lat)) * cos(radians( ld.latitude ))"
                . " * cos(radians(ld.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(ld.latitude)))) AS distance
            FROM config_driver ld, driver d, driver_job dj, kendaraan k,
                saldo s, config_driver cd, uang_belanja ub
            WHERE ld.id_driver = d.id 
                AND ld.status = '1'
                AND dj.id = d.job
                AND d.job = '1'
                AND d.status = '1'
                AND k.id = d.kendaraan
                AND s.id_user = d.id
                AND s.saldo > 50
                AND cd.id_driver = d.id
                AND ub.id = cd.uang_belanja
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $result;
    }
    
    public function get_near_driver_mcar($lat, $lng){
        $range = 3;
        $url_foto = base_url().'../admin/fotodriver/';
        
        $result = $this->db->query("
            SELECT d.id as id, d.nama_depan, d.nama_belakang, ld.latitude, ld.longitude, ld.update_at,
            k.merek, k.nomor_kendaraan, k.warna, k.tipe, s.saldo,
            d.no_telepon, CONCAT('$url_foto', d.foto, '') as foto, d.reg_id, dj.driver_job,
                (6371 * acos(cos(radians($lat)) * cos(radians( ld.latitude ))"
                . " * cos(radians(ld.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(ld.latitude)))) AS distance
            FROM config_driver ld, driver d, driver_job dj, kendaraan k, saldo s
            WHERE ld.id_driver = d.id 
                AND ld.status = '1'
                AND dj.id = d.job
                AND d.job = '2'
                AND d.status = '1'
                AND k.id = d.kendaraan
                AND s.id_user = d.id
                AND s.saldo > 50000
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $result;
    }
    
    public function get_near_driver_mmassage($lat, $lng){
        $range = 10;
        $this->db->select(''
                . 'driver.id,'
                . 'driver.nama_depan,'
                . 'driver.nama_belakang,'
                . 'driver.no_telepon,'
                . 'driver.foto,'
                . 'driver.rating,'
                . 'driver.reg_id,'
                . 'gender_pemijat.pemijat,'
                . 'cd.latitude,'
                . 'cd.longitude,'
                . "(6371 * acos(cos(radians($lat)) * cos(radians( cd.latitude ))"
                . " * cos(radians(cd.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(cd.latitude)))) AS distance");
        
        $this->db->from('driver');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->join('gender_pemijat', 'driver.gender = gender_pemijat.id');
        $this->db->join('config_driver cd', 'driver.id = cd.id_driver');
//        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id');
        $this->db->where('job', '3');
//        $this->db->where('driver.kendaraan', '1');
//        $this->db->where('gender' , $gender);
        $this->db->where('saldo >', 50000);
        $this->db->where('cd.status', 1);
        $this->db->where('driver.status', 1);
       
        $this->db->order_by('distance', 'ASC');
        $this->db->having('distance <=', $range, false);
        return $this->db->get();
    }
    
    public function get_near_driver_mbox($lat, $lng, $idk){
        $range = 10;
        $url_foto = base_url().'../admin/fotodriver/';
        
        $result = $this->db->query("
            SELECT d.id as id, d.nama_depan, d.nama_belakang, ld.latitude, ld.longitude, ld.update_at,
            k.merek, k.nomor_kendaraan, k.warna, k.tipe, k.jenis as id_kendaraan_angkut,
            d.no_telepon, CONCAT('$url_foto', d.foto, '') as foto, d.reg_id, dj.driver_job,
                (6371 * acos(cos(radians($lat)) * cos(radians( ld.latitude ))"
                . " * cos(radians(ld.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(ld.latitude)))) AS distance
            FROM config_driver ld, driver d, driver_job dj, kendaraan k
            WHERE ld.id_driver = d.id 
                AND ld.status = '1'
                AND d.status = '1'
                AND dj.id = d.job
                AND d.job = '4'
                AND k.id = d.kendaraan
                AND k.jenis = $idk
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $result;
    }
    
    public function get_near_driver_mservice($lat, $lng, $idService){
        $range = 10;
        $url_foto = base_url().'../admin/fotodriver/';
        $result = $this->db->query("
            SELECT d.id as id, d.nama_depan, d.nama_belakang, ld.latitude, ld.longitude, ld.update_at,
            d.no_telepon, CONCAT('$url_foto', d.foto, '') as foto, d.reg_id, dj.driver_job,
                (6371 * acos(cos(radians($lat)) * cos(radians( ld.latitude ))"
                . " * cos(radians(ld.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(ld.latitude)))) AS distance
            FROM config_driver ld, driver d, driver_job dj,
            teknisi_in_jenis_service tij, saldo s
            WHERE ld.id_driver = d.id 
                AND ld.status = '1'
                AND dj.id = d.job
                AND d.status = '1'
                AND d.job = '5'
                AND s.id_user = d.id
                AND s.saldo > 50000
                AND tij.id_teknisi = d.id
                AND tij.id_service = $idService
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $result;
    }
    
    public function insert_transaksi($data_req){
        
        if($data_req['order_fitur'] == 1){
            $diskon = $this->diskon_mpay(1);
            $ha = 0;
            if($data_req['pakai_mpay'] == 1){
                $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
                if($ha <= 0){
                    $ha = 0;
                }
                $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
            }
            $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        }else{
            $diskon = $this->diskon_mpay(2);
            $ha = 0;
            if($data_req['pakai_mpay'] == 1){
                $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
                if($ha <= 0){
                    $ha = 0;
                }
                $data_req['kredit_promo'] = ($ha * 1/(1-$diskon)) - $ha;
            }
            $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        }
        
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            return array(
                'status'=> true,
                'data' => $get_data->result()
            );
        }else{
            return array(
                'status'=> false,
                'data' => []
            );
        }
    }
    
    public function insert_transaksi_msend($data_req, $dataDetail){
        $diskon = $this->diskon_mpay(5);
        $ha = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
        }
        $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            
            $this->db->insert('history_transaksi', $data_hist);
            $dataDetail['id_transaksi'] = $get_data->row('id');
            
            $this->db->insert('transaksi_detail_msend', $dataDetail);
            $get_data_msend = $this->get_data_transaksi_msend($data_req);
            return array(
                    'status'=> true,
                    'data' => $get_data_msend
                );
            
        }else{
            return array(
                    'status'=> false,
                    'data' => []
                );
        }
    }
    
    public function insert_transaksi_mbox($data_req, $data_box, $destinasi){
        $diskon = $this->diskon_mpay(1);
        $ha = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
        }
        $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            $data_box['id_transaksi'] = $get_data->row('id');
            
            $this->db->insert('transaksi_detail_mbox', $data_box);
            if($this->db->affected_rows() != 1){
                return array(
                        'status'=> false,
                        'data' => "error inserting detail",
                        'list_destinasi' => []
                    );
            }else{
                $arr_destinasi = array();
                foreach ($destinasi as $row){
                    $arr_des = array(
                        'id_transaksi' => $get_data->row('id'),
                        'lokasi' => $row->lokasi,
                        'latitude' => $row->latitude,
                        'longitude' => $row->longitude,
                        'detail_lokasi' => $row->detail_lokasi,
                        'nama_penerima' => $row->nama_penerima,
                        'telepon_penerima' => $row->telepon_penerima,
                        'instruksi' => $row->instruksi,
                    );
                    array_push($arr_destinasi, $arr_des);
                }

                $ins_destinasi = $this->insert_destinasi_mbox($arr_destinasi);
                if($ins_destinasi){
                    $this->db->select('*');
                    $this->db->from('transaksi_detail_mbox_destinasi');
                    $this->db->where('id_transaksi', $get_data->row('id'));
                    $getDestinasi = $this->db->get();
                    return array(
                        'status'=> true,
                        'data'=> $get_data->result(),
                        'list_destinasi' => $getDestinasi->result()
                    );
                }else{
                    return array(
                        'status'=> false,
                        'data'=> 'error inserting destinasi',
                        'list_destinasi' => []
                    );
                }
            }
        }else{
            return array(
                    'status'=> false,
                    'data' => 'error inserting transaksi'
                );
        }
    }    
    
    public function insert_transaksi_mservice($data_req, $data_service){
        $diskon = $this->diskon_mpay(8);
        $ha = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
        }
        $data_req['biaya_akhir'] = $data_req['transaksi.harga'] + $data_req['kredit_promo'];
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            $data_service['id_transaksi'] = $get_data->row('id');
            $this->db->insert('transaksi_detail_mservice_ac', $data_service);
            
            $get_data_mservice = $this->get_data_transaksi_mservice($data_req);
            return array(
                    'status'=> true,
                    'data' => $get_data_mservice
                );
        }else{
            return array(
                    'status'=> false,
                    'data' => []
                );
        }
    }

    public function insert_transaksi_mfood($data_req, $data_detail, $data_pesanan){
        $diskon = $this->diskon_mpay(3);
        $ha = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
        }
        $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            $data_detail['id_transaksi'] = $get_data->row('id');
            $this->db->insert('transaksi_detail_mfood', $data_detail);
            
            $arr_pesanan = array();
            foreach ($data_pesanan as $row){
                $data_pesanan = array(
                    'id_makanan' => $row->id_makanan,
                    'jumlah' => $row->qty,
                    'total_harga' => $row->total_harga,
                    'id_transaksi' => $get_data->row('id'),
                    'catatan' => $row->catatan
                );
                array_push($arr_pesanan, $data_pesanan);
            }
            
            $ins_makanan = $this->insert_barang_belanja_mfood($arr_pesanan);
            if($ins_makanan){
                return array(
                    'status'=> true,
                    'data' => $get_data->result()
                );
            }else{
                return array(
                    'status'=> true,
                    'data' => []
                );
            }
            
        }else{
            return array(
                    'status'=> false,
                    'data' => []
                );
        }
    }

    public function insert_transaksi_mstore($data_req, $data_detail, $data_pesanan){
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            $data_detail['id_transaksi'] = $get_data->row('id');
            $this->db->insert('transaksi_detail_mstore', $data_detail);
//            $get_data_mmart = $this->get_data_transaksi_mmart($get_data->row('id'));
            
            $arr_pesanan = array();
            foreach ($data_pesanan as $row){
                $data_pesanan = array(
                    'id_barang' => $row->id_barang,
                    'jumlah' => $row->qty,
                    'total_harga' => $row->total_harga,
                    'id_transaksi' => $get_data->row('id'),
                    'catatan' => $row->catatan
                );
                array_push($arr_pesanan, $data_pesanan);
            }
            
            $ins_barang = $this->insert_barang_belanja_mstore($arr_pesanan);
            if($ins_barang){
                return array(
                    'status'=> true,
                    'data' => array(
                        'id_transaksi' => $get_data->row('id'),
                        'kode_promo' => $data_req['kode_promo'],
                        'kredit_promo' => $data_req['kredit_promo'],
                        'pakai_mpay' => $data_req['pakai_mpay']
                    )
                );
            }else{
                return array(
                    'status'=> true,
                    'data' => []
                );
            }
            
        }else{
            return array(
                    'status'=> false,
                    'data' => []
                );
        }
    }
    
    public function insert_transaksi_mmart($data_req, $data_detail, $data_pesanan){
        $diskon = $this->diskon_mpay(4);
        $ha = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
        }
        $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            $data_detail['id_transaksi'] = $get_data->row('id');
            $this->db->insert('transaksi_detail_mmart', $data_detail);
//            $get_data_mmart = $this->get_data_transaksi_mmart($get_data->row('id'));
            
            $arr_pesanan = array();
            foreach ($data_pesanan as $row){
                $data_pesanan = array(
                    'nama_barang' => $row->nama_barang,
                    'jumlah' => $row->qty,
                    'id_transaksi' => $get_data->row('id')
                );
                array_push($arr_pesanan, $data_pesanan);
            }
            
            $ins_barang = $this->insert_barang_belanja_mmart($arr_pesanan);
            if($ins_barang){
                return array(
                    'status'=> true,
                    'data'=> $get_data->result()
                );
//                'data' => array(
//                        'id_transaksi' => $get_data->row('id'),
//                        'kode_promo' => $data_req['kode_promo'],
//                        'kredit_promo' => $data_req['kredit_promo'],
//                        'pakai_mpay' => $data_req['pakai_mpay']
//                    )
            }else{
                return array(
                    'status'=> false,
                    'data' => "Gagal input barang"
                );
            }
            
        }else{
            return array(
                    'status'=> false,
                    'data' => "Gagal input transaksi"
                );
        }
    }
    
    public function insert_transaksi_mmassage($data){     
        
        $data_req = array(
            'id_pelanggan' => $data['id_pelanggan'],
            'order_fitur' => $data['order_fitur'],
            'waktu_order' => $data['waktu_order'],
            'alamat_asal' => $data['alamat_asal'],
            'jarak' => 0,
            'harga' => $data['harga'],
            'alamat_tujuan' => '-',
            'start_latitude' => $data['start_latitude'],
            'start_longitude' => $data['start_longitude'],
            'end_latitude' => $data['end_latitude'],
            'end_longitude' => $data['end_longitude'],
            'pakai_mpay' => $data['pakai_mpay'],
            'kode_promo' => $data['kode_promo'],
            'kredit_promo' => $data['kredit_promo']
        );
        $diskon = $this->diskon_mpay(6);
        $ha = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['biaya_akhir'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $data_req['kredit_promo'] = ($ha * 1/(1-$diskon))  - $ha;
        }
        $data_req['biaya_akhir'] = $data_req['harga'] + $data_req['kredit_promo'];
        
        $ins_trans = $this->db->insert('transaksi', $data_req);
        if($this->db->affected_rows() == 1){
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi'=>$get_data->row('id'),
                'id_driver'=>'D0',
                'status'=>'1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            
            $data_detail = array(
                'id_transaksi' => $get_data->row('id'),
                'prefer_gender' => $data['prefer_gender'],
                'kota' => $data['kota'],
                'tanggal_pelayanan' => $data['tanggal_pelayanan'],
                'lama_pelayanan' => $data['lama_pelayanan'],
                'massage_menu' => $data['massage_menu'],
                'jam_pelayanan' => $data['jam_pelayanan'],
                'pelanggan_gender' => $data['pelanggan_gender'],
                'catatan_tambahan' => $data['catatan_tambahan'],
            );
            $this->db->insert('transaksi_detail_mmassage', $data_detail);
            
            $get_data_all = $this->get_data_transaksi_mmassage($get_data->row('id'));
            $get_list_pemijat = $this->get_available_pemijat($data['massage_menu'],
                    $data['prefer_gender'], "waktuPelayanan", "lamaPelayanan",
                    $data['start_latitude'], $data['start_longitude']);
            return array(
                    'status'=> true,
                    'data' => $get_data_all,
                    'list_pemijat' => $get_list_pemijat->result()
                );
        }else{
            return array(
                    'status'=> false,
                    'data' => []
                );
        }
    }
    
    public function insert_barang_belanja_mstore($data){
        $this->db->insert_batch('belanja_mstore', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function insert_barang_belanja_mmart($data){
        $this->db->insert_batch('belanja_mmart', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function insert_destinasi_mbox($data){
        $this->db->insert_batch('transaksi_detail_mbox_destinasi', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    public function insert_barang_belanja_mfood($data){
        $this->db->insert_batch('belanja_mfood', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function accept_request($cond){
        
        $this->db->where('id_driver', 'D0');
        $this->db->where('id_transaksi', $cond['id_transaksi']);
        $this->db->where("(status = '1' OR status = '2')", NULL, FALSE);
        $this->db->from('history_transaksi');
        $cek_once = $this->db->get();
        if($cek_once->num_rows() > 0){
            $data = array(
                'status' => '3',
                'id_driver' => $cond['id_driver']
            );
            $this->db->where('id_driver', 'D0');
            $this->db->where('id_transaksi', $cond['id_transaksi']);
            $edit = $this->db->update('history_transaksi', $data);
            
            if($this->db->affected_rows() > 0){
                $this->db->where('id', $cond['id_transaksi']);
                $update_trans = $this->db->update('transaksi', array('id_driver'=>$cond['id_driver']));
                
                $datD = array(
                    'status'=>'2'
                );
                $this->db->where(array('id_driver'=>$cond['id_driver']));
                $updDriver = $this->db->update('config_driver', $datD);
                return array(
                    'status'=> true,
                    'data' => []
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
                    'data' => 'canceled'
                );      
        }
    }
    
    public function start_request($cond){
        
        $this->db->where($cond);
        $this->db->where('status', '3');
        $this->db->from('history_transaksi');
        $cek_once = $this->db->get();
        if($cek_once->num_rows() > 0){
            $data = array(
                'status' => '6',
                'id_driver' => $cond['id_driver']
            );
            $this->db->where($cond);
            $edit = $this->db->update('history_transaksi', $data);
            if($this->db->affected_rows() > 0){
                $datD = array(
                    'status'=>'3'
                );
                $this->db->where(array('id_driver'=>$cond['id_driver']));
                $updDriver = $this->db->update('config_driver', $datD);
                return array(
                    'status'=> true,
                    'data' => []
                );
            }else{
                return array(
                    'status'=> false,
                    'data' => []
                );        
            }
        }else{
            $datD = array(
                'status'=>'1'
            );
            $this->db->where(array('id_driver'=>$cond['id_driver']));
            
            $updDriver = $this->db->update('config_driver', $datD);
            return array(
                'status'=> false,
                'data' => 'canceled'
            );      
        }
    }
      
    public function driver_cancel_request($cond){
        $data = array(
            'status' => '5'
        );
        $this->db->where($cond);
        $edit = $this->db->update('history_transaksi', $data);
        $datD = array(
            'status'=>'1'
        );
        $this->db->where('id_driver', $cond['id_driver']);
        
        $updDriver = $this->db->update('config_driver', $datD);
        if($this->db->affected_rows() > 0){
            return array(
                'status'=> true,
                'data' => []
            );
        }else{
            return array(
                'status'=> false,
                'data' => []
            );        
        }
    }
    
    public function user_cancel_request($cond, $idDriver){
        
        $this->db->select(''
                . 'id_driver, '
                . 'status');
        $this->db->from('history_transaksi');
        $this->db->where('id_transaksi', $cond['id_transaksi']);
        $id = $this->db->get();
        
        if($id->row('status') == 1 || $id->row('status') == 3 || $id->row('status') == 5){
            $data = array(
                'status' => '5'
            );
            $this->db->where($cond);
            $edit = $this->db->update('history_transaksi', $data);

//            if($this->db->affected_rows() > 0){
                $data = array(
                    'status' => '1'
                );
                $this->db->where('id_driver', $id->row('id_driver'));
                $edit = $this->db->update('config_driver', $data);

                return array(
                    'status'=> true,
                    'data' => []
                );
//            }else{
//                return array(
//                    'status'=> true,
//                    'data' => []
//                );        
//            }
        }else{
            return array(
                'status'=> false,
                'data' => []
            );
        }
        
    }
    
    public function reject_request($cond){
//        $dataIns = array(
//            'id_transaksi'=> $cond['id_transaksi'],
//            'status' => '4',
//            'id_driver' => $cond['id_driver']
//        );
//        $ins = $this->db->insert('history_transaksi', $dataIns);
//        if($this->db->affected_rows() > 0){
            return true;
//        }else{
//            return false;        
//        }
    }
    
    public function get_status_request($id_transaksi){
        $this->db->select('status');
        $this->db->from('transaksi');
        $this->db->where('id_transaksi', $id_transaksi);
        $this->db->get();
    }
    
    function get_available_pemijat($keahlian, $gender, $waktuPelayanan, $lamaPelayanan, $lat, $lng){
        $range = 10;
        $this->db->select(''
                . 'driver.id,'
                . 'driver.nama_depan,'
                . 'driver.nama_belakang,'
                . 'driver.no_telepon,'
                . 'driver.foto,'
                . 'driver.rating,'
                . 'driver.reg_id,'
                . 'gender_pemijat.pemijat,'
                . 'cd.latitude,'
                . 'cd.longitude,'
                . "(6371 * acos(cos(radians($lat)) * cos(radians( cd.latitude ))"
                . " * cos(radians(cd.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(cd.latitude)))) AS distance");
        
        $this->db->from('driver');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->join('pemijat_in_keahlian', 'driver.id = pemijat_in_keahlian.id_pemijat');
        $this->db->join('gender_pemijat', 'driver.gender = gender_pemijat.id');
        $this->db->join('config_driver cd', 'driver.id = cd.id_driver');
//        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id');
        $this->db->where('job', '3');
//        $this->db->where('driver.kendaraan', '1');
        $this->db->where('saldo >', 50000);
        $this->db->where('driver.status', '1');
        $this->db->where('cd.status', '1');
        $this->db->where('pemijat_in_keahlian.id_layanan_pijat', $keahlian);
        if($gender == 1 || $gender == 2){
//            $this->db->order_by('gender','ASC');
            $this->db->where('gender' , $gender);
        }
        $this->db->order_by('distance', 'ASC');
        $this->db->having('distance <=', $range, false);
        return $this->db->get();
    }
    
    function get_data_transaksi_mmart($id_transaksi){
        $this->db->select('*, status_transaksi.id as status, status_transaksi.status_transaksi,');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mmart', 'transaksi.id = transaksi_detail_mmart.id_transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where('transaksi.id', $id_transaksi);
        $getData = $this->db->get();
        if($this->db->affected_rows() == 1){
            
            $this->db->select('*');
            $this->db->from('belanja_mmart');
            $this->db->where('id_transaksi', $id_transaksi);
            $getBarang = $this->db->get();
            
            if($this->db->affected_rows() > 0 ){
                return array(
                    'status' => TRUE,
                    'data_transaksi' => $getData->result(),
                    'list_barang' => $getBarang->result(),
                    'list_driver' => $this->get_data_driver_histroy($id_transaksi)->result()
                );
            }else{
                return array(
                    'status' => FALSE,
                    'data' => $getData->result(),
                    'list_barang' => [],
                    'list_driver' => []
                );
            }
           
        }else{
            return array(
                'status' => FALSE,
                'data' => []
            );            
        }
    }
    
    function get_data_transaksi_mfood($id_transaksi){
        $this->db->select(''
                . 'transaksi.*,'
                . 'transaksi_detail_mfood.id_transaksi,'
                . 'transaksi_detail_mfood.total_biaya,'
                . 'transaksi_detail_mfood.harga_akhir,'
                . 'transaksi_detail_mfood.foto_struk,'
                . 'restoran.nama_resto,'
                . 'status_transaksi.status_transaksi,'
                . 'restoran.kontak_telepon');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mfood', 'transaksi.id = transaksi_detail_mfood.id_transaksi');
        $this->db->join('restoran', 'transaksi_detail_mfood.id_resto = restoran.id');
        $this->db->join('history_transaksi', 'transaksi_detail_mfood.id_transaksi = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where('transaksi.id', $id_transaksi);
        $getData = $this->db->get();
        if($this->db->affected_rows() > 0){
            $this->db->select(''
                    . 'belanja_mfood.jumlah,'
                    . 'belanja_mfood.total_harga,'
                    . 'belanja_mfood.catatan,'
                    . 'makanan.id as id_makanan,'
                    . 'makanan.nama_menu,'
                    . 'makanan.harga');
            $this->db->from('belanja_mfood');
            $this->db->join('makanan', 'belanja_mfood.id_makanan = makanan.id');
            $this->db->where('id_transaksi', $id_transaksi);
            $getBarang = $this->db->get();
            if($this->db->affected_rows() > 0 ){
                return array(
                    'status' => TRUE,
                    'data_transaksi' => $getData->result(),
                    'list_barang' => $getBarang->result()
                );
            }else{
                return array(
                    'status' => FALSE,
                    'data_transaksi' => $getData->result(),
                    'list_barang' => $getBarang->result()
                );
            }
           
        }else{
            return array(
                'status' => FALSE,
                'data_transaksi' => [],
                'list_barang' => []
            );            
        }
    }
    
    function get_data_order_mbox($id_transaksi){
        $this->db->select('*,'
                . 'status_transaksi.id as status,'
                . 'status_transaksi.status_transaksi');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mbox', 'transaksi.id = transaksi_detail_mbox.id_transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where('transaksi.id', $id_transaksi);
        $getData = $this->db->get();
        if($this->db->affected_rows() == 1){
            $this->db->select('*');
            $this->db->from('transaksi_detail_mbox_destinasi');
            $this->db->where('id_transaksi', $id_transaksi);
            $getDestinasi = $this->db->get();
            if($this->db->affected_rows() > 0 ){
                return array(
                    'status' => TRUE,
                    'data_transaksi' => $getData->result(),
                    'list_destinasi' => $getDestinasi->result(),
                    'list_driver' => $this->get_data_driver_histroy($id_transaksi)->result()
                );
            }else{
                return array(
                    'status' => FALSE,
                    'data_transaksi' => $getData->result(),
                    'list_destinasi' => [],
                    'list_driver' => []
                    
                    
                );
            }
           
        }else{
            return array(
                'status' => FALSE,
                'data' => []
            );            
        }
    }
    
    function get_kendaraan_angkut(){
        $url_foto = base_url().'../admin/foto_kendaraan/';
        $this->db->select(''
                . 'id,'
                . 'jenis_kendaraan as kendaraan_angkut,'
                . 'harga,'
                . 'dimensi_kendaraan,'
                . 'maxweight_kendaraan,'
                . 'hargaminimum_mbox,'
                . "CONCAT('$url_foto', foto_kendaraan, '') as foto_kendaraan");
        $this->db->from('jenis_kendaraan');
        $this->db->where('id >=', '3');
        $get = $this->db->get();
        return $get;
    }
    
    function get_fitur_mservice(){
        $this->db->select('*');
        $this->db->from('fitur_mservice');
        $get = $this->db->get();
        
        $arr_fitur = array();
        $arr_mserv = array();
        $c = 0;
        foreach($get->result() as $row){
            if($get->row('id') == 1){
                $mservice = array(
                    'mservice'=>$row,
                    'ac_type'=>$this->get_ac_type()->result(),
                    'jenis_service'=>$this->get_jenis_mservice($get->row('id'))->result()
                );
            }else{
                $mservice = array(
                    'mservice'=>$row,
                    'jenis_service'=>$this->get_jenis_mservice($get->row('id'))->result()
                );
            }
            array_push($arr_fitur, $mservice);
        }
        return $arr_fitur;
    }
    
    function get_mstore_item_store($data){
        $mstore = array(
            'list_kategori_toko' =>  $this->get_mstore_by_kategori(),
            'list_toko' => $this->get_mstore_by_location($data['latitude'], $data['longitude'])->result()
        );
        return $mstore;
    }
    
    function get_data_restoran($data){
        $mfood = array(
            'kategori_restoran' =>  $this->get_kategori_restoran($data['latitude'], $data['longitude']),
            'restoran_by_location' => $this->get_resto_by_location($data['latitude'], $data['longitude'])->result(),
            'promosi_mfood' => $this->get_promosi_mfood()->result()
        );
        return $mfood;
    }
    
    function get_promosi_mfood(){
        $url_foto = base_url().'../admin/fotopromosimfood/';
        $this->db->select(''
                . 'id,'
                . 'keterangan,'
                . 'id_resto,'
                . "CONCAT('$url_foto', foto, '') as foto");
        $this->db->from('promosi_mfood');
        $this->db->where('is_show', '1');
        $promo = $this->db->get();
        return $promo;
    }
    
    function get_layanan_massage(){
        $url_foto = base_url().'../admin/foto_pijat/';
        $this->db->select(''
                . 'layanan_pijat.*,'
                . "CONCAT('$url_foto', foto, '') as foto");
        $this->db->from('layanan_pijat');
        $pijat = $this->db->get();
        return $pijat;
    }
    
    function get_data_service_ac(){
        $this->db->select('mservice_jenis.*');
        $this->db->from('mservice_jenis');
        $this->db->join('fitur_mservice', 'mservice_jenis.fitur_mservice = fitur_mservice.id');
        $mserv = $this->db->get();
        
        $this->db->select('*');
        $this->db->from('ac_type');
        $mac = $this->db->get();
        
        $mserv_ac = array(
            'jenis_service' => $mserv->result(),
            'ac_type' => $mac->result()
        );
        return $mserv_ac;
    }
    
    function get_kategori_restoran($lat, $lng){
        $url_foto = base_url().'../admin/fotokategoriresto/';
        $get1 = $this->db->query("SELECT id as id_kategori, kategori, CONCAT('$url_foto', foto, '') as foto_kategori FROM kategori_resto");
        return $get1->result();
    }
    
    function get_kategori_restoran_unused($lat, $lng){
        $range = 10000;
        $url_foto = base_url().'../admin/fotokategoriresto/';
        $get1 = $this->db->query("
                SELECT id as id_kategori, 
                    kategori, 
                    CONCAT('$url_foto', foto, '') as foto_kategori,
                    (6371 * acos(cos(radians($lat)) * cos(radians(latitude))"
                    . " * cos(radians(longitude) - radians($lng))"
                    . " + sin(radians($lat)) * sin( radians(latitude)))) AS distance
                FROM kategori_resto kr, restoran r
                WHERE r.kategori_resto = kr.id
                    AND r.status = '1'
                HAVING distance<= $range 
                ORDER BY distance ASC");
        
        return $get1->result();
    }
        
    function get_resto_by_kategori($kat, $lat, $lng){
        $url_foto = base_url().'../vendor/asset/berkas_mmart_mfood/foto_restoran/';
        $range = 10000;
        $mart = $this->db->query("
            SELECT r.*, mmm.is_partner,
                CONCAT('$url_foto', foto_resto, '') as foto_resto,
                kr.id as id_kategori, 
                kr.kategori as kategori_restoran,
                (6371 * acos(cos(radians($lat)) * cos(radians(latitude))"
                . " * cos(radians(longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(latitude)))) AS distance
            FROM restoran r, kategori_resto kr, mitra_mmart_mfood mmm
            WHERE r.kategori_resto = kr.id
                AND r.kategori_resto = $kat
                AND mmm.lapak = r.id
                AND r.status = '1'
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $mart;
    }

    function get_mstore_by_kategori(){
        
        $get1 = $this->db->query("SELECT id as id_kategori, kategori FROM kategori_toko");
        
//        $this->db->select('toko.*,'
//                . 'kategori_toko.kategori');
//        $this->db->from('toko');
//        $this->db->join('toko_in_kategori', 'toko.id = toko_in_kategori.id_toko');
//        $this->db->join('kategori_toko', 'toko_in_kategori.id_kategori = kategori_toko.id');
//        $get2 = $this->db->get();
        
        return $get1->result();
    }
    
    function get_resto_by_location($lat, $lng){
        $url_foto = base_url().'../vendor/asset/berkas_mmart_mfood/foto_restoran/';
        $range = 10000;
        $mart = $this->db->query("
            SELECT r.*, mmm.is_partner, 
                CONCAT('$url_foto', foto_resto, '') as foto_resto,
                kr.id as id_kategori, 
                kr.kategori as kategori_restoran,
                (6371 * acos(cos(radians($lat)) * cos(radians(latitude))"
                . " * cos(radians(longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(latitude)))) AS distance
            FROM restoran r, kategori_resto kr, mitra_mmart_mfood mmm
            WHERE r.kategori_resto = kr.id
                AND mmm.lapak = r.id
                AND r.status = '1'
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $mart;
    }
    
    function get_mstore_by_location($lat, $lng){
        $range = 3;
        $mart = $this->db->query("
            SELECT t.*, kt.id as kategori_toko, kt.kategori as kategori_toko,
                (6371 * acos(cos(radians($lat)) * cos(radians(latitude))"
                . " * cos(radians(longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(latitude)))) AS distance
            FROM toko t, kategori_toko kt
            WHERE t.kategori_toko = kt.id
            HAVING distance <= $range
            ORDER BY distance ASC");
        return $mart;
    }
    
    function get_resto_by_search($data_search){
        $search_resto = $this->db->query("SELECT * FROM restoran WHERE nama_resto LIKE '%".$data_search['cari']."%'");
        $arr_sresto = array();
        $arr_item = array();
        foreach($search_resto->result() as $row){
            $s_resto = $this->get_item_resto($row->id, $data_search['latitude'], $data_search['longitude']);
            $arr_item['nama_resto'] = $row->nama_resto;
            $arr_item['id_resto'] = $row->id;
            $arr_item['jarak_resto'] = $s_resto['jarak'];
            $arr_item['list_menu_resto'] = $s_resto['list_menu_resto'];
            $arr_item['list_makanan'] = $s_resto['list'];
            array_push($arr_sresto, $arr_item);
        }
        return $arr_sresto;
    }
    
    function get_store_by_search($data_search){
        $search_store = $this->db->query("SELECT * FROM toko WHERE nama_toko LIKE '%".$data_search['cari']."%'");
        $arr_sstore = array();
        $arr_item = array();
        foreach($search_store->result() as $row){
            $s_toko = $this->get_item_store($row->id,$data_search['latitude'], $data_search['longitude']);
            $arr_item['nama_toko'] = $row->nama_toko;
            $arr_item['id_toko'] = $row->id;
            $arr_item['jarak_toko'] = $s_toko['jarak'];
            $arr_item['list_barang'] = $s_toko['list'];
            array_push($arr_sstore, $arr_item);
        }
        return $arr_sstore;
    }
    
    function get_item_by_search($data_search){
        $search_store = $this->db->query(""
                . " SELECT bt.*, t.nama_toko "
                . " FROM barang_toko bt, toko t"
                . " WHERE nama_barang LIKE '%".$data_search['cari']."%'"
                . "     AND t.id = bt.id_toko"
                . " GROUP BY (id_toko)");
        $arr_sstore = array();
        $arr_item = array();
        foreach($search_store->result() as $row){
            $s_toko = $this->get_item_store($row->id_toko, $data_search['latitude'], $data_search['longitude']);
            $arr_item['nama_toko'] = $row->nama_toko;
            $arr_item['id_toko'] = $row->id_toko;
            $arr_item['jarak_toko'] = $s_toko['jarak'];
            $arr_item['list_barang'] = $s_toko['list'];
            array_push($arr_sstore, $arr_item);
        }
        return $arr_sstore;
    }
    
    function get_food_by_search($data_search){
        $search_food = $this->db->query(""
                . " SELECT m.*, r.nama_resto, r.id as id_restoran"
                . " FROM makanan m, restoran r, menu_makanan mm"
                . " WHERE (m.nama_menu LIKE '%".$data_search['cari']."%' "
                . "     OR mm.menu_makanan LIKE '%".$data_search['cari']."%')"
                . "     AND m.kategori_menu_makanan = mm.id "
                . "     AND r.id = mm.id_restoran "
                . " GROUP BY (m.id)");
        
        $arr_sresto = array();
        $arr_item = array();
        foreach($search_food->result() as $row){
            $s_resto = $this->get_item_resto($row->id_restoran, $data_search['latitude'], $data_search['longitude']);
            $arr_item['nama_resto'] = $row->nama_resto;
            $arr_item['id_resto'] = $row->id_restoran;
            $arr_item['jarak_resto'] = $s_resto['jarak'];
            $arr_item['list_menu_makanan'] = $s_resto['list_menu_resto'];
            $arr_item['list_makanan'] = $s_resto['list'];
            array_push($arr_sresto, $arr_item);
        }
        return $arr_sresto;
    }
    
    function search_food_or_restoran($data_search){
        $sresto_item = array();
        $cari = $data_search['cari'];
        $lat = $data_search['latitude'];
        $lng = $data_search['longitude'];
        $range = 10000;
        $this->db->select(''
                . 'id as id_restoran,'
                . 'nama_resto as nama,'
                . '"restoran" as kategori,'
                . "(6371 * acos(cos(radians($lat)) * cos(radians( r.latitude ))"
                . " * cos(radians(r.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(r.latitude)))) AS distance");
        $this->db->from('restoran r');
        $this->db->where("nama_resto LIKE '$cari%'");
        $this->db->order_by('distance', 'ASC');
        $this->db->having('distance <=', $range, false);
        $restoResult = $this->db->get();
        
        $menuResult = $this->db->query(""
                . " SELECT"
                . " m.nama_menu as nama,"
                . " r.id as id_restoran,"
                . " 'menu' as kategori,"
                . "(6371 * acos(cos(radians($lat)) * cos(radians( r.latitude ))"
                . " * cos(radians(r.longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(r.latitude)))) AS distance"
                . " FROM makanan m, restoran r, menu_makanan mm"
                . " WHERE (m.nama_menu LIKE '%".$cari."%' "
                . "     OR mm.menu_makanan LIKE '%".$cari."%')"
                . "     AND m.kategori_menu_makanan = mm.id "
                . "     AND r.id = mm.id_restoran "
                . " GROUP BY (m.id)"
                . " HAVING distance <= $range"
                . " ORDER BY distance ASC");
        
//        $sresto = $this->get_resto_by_search($data_search);
//        $sfood = $this->get_food_by_search($data_search);
        
        foreach($restoResult->result() as $rowi){
            array_push($sresto_item, $rowi);        
        }
        
        foreach($menuResult->result() as $rowm){
            array_push($sresto_item, $rowm);        
        }
        
        return $sresto_item;
    }
    
    function search_restoran_or_food($data_search){
        $sresto_item = array();
        $sresto = $this->get_resto_by_search($data_search);
        $sfood = $this->get_food_by_search($data_search);
        
        foreach($sfood as $rowi){
            array_push($sresto_item, $rowi);        
        }
        
        foreach($sresto as $rowm){
            array_push($sresto_item, $rowm);        
        }
        
        return $sresto_item;
    }
    
    function search_store_or_item($data_search){
        $smart_item = array();
        $smart = $this->get_store_by_search($data_search);
        $sitem = $this->get_item_by_search($data_search);
        
        foreach($sitem as $rowi){
            array_push($smart_item, $rowi);        
        }
        foreach($smart as $rowm){
            array_push($smart_item, $rowm);        
        }
        return $smart_item;
    }
    
    function get_item_resto($id_resto, $lat, $lng){
        $jarak = $this->db->query("SELECT (6371 * acos(cos(radians($lat)) * cos(radians(latitude))"
                . " * cos(radians(longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(latitude)))) AS jarak"
                . " FROM restoran"
                . " WHERE id = $id_resto");
        $this->db->select('makanan.*,'
                . 'menu_makanan.menu_makanan,'
                . '');
        $this->db->from('makanan');
        $this->db->join('menu_makanan', 'makanan.kategori_menu_makanan = menu_makanan.id');
        $this->db->join('restoran', 'restoran.id = menu_makanan.id_restoran');
        $this->db->where('restoran.id', $id_resto);
        $getR = $this->db->get();
        
        $this->db->select('menu_makanan.id,'
                . 'menu_makanan.menu_makanan');
        $this->db->from("menu_makanan");
        $this->db->join('restoran', 'restoran.id = menu_makanan.id_restoran');
        $this->db->where('restoran.id', $id_resto);
        $getM = $this->db->get();
        
        return array(
            'jarak' => $jarak->row('jarak'),
            'list' => $getR->result(),
            'list_menu_resto' => $getM->result()
        );
    }
    
    function get_item_store($id_toko, $lat, $lng){
        $jarak = $this->db->query("SELECT (6371 * acos(cos(radians($lat)) * cos(radians(latitude))"
                . " * cos(radians(longitude) - radians($lng))"
                . " + sin(radians($lat)) * sin( radians(latitude)))) AS jarak"
                . " FROM toko"
                . " WHERE id = $id_toko");
        
        $this->db->select('barang_toko.*,'
                . 'kategori_barang.id as id_kategori,'
                . 'kategori_barang.kategori as kategori_barang');
        $this->db->from('barang_toko');
        $this->db->join('kategori_barang', 'kategori_barang.id = barang_toko.kategori_barang');
        $this->db->where('barang_toko.id_toko', $id_toko);
        $get = $this->db->get();
        return array(
            'jarak' => $jarak->row('jarak'),
            'list' => $get->result()
        );
    }
    
    function get_food_in_resto($id_resto){
        $url_foto = base_url().'../vendor/asset/berkas_mmart_mfood/foto_restoran/';
$url_foto_makanan = base_url().'../vendor/asset/berkas_mmart_mfood/foto_makanan/';
        $this->db->select(''
                . 'restoran.*,'
                . "CONCAT('$url_foto', restoran.foto_resto, '') as foto_resto,"
                . 'mitra_mmart_mfood.is_partner');
        $this->db->from('restoran');
        $this->db->join('mitra_mmart_mfood', 'restoran.id = mitra_mmart_mfood.lapak');
        $this->db->where('restoran.id', $id_resto);
        $getResto = $this->db->get();
        
        $getKat = $this->db->query(""
                . " SELECT DISTINCT(mm.id) as id_menu, menu_makanan "
                . " FROM menu_makanan mm, makanan m, restoran r "
                . " WHERE m.kategori_menu_makanan = mm.id "
                . " AND mm.id_restoran = r.id"
                . " AND r.id = $id_resto");
        
//        $getT = $this->db->query("select * from makanan m, menu_makanan mm, restoran r where mm.id = m.kategori_menu_makanan AND mm.id_restoran = r.id AND r.id = '$id_resto'");
        
        $this->db->select('makanan.*,'
				. "CONCAT('$url_foto_makanan', makanan.foto, '') as foto,"
                . 'menu_makanan.id as id_menu_makanan,'
                . 'menu_makanan.menu_makanan');
        $this->db->from('makanan');
        $this->db->join('menu_makanan', 'menu_makanan.id = makanan.kategori_menu_makanan');
        $this->db->join('restoran', 'menu_makanan.id_restoran = restoran.id');
        $this->db->where('restoran.id', $id_resto);
        $getM = $this->db->get();
        
        
        return array(
            'detail_restoran' => $getResto->result(),
            'list_menu_makanan'=>$getKat->result(),
            'list_makanan'=>$getM->result()
        );
    }
    
    function get_item_in_store($id_toko){
        
        $getKat = $this->db->query(""
                . " SELECT DISTINCT(kb.id) as id_kategori, kategori "
                . " FROM kategori_barang kb, barang_toko bt, toko t "
                . " WHERE bt.kategori_barang = kb.id "
                . " AND kb.id_toko = t.id"
                . " AND t.id = $id_toko");
        
        $this->db->select('barang_toko.*,'
                . 'kategori_barang.id as id_kategori,'
                . 'kategori_barang.kategori as kategori_barang');
        $this->db->from('barang_toko');
        $this->db->join('kategori_barang', 'kategori_barang.id = barang_toko.kategori_barang');
        $this->db->join('toko', 'kategori_barang.id_toko = toko.id');
        $this->db->where('toko.id', $id_toko);
        $get = $this->db->get();
        
        return array(
            'list_kategori_barang'=>$getKat->result(),
            'list_barang'=>$get->result()
        );
    }
    
    function get_item_by_kategori($item_kategori){
        $this->db->select('barang_toko.*,'
                . 'kategori_barang.kategori');
        $this->db->from('barang_toko');
        $this->db->join('kategori_barang', 'barang_toko.kategori_barang = kategori_barang.id');
        $this->db->where('barang_toko.kategori_barang', $id_toko);
        $get = $this->db->get();
        return $get;
    }
    
    function get_jenis_mservice($id_fitur){
        $this->db->select('id as id_jenis,'
                . 'jenis_service,'
                . 'harga,'
                . 'deskripsi');
        $this->db->from('mservice_jenis');
        $this->db->where('fitur_mservice', $id_fitur);
        $get = $this->db->get();
        return $get;
    }
    
    function get_ac_type(){
        $this->db->select('*');
        $this->db->from('ac_type');
        return $this->db->get();
    }
    
    public function finish_request($cond, $condtr){
        $this->db->where($condtr);
        $upd = $this->db->update('transaksi', array('waktu_selesai' => date('Y-m-d H:i:s')));
        $data = array(
            'status' => '7'
        );
        $this->db->where($cond);
        $edit = $this->db->update('history_transaksi', $data);
        if($this->db->affected_rows() > 0){
            $last_trans = $this->get_data_last_transaksi($condtr);
            $data_cut = array(
                'id_driver' => $cond['id_driver'],
                'harga' => $last_trans->row('harga'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'order_fitur' => $last_trans->row('order_fitur'),
                'pakai_mpay' => $last_trans->row('pakai_mpay')
            );
            $dataC = array(
                'id_pelanggan' => $last_trans->row('id_pelanggan'),
                'harga' => $last_trans->row('harga'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'pakai_mpay' => $last_trans->row('pakai_mpay'),
                'order_fitur' => $last_trans->row('order_fitur')
            );
            
            $cutUser = $this->cut_user_saldo_by_order($dataC);
            $cutting = $this->cut_driver_saldo_by_order($data_cut);
            if($cutting['status']){
                $datD = array(
                    'status'=>'1'
                );
                $this->db->where(array('id_driver'=>$cond['id_driver']));
                $updDriver = $this->db->update('config_driver', $datD);
                return array(
                    'status' => true,
                    'data' => $last_trans->result(),
                );
            }else{
                return array(
                    'status' => false,
                    'data' => 'false in cutting'
                );
            }
            if($last_trans->row('pakai_mpay') == 1){
                $this->insert_transaksi_pelanggan_mpay($last_trans->row('id_pelanggan'),
                        ($last_trans->row('harga')-$last_trans->row('kredit_promo')));
            }else{
                $this->insert_transaksi_pelanggan($last_trans->row('id_pelanggan'),
                        ($last_trans->row('harga')-$last_trans->row('kredit_promo')));
            }
            
        }else{
            return array(
                'status' => false,
                'data' => 'paling bawah'
            );
        }
    }
    
    public function finish_request_mmart($cond, $condtr, $data_akhir){
        $this->db->where($condtr);
        $upd = $this->db->update('transaksi', array('waktu_selesai' => date('Y-m-d H:i:s')));
        
        $dataDet = array(
            'harga_akhir' => $data_akhir['harga_akhir'],
            'foto_struk' => $data_akhir['foto_struk']
        );
        
        $this->db->where('id_transaksi', $cond['id_transaksi']);
        $updDetail = $this->db->update('transaksi_detail_mmart', $dataDet);
        
        $data = array(
            'status' => '7'
        );
        
        $this->db->where($cond);
        $edit = $this->db->update('history_transaksi', $data);
        if($this->db->affected_rows() > 0){
            $last_trans = $this->get_data_last_transaksi($condtr);
            $data_cut = array(
                'id_driver' => $cond['id_driver'],
                'harga' => $last_trans->row('harga'),
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'order_fitur' => $last_trans->row('order_fitur'),
                'pakai_mpay' =>$last_trans->row('pakai_mpay'),
                'harga_akhir' => $data_akhir['harga_akhir']
            );
            
            $hargaAkh = $last_trans->row('harga');
            if($last_trans->row('pakai_mpay') == 1){
                $hargaAkh = ($last_trans->row('harga')+$data_akhir['harga_akhir']);
            }
            
            $dataC = array(
                'id_pelanggan' => $last_trans->row('id_pelanggan'),
                'harga' => $hargaAkh,
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'pakai_mpay' => $last_trans->row('pakai_mpay'),
                'order_fitur' => $last_trans->row('order_fitur')
            );
            
            $cutUser = $this->cut_user_saldo_by_order($dataC);
            $cutting = $this->cut_driver_saldo_by_order($data_cut);
            if($cutting['status']){
                $datD = array(
                    'status'=>'1'
                );
                $this->db->where(array('id_driver'=>$cond['id_driver']));
                $updDriver = $this->db->update('config_driver', $datD);
                return array(
                    'status' => true,
                    'data' => $last_trans->result(),
                );
            }else{
                return array(
                    'status' => false,
                    'data' => 'false in cutting'
                );
            }
            if($last_trans->row('pakai_mpay') == 1){
                $this->insert_transaksi_pelanggan_mpay($last_trans->row('id_pelanggan'),
                        ($last_trans->row('harga')-$last_trans->row('kredit_promo')));
            }else{
                $this->insert_transaksi_pelanggan($last_trans->row('id_pelanggan'),
                        ($last_trans->row('harga')-$last_trans->row('kredit_promo')));
            }
        }else{
            return array(
                'status' => false,
                'data' => "Error"
            );
        }
    }

    public function finish_request_mfood($cond, $condtr, $data_akhir){
        $this->db->where($condtr);
        $upd = $this->db->update('transaksi', array('waktu_selesai' => date('Y-m-d H:i:s')));
        
        $dataDet = array(
            'harga_akhir' => $data_akhir['harga_akhir'],
            'foto_struk' => $data_akhir['foto_struk']
        );
        
        $this->db->where('id_transaksi', $cond['id_transaksi']);
        $updDetail = $this->db->update('transaksi_detail_mfood', $dataDet);
        
        $data = array(
            'status' => '7'
        );
        
        $this->db->where($cond);
        $edit = $this->db->update('history_transaksi', $data);
        if($this->db->affected_rows() > 0){
            $last_trans = $this->get_data_last_transaksi($condtr);
            $hargaAkh = $last_trans->row('harga');
            if($last_trans->row('pakai_mpay') == 1){
                $hargaAkh = ($last_trans->row('harga')+$data_akhir['harga_akhir']);
            }
            
            $data_cut = array(
                'id_driver' => $cond['id_driver'],
                'harga' => $last_trans->row('harga'),
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'order_fitur' => $last_trans->row('order_fitur'),
                'pakai_mpay' => $last_trans->row('pakai_mpay'),
                'harga_akhir' => $data_akhir['harga_akhir']
            );
           
            $dataC = array(
                'id_pelanggan' => $last_trans->row('id_pelanggan'),
                'harga' => $hargaAkh,
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'pakai_mpay' => $last_trans->row('pakai_mpay'),
                'order_fitur' => $last_trans->row('order_fitur')
            );
            
            $cutUser = $this->cut_user_saldo_by_order($dataC);
            $cutting = $this->cut_driver_saldo_by_order($data_cut);
            if($cutting['status']){
                $datD = array(
                    'status'=>'1'
                );
                $this->db->where(array('id_driver'=>$cond['id_driver']));
                $updDriver = $this->db->update('config_driver', $datD);
                return array(
                    'status' => true,
                    'data' => $last_trans->result(),
                );
            }else{
                return array(
                    'status' => false,
                    'data' => 'false in cutting'
                );
            }
            if($last_trans->row('pakai_mpay') == 1){
                $this->insert_transaksi_pelanggan_mpay($last_trans->row('id_pelanggan'),
                        ($last_trans->row('harga')-$last_trans->row('kredit_promo')));
            }else{
                $this->insert_transaksi_pelanggan($last_trans->row('id_pelanggan'),
                        ($last_trans->row('harga')-$last_trans->row('kredit_promo')));
            }
        }else{
            return array(
                'status' => false,
                'data' => "Error"
            );
        }
    }

    function cut_user_saldo_by_order($dataC){
//        $this->db->update('saldo', $dataC);
        
        $this->db->where('id_user', $dataC['id_pelanggan']);
        $saldo = $this->db->get('saldo')->row('saldo');
        
        if($dataC['pakai_mpay'] == 1){
            $data_ins = array(
                'id_pelanggan' => $dataC['id_pelanggan'],
                'debit' => $dataC['harga'],
                'tipe_transaksi' => '2',
                'pakai_mpay' => $dataC['pakai_mpay'],
                'id_transaksi' => $dataC['id_transaksi'],
                'saldo' => ($saldo - $dataC['harga'])
            );
            $ins_trans = $this->db->insert('transaksi_pelanggan', $data_ins);
            if($ins_trans){
                $this->db->where('id_user', $dataC['id_pelanggan']);
                $upd = $this->db->update('saldo', array('saldo'=>($saldo-$dataC['harga'])));
            }else{
                return false;
            }
        }else{
            $data_ins = array(
                'id_pelanggan' => $dataC['id_pelanggan'],
                'debit' => $dataC['harga'],
                'tipe_transaksi' => '1',
                'pakai_mpay' => $dataC['pakai_mpay'],
                'id_transaksi' => $dataC['id_transaksi'],
                'saldo' => ($saldo)
            );
            $ins_trans = $this->db->insert('transaksi_pelanggan', $data_ins);
            if($ins_trans){
                $this->db->where('id_user', $dataC['id_pelanggan']);
                $upd = $this->db->update('saldo', array('saldo'=>$saldo));
            }else{
                return false;
            }
        }
    }
            
    function cut_driver_saldo_by_order($data){
        $this->db->select('persentase_driver');
        $this->db->where('id_fitur', $data['order_fitur']);
        $persen = $this->db->get('proporsi_biaya')->row('persentase_driver');
               
        $this->db->where('id_user', $data['id_driver']);
        $saldo = $this->db->get('saldo')->row('saldo');
        if($data['pakai_mpay'] == 1){
            $kred = $data['biaya_akhir'];
            $potongan = $kred * ((100-$persen)/100);
            $hasil = $kred - $potongan;            
            if($data['order_fitur'] == 3 || $data['order_fitur'] == 4){
                $hasil = $kred - $potongan + $data['harga_akhir'];
            }
            
            $data_ins = array(
                'id_driver' => $data['id_driver'],
                'kredit' => $hasil,
                'tipe_transaksi' => '6',
                'id_transaksi' => $data['id_transaksi'],
                'saldo' => ($saldo + $hasil)
            );
            $ins_trans = $this->db->insert('transaksi_driver', $data_ins);
            if($ins_trans){
                $this->db->where('id_user', $data['id_driver']);
                $upd = $this->db->update('saldo', array('saldo'=>($saldo + $hasil)));
                if($this->db->affected_rows() > 0){
                    return array(
                        'status' => true,
                        'data' => array('saldo'=>($saldo + $hasil))
                    );
                }else{
                    return array(
                        'status' => false,
                        'data' => 'fail in update'
                    );
                }
            }else{
                return array(
                    'status' => false,
                    'data'=>[]
                );
            }
        }else{
            $hasil = $data['biaya_akhir']*((100-$persen)/100);
            $data_ins = array(
                'id_driver' => $data['id_driver'],
                'debit' => $hasil,
                'tipe_transaksi' => '5',
                'id_transaksi' => $data['id_transaksi'],
                'saldo' => ($saldo -  $hasil)
            );
            $ins_trans = $this->db->insert('transaksi_driver', $data_ins);
                if($ins_trans){
                $this->db->where('id_user', $data['id_driver']);
                $upd = $this->db->update('saldo', array('saldo'=>($saldo - $hasil)));
                if($this->db->affected_rows() > 0){
                    return array(
                        'status' => true,
                        'data' => []
                    );
                }else{
                    return array(
                        'status' => false,
                        'data' => 'fail in update'
                    );
                }
            }else{
                return array(
                    'status' => false,
                    'data'=>[]
                );
            }
        }
        
        
        
    }
    
    function get_data_transaksi($cond){
        if($cond['kode_promo'] == null){
            $this->db->select('*,'
                    . '(kredit_promo) as kredit_promo');
            $this->db->from('transaksi');
            $this->db->where($cond);
            $cek = $this->db->get();
            return $cek;
            
        }else{
            $this->db->select('transaksi.*, voucher.voucher as kode_promo');
            $this->db->from('transaksi');
            $this->db->from('voucher', 'transaksi.kode_promo = voucher.id');
            $this->db->where($cond);
            $this->db->where('voucher.id', $cond['kode_promo']);
            $cek = $this->db->get();
            return $cek;
        }
    }
   
    function get_data_transaksi_msend($data_cond){
        $this->db->select('transaksi.id,'
                . 'transaksi.id_pelanggan,'
                . 'transaksi.id_driver,'
                . 'transaksi.order_fitur,'
                . 'transaksi.start_latitude,'
                . 'transaksi.start_longitude,'
                . 'end_latitude,'
                . 'end_longitude,'
                . 'jarak,'
                . 'harga,'
                . 'waktu_order,'
                . 'waktu_selesai,'
                . 'alamat_asal,'
                . 'alamat_tujuan,'
                . 'kode_promo,'
                . 'kredit_promo,'
                . 'pakai_mpay,'
                . 'rate,'
                . 'transaksi_detail_msend.nama_barang,'
                . 'transaksi_detail_msend.nama_pengirim,'
                . 'transaksi_detail_msend.telepon_pengirim,'
                . 'transaksi_detail_msend.nama_penerima,'
                . 'transaksi_detail_msend.telepon_penerima');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_msend', 'transaksi.id = transaksi_detail_msend.id_transaksi');
        $this->db->where($data_cond);
        $cek = $this->db->get();
        return $cek;
    }
    
    function get_data_transaksi_mbox($data_cond){
        $this->db->select('transaksi.id,'
                . 'id_pelanggan,'
                . 'id_driver,'
                . 'order_fitur,'
                . 'start_latitude,'
                . 'start_longitude,'
                . 'end_latitude,'
                . 'end_longitude,'
                . 'jarak,'
                . 'transaksi.harga,'
                . 'waktu_order,'
                . 'waktu_selesai,'
                . 'alamat_asal,'
                . 'alamat_tujuan,'
                . 'kode_promo,'
                . 'kredit_promo,'
                . 'pakai_mpay,'
                . 'rate,'
                . 'transaksi_detail_mbox.nama_barang,'
                . 'transaksi_detail_mbox.tanggal_pelayanan,'
                . 'transaksi_detail_mbox.jam_pelayanan,'
                . 'transaksi_detail_mbox.catatan,'
                . 'transaksi_detail_mbox.nama_pengirim,'
                . 'transaksi_detail_mbox.telepon_pengirim,'
                . 'transaksi_detail_mbox.nama_penerima,'
                . 'transaksi_detail_mbox.telepon_penerima,'
                . 'transaksi_detail_mbox.waktu_pelayanan,'
                . 'jenis_kendaraan.jenis_kendaraan as kendaraan_angkut');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mbox', 'transaksi.id = transaksi_detail_mbox.id_transaksi');
        $this->db->join('jenis_kendaraan', 'transaksi_detail_mbox.kendaraan_angkut = jenis_kendaraan.id');
        $this->db->where($data_cond);
        $cek = $this->db->get();
        return $cek;
    }

    function get_data_transaksi_mservice($data_cond){
        $this->db->select('transaksi.id,'
                . 'transaksi.id_pelanggan,'
                . 'transaksi.id_driver,'
                . 'transaksi.order_fitur,'
                . 'transaksi.start_latitude,'
                . 'transaksi.start_longitude,'
                . 'end_latitude,'
                . 'end_longitude,'
                . 'jarak,'
                . 'transaksi.harga,'
                . 'waktu_order,'
                . 'waktu_selesai,'
                . 'alamat_asal,'
                . 'alamat_tujuan,'
                . 'kode_promo,'
                . 'kredit_promo,'
                . 'pakai_mpay,'
                . 'rate,'
                . 'status_transaksi.status_transaksi,'
                . 'transaksi_detail_mservice_ac.tanggal_pelayanan,'
                . 'transaksi_detail_mservice_ac.jam_pelayanan,'
                . 'transaksi_detail_mservice_ac.quantity,'
                . 'transaksi_detail_mservice_ac.residential_type,'
                . 'transaksi_detail_mservice_ac.problem,'
                . 'mservice_jenis.id as id_jenis,'
                . 'jenis_service,'
                . 'ac_type.ac_type,'
                . 'fare');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mservice_ac', 'transaksi.id = transaksi_detail_mservice_ac.id_transaksi');
        $this->db->join('mservice_jenis', 'transaksi_detail_mservice_ac.mservice_jenis = mservice_jenis.id');
        $this->db->join('ac_type', 'transaksi_detail_mservice_ac.ac_type = ac_type.nomor');
        $this->db->join('history_transaksi', 'transaksi_detail_mservice_ac.id_transaksi = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where($data_cond);
        $cek = $this->db->get();
        return $cek;
    }
    
    function get_data_transaksi_mstore($data_cond){
        $this->db->select('transaksi.id,'
                . 'transaksi.id_pelanggan,'
                . 'transaksi.id_driver,'
                . 'transaksi.order_fitur,'
                . 'transaksi.start_latitude,'
                . 'transaksi.start_longitude,'
                . 'end_latitude as toko_latitude,'
                . 'end_longitude as toko_longitude,'
                . 'jarak,'
                . 'harga,'
                . 'waktu_order,'
                . 'waktu_selesai,'
                . 'alamat_asal,'
                . 'alamat_tujuan as alamat_toko,'
                . 'kode_promo,'
                . 'kredit_promo,'
                . 'pakai_mpay,'
                . 'rate,'
                . 'transaksi_detail_mstore.id as id_detail,'
                . 'transaksi_detail_mstore.total_biaya as total_biaya,'
                . 'transaksi_detail_mstore.id_toko,'
                . 'nama_toko');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mstore', 'transaksi.id = transaksi_detail_mstore.id_transaksi');
        $this->db->join('toko', 'transaksi_detail_mstore.id_toko = toko.id');
        $this->db->where('transaksi.id', $data_cond);
        $cek = $this->db->get();
        return $cek;
    }
        
    function get_data_transaksi_mmassage($id_transaksi){
        $this->db->select(''
                . 'transaksi.id as id_transaksi,'
                . 'transaksi.harga,'
                . 'transaksi.order_fitur,'
                . 'transaksi.alamat_asal,'
                . 'transaksi.waktu_order,'
                . 'transaksi.kode_promo,'
                . 'transaksi.kredit_promo,'
                . 'transaksi.id_pelanggan,'
                . 'transaksi.start_latitude,'
                . 'transaksi.start_longitude,'
                . 'transaksi.pakai_mpay,'
                . 'cabang_perusahaan.cabang_perusahaan as kota,'
                . 'transaksi_detail_mmassage.tanggal_pelayanan,'
                . 'layanan_pijat.layanan as massage_menu,'
                . 'transaksi_detail_mmassage.jam_pelayanan,'
                . 'transaksi_detail_mmassage.lama_pelayanan,'
                . 'gp1.pemijat as pelanggan_gender,'
                . 'gp2.pemijat as prefer_gender,'
                . 'status_transaksi.status_transaksi,'
                . 'transaksi_detail_mmassage.catatan_tambahan');
        $this->db->from('transaksi_detail_mmassage');
        $this->db->join('transaksi', 'transaksi.id = transaksi_detail_mmassage.id_transaksi');
        $this->db->join('layanan_pijat', 'transaksi_detail_mmassage.massage_menu = layanan_pijat.id');
        $this->db->join('gender_pemijat gp1', 'transaksi_detail_mmassage.pelanggan_gender = gp1.id');
        $this->db->join('gender_pemijat gp2', 'transaksi_detail_mmassage.prefer_gender = gp2.id');
        $this->db->join('cabang_perusahaan', 'transaksi_detail_mmassage.kota = cabang_perusahaan.id');
        $this->db->join('history_transaksi', 'transaksi_detail_mmassage.id_transaksi = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where('transaksi.id', $id_transaksi);
        $cek = $this->db->get();
        return $cek;
    }

    function get_data_last_transaksi($cond){
        $this->db->select('id as id_transaksi,'
                . '(waktu_selesai - waktu_order) as lama,'
                . 'waktu_selesai,'
                . 'harga,'
                . 'biaya_akhir,'
                . 'kredit_promo,'
                . 'order_fitur,'
                . 'id_pelanggan,'
                . 'pakai_mpay');
        $this->db->from('transaksi');
        $this->db->where($cond);
        $cek = $this->db->get();
        return $cek;
    }
    
    function rate_driver($data){
        $ins_rate = $this->db->insert('rating_driver', $data);
        if($this->db->affected_rows() == 1){
            $get_rating = $this->count_rate_driver($data['id_driver']);
            
            $this->db->where('id', $data['id_transaksi']);
            $upd_trans = $this->db->update('transaksi', array('rate'=>$data['rating']));
            
            $this->db->where('id', $data['id_driver']);
            $upd_driver = $this->db->update('driver', array('rating'=>$get_rating));
            return true;
        }else{
            return false;
        }
    }
    
    function rate_pelanggan($data){
        $ins_rate = $this->db->insert('rating_pelanggan', $data);
        if($this->db->affected_rows() == 1){
            $get_rating = $this->count_rate_pelanggan($data['id_pelanggan']);
            
            $this->db->where('id', $data['id_pelanggan']);
            $upd_driver = $this->db->update('pelanggan', array('rating'=>$get_rating));
            return true;
        }else{
            return false;
        }
    }
    
    function count_rate_driver($id){
        $this->db->select('rating');
        $this->db->from('rating_driver');
        $this->db->where('id_driver', $id);
        $cek = $this->db->get();
        $rate = 0;
        $hasil = 0;
        if($cek->num_rows() > 0){
            foreach($cek->result() as $row){
                $rate+=$row->rating;
            }
            $hasil = $rate/$cek->num_rows();
        }
        return $hasil;
    }
    
    function count_rate_pelanggan($id){
        $this->db->select('rating');
        $this->db->from('rating_pelanggan');
        $this->db->where('id_pelanggan', $id);
        $cek = $this->db->get();
        $rate = 0;
        $hasil = 0;
        if($cek->num_rows() > 0){
            foreach($cek->result() as $row){
                $rate+=$row->rating;
            }
            $hasil = $rate/$cek->num_rows();
        }
        return $hasil;
    }
    
    function get_data_driver_histroy($id_transaksi){
        $url_foto = base_url().'../admin/fotodriver/';
        
        $this->db->select(''
                . 'driver.id,'
                . 'nama_depan,'
                . 'nama_belakang,'
                . 'no_telepon,'
                . 'cd.latitude,'
                . 'cd.longitude,'
                . 'cd.update_at,'
                . "CONCAT('$url_foto', driver.foto, '') as foto,"
                . 'reg_id,'
                . '"0" as distance,'
                . 'k.id as id_kendaraan,'
                . 'k.merek,'
                . 'k.tipe,'
                . 'k.jenis,'
                . 'k.nomor_kendaraan,'
                . 'k.warna');
        $this->db->from('driver');
        $this->db->join('history_transaksi', 'driver.id = history_transaksi.id_driver');
        $this->db->join('config_driver cd', 'driver.id = cd.id_driver');
        $this->db->join('kendaraan k', 'driver.kendaraan = k.id');
        $this->db->where('history_transaksi.id_transaksi', $id_transaksi);
        $getD = $this->db->get();
        return $getD;
    }
    
    function get_data_history_mmassage($id_transaksi){
        $getD = $this->get_data_driver_histroy($id_transaksi);
        
        $order = array(
            'message' => 'success',
            'data_transaksi'=>$this->get_data_transaksi_mmassage($id_transaksi)->result(),
            'list_driver'=> $getD->result()
        );
        return $order;
    }
    
    function get_data_history_mfood($id_transaksi){
        $getD = $this->get_data_driver_histroy($id_transaksi);
        $dataMfood = $this->get_data_transaksi_mfood($id_transaksi);
        $order = array(
            'message' => 'success',
            'data_transaksi'=> $dataMfood['data_transaksi'],
            'list_barang'=> $dataMfood['list_barang'],
            'list_driver'=> $getD->result()
        );
        return $order;
    }
    
    function get_data_order_msend($id_transaksi){
        $this->db->select(''
                . 'transaksi.*,'
                . 'transaksi_detail_msend.*,'
                . 'status_transaksi.id as status,'
                . 'status_transaksi.status_transaksi');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_msend', 'transaksi.id = transaksi_detail_msend.id_transaksi');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
//        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->where('transaksi.id', $id_transaksi);
        $getData = $this->db->get();
        if($this->db->affected_rows() == 1){
            return array(
                'status' => TRUE,
                'data_transaksi' => $getData->result(),
                'list_driver' => $this->get_data_driver_histroy($id_transaksi)->result()
            );
        }else{
            return array(
                'status' => FALSE,
                'data_transaksi' => [],
                'list_driver' => []
            );            
        }
    }
    
    function get_data_order_mservice($id_transaksi){
        $this->db->select(''
                . 'transaksi.*,'
                . 'transaksi_detail_mservice_ac.*,'
                . 'mservice_jenis.jenis_service,'
                . 'status_transaksi.status_transaksi,'
                . 'ac_type.ac_type');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_mservice_ac', 'transaksi.id = transaksi_detail_mservice_ac.id_transaksi');
        $this->db->join('mservice_jenis', 'transaksi_detail_mservice_ac.mservice_jenis = mservice_jenis.id');
        $this->db->join('ac_type', 'transaksi_detail_mservice_ac.ac_type = ac_type.nomor');
        $this->db->join('history_transaksi', 'transaksi_detail_mservice_ac.id_transaksi = history_transaksi.id_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where('transaksi.id', $id_transaksi);
        $getData = $this->db->get();
        if($this->db->affected_rows() == 1){
            return array(
                'message' => 'success',
                'data_transaksi' => $getData->result(),
                'list_driver' => $this->get_data_driver_histroy($id_transaksi)->result()
            );
        }else{
            return array(
                'message' => 'fail',
                'data_transaksi' => [],
                'list_driver' => []
            );            
        }
    }
    
    function check_biaya_kode_promo($id, $fitur, $biaya){
        
        $kode_voucher = $this->db->query("
            SELECT  v.id as id_voucher, 
                p.id as id_pelanggan, v.nilai, tv.id as tipe_voucher, rv.count_of_use
            FROM redeemed_voucher rv, voucher v, pelanggan p, tipe_voucher tv
            WHERE rv.id_voucher = v.id AND p.id = rv.id_pelanggan 
                AND v.is_valid = 'yes' AND rv.count_of_use <> 0 AND p.id = '$id' 
                AND tv.id = v.tipe_voucher AND v.untuk_fitur = '$fitur'
        ");
        $harga_akhir = $biaya;
        $kredit_promo = 0;
        if($kode_voucher->num_rows() > 0){
            if($kode_voucher->row('tipe_voucher') == 1){
                $kredit_promo = $harga_akhir*(1- ($kode_voucher->row('nilai')/100));
            }else if($kode_voucher->row('tipe_voucher') == 2){
                $kredit_promo = $kode_voucher->row('nilai');
            }
            $harga_akhir = $biaya - $kredit_promo;
            if($harga_akhir < 0){
                $harga_akhir = 0;
            }
            $this->db->where('id_pelanggan', $id);
            $this->db->update('redeemed_voucher', array('count_of_use' => $kode_voucher->row('count_of_use')-1));
        }
        return array(
            'harga_akhir'=>$harga_akhir,
            'kredit_promo'=> $kredit_promo,
            'kode_promo'=>$kode_voucher->row('id_voucher')
        );
    }
   
    function insert_transaksi_pelanggan($id_pelanggan, $biaya){
        $this->db->select('saldo');
        $this->db->from('saldo');
        $this->db->where('id_user', $id_pelanggan);
        $saldo = $this->db->get();
        
        $isi_trans = array(
            'id_pelanggan'=>$id_pelanggan,
            'debit'=>$biaya,
            'tipe_transaksi'=>1,
            'pakai_mpay'=> false,
            'saldo'=> $saldo->row('saldo')
        );
        $this->db->insert('transaksi_pelanggan', $isi_trans);
        $this->db->where('id_user', $id_pelanggan);
        $upd = $this->db->update('saldo', array('saldo'=>$saldo->row('saldo')));
    }
    
    function insert_transaksi_pelanggan_mpay($id_pelanggan, $biaya){
        $this->db->select('saldo');
        $this->db->from('saldo');
        $this->db->where('id_user', $id_pelanggan);
        $saldo = $this->db->get();
        
        $isi_trans = array(
            'id_pelanggan'=>$id_pelanggan,
            'debit'=>$biaya,
            'tipe_transaksi'=>1,
            'pakai_mpay'=> true,
            'saldo'=> ($saldo->row('saldo')-$biaya)
        );
        $biaya_mpay = $biaya;
        if($saldo->row('saldo') > $biaya){
            $this->db->insert('transaksi_pelanggan', $isi_trans);
            $this->db->where('id_user', $id_pelanggan);
            $upd = $this->db->update('saldo', array('saldo'=>($saldo->row('saldo')-$biaya)));
            if($upd){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function get_diskon_mpay($data_req){
        $this->db->select('nilai');
        $this->db->from('voucher');
        $this->db->where('voucher', 'MPAY50');
        $mpay = $this->db->get();
        
        $ha = 0;
        $dataKredit = 0;
        if($data_req['pakai_mpay'] == 1){
            $ha  = $data_req['harga'] - $data_req['kredit_promo'];
            if($ha <= 0){
                $ha = 0;
            }
            $diskon = 100 - $mpay->row('nilai');
            
            $dataKredit = $ha * $diskon;
        }
        
        return $dataKredit;
    }
    
    function diskon_mpay($fitur){
        $this->db->select('nilai');
        $this->db->from('voucher');
        $this->db->where("voucher LIKE 'MPAYDISKON%'");
        $this->db->where('untuk_fitur', $fitur);
//        $this->db->where('voucher', 'MPAYDISKON2');
        $mpay = $this->db->get();
        return $mpay->row('nilai')/100;
    }
    
    function get_additional_config($fitur){
        $this->db->select(''
                . 'additional,'
                . 'value');
        $this->db->from('additional_config');
        $this->db->where('fitur', $fitur);
        $add = $this->db->get();
        
        $this->db->select('*');
        $this->db->from('asuransi');
        $this->db->order_by('id', 'ASC');
        $ass = $this->db->get();
        
        $dataAdd = array(
            $add->row('additional')=>$add->row('value'),
            'asuransi'=>$ass->result()
        );
        
        return $dataAdd;
    }
    
    function get_reg_id_driver($id_driver){
        $this->db->select('reg_id');
        $this->db->from('driver');
        $this->db->where('id', $id_driver);
        return $this->db->get()->row('reg_id');
    }
    
    function get_reg_id_pelanggan($id_user){
        $this->db->select('reg_id');
        $this->db->from('pelanggan');
        $this->db->where('id', $id_user);
        return $this->db->get()->row('reg_id');
    }
    
    function check_status($dataTrans){
        $this->db->select(''
                . 'status_transaksi.id as status,'
                . 'status_transaksi.status_transaksi as keterangan');
        $this->db->from('history_transaksi');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id');
        $this->db->where($dataTrans);
        $cek = $this->db->get();
        
        $stat = TRUE;
        if($cek->row('status')== 1){
            $stat = FALSE;
        }
        $dataCheck = array(
            'message' => 'check status',
            'status' => $stat,
            'data' => $cek->result(),
            'list_driver' => $this->get_data_driver_histroy($dataTrans['id_transaksi'])->result()
        );
        
        return $dataCheck;
    }
    
    function get_driver_location($idDriver){
        $this->db->select(''
                . 'id_driver,'
                . 'latitude,'
                . 'longitude');
        $this->db->from('config_driver');
        $this->db->where('id_driver', $idDriver);
        $loc = $this->db->get();
        return $loc;
    }
}
