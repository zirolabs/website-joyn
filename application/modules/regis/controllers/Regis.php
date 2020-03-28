<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","512M");

class Regis extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();
		  $this->load->helper(array('form', 'url'));
		  $this->load->model('front/m_upload');
	}

	function index(){
		// $data = $this->m_upload->select_table_order_limit('*', 'blog_content', 'tanggal', 2);
		$data = $this->m_upload->select('*', 'blog_content');
		$this->template->load('layout/template','front/index', array('data' => $data));
		
	}

	// function cobaonepage(){
	// 	$this->template->load('layout/template','front/cobaonepage');
	// }

	function home(){
		// $data = $this->m_upload->select_table_order_limit('*', 'blog_content', 'tanggal', 2);
		$data = $this->m_upload->select('*', 'blog_content');
		$this->template->load('layout/template','front/index', array('data' => $data));
	}



	// function join(){
	// 	$this->template->load('layout/template','front/regis_joyn');
		
	// }
	
	function blog(){
		$this->template->load('layout/template','front/blog');
		
	}
	
	function kebijakanPrivasi(){
		$this->template->load('layout/template','front/kebijakan_privasi');
		
	}
	
	function syaratKetentuan(){
		$this->template->load('layout/template','front/syarat_dan_ketentuan');
		
	}
	
	function forgot_password(){
		$this->template->load('layout/template','front/pengguna');
	}





	// function tesfitur(){
	// 	$this->template->load('layout/template','front/tesfitur', array('error' => ' ' ));
	// }


	function j_ride(){
	
		$this->template->load('layout/template','j_ride/index', array('form' => 0 ));
	}

	function j_car(){
	
		$this->template->load('layout/template','j_car/index', array('error' => ' ' ));
	}

	function j_pick(){
		$jenis = $this->m_upload->select_where('*' , 'jenis_kendaraan', 'id >', '2');
		$this->template->load('layout/template','j_pick/index', array('jenis' => $jenis));
	}
	function j_food(){
		$jenis = $this->m_upload->select('*' , 'kategori_resto');
		$this->template->load('layout/template','j_food/index', array('jenis' => $jenis ));
	}
	function j_mangfood_personal(){
		$this->template->load('layout/template','j_food_personal', array('error' => ' ' ));
	}
	function j_food_company(){
		$this->template->load('layout/template','j_food_company', array('error' => ' ' ));
	}

	function j_service(){
		$keahlian = $this->m_upload->select('*', 'mservice_jenis');
		$jenis = $this->m_upload->select('*' , 'peralatan_service');
		$area = $this->m_upload->select('*', 'cabang_perusahaan');
		$this->template->load('layout/template','j_service', array('jenis' => $jenis, 'area'=> $area, 'keahlian'=>$keahlian ));
	}

	function j_massage(){
		$area = $this->m_upload->select('*', 'cabang_perusahaan');
		$jenis = $this->m_upload->select('*' , 'layanan_pijat');
		$this->template->load('layout/template','j_massage', array('jenis' => $jenis, 'area' => $area ));
	}

	function j_mart(){
		$jenis = $this->m_upload->select('*' , 'kategori_toko');
		$this->template->load('layout/template','j_mart/index', array('jenis' => $jenis ));
	}
	

	public function upload(){
        if (isset($_POST['submit'])) {

            $validasi = 0;

            $merk=$this->input->post('merk');
            $tipe=$this->input->post('tipe');
            $jenis=$this->input->post('jenis');
            $no_kendaraan=$this->input->post('nomor_kendaraan');
            $warna=$this->input->post('warna');
            $job=$this->input->post('job');

            $nama_depan = $this->input->post('nama_depan');
            $nama_belakang = $this->input->post('nama_belakang');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $no_telepon = $this->input->post('no_telepon');
            $tempat_lahir = $this->input->post('tempat_lahir');
            $tgl_lahir = $this->input->post('tgl_lahir');
            $no_ktp = $this->input->post('no_ktp');


            $pesan = '';

            if ($nama_depan == '') {
                $pesan = '-The first name cannot be empty\\n';
                $validasi = 1;
            }

            if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_depan)) {

                $pesan = $pesan.'-invalid first name\\n';
                $validasi = 1;
            }

            if($nama_belakang != ""){
                if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_belakang)) {
                    $pesan = $pesan.'-invalid last name\\n';
                    $validasi = 1;
                }
            }


            if ($email == '') {
                $pesan = $pesan.'-email cannot be empty\\n';
                $validasi = 1;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $pesan = $pesan.'-Invalid e-mail address\\n';
                $validasi = 1;
            }

            if($email != ''){
                $data_email = $this->m_upload-> select_get_jumlah_where('berkas_lamaran_kerja' , array('email' => $email));
                if($data_email != 0){
                    $pesan = $pesan.'-Email is registered, please change your email\\n';
                    $validasi = 1;
                }

            }
            if ($no_telepon == '') {
                $pesan = $pesan.'-No. The phone must be filled in \\n';
                $validasi = 1;
            }

            if (strlen($no_telepon) > 15) {
                $pesan = $pesan.'-Phone is invalid\\n';
                $validasi = 1;
            }
            
            if($no_telepon != ''){
                $data_telepon = $this->m_upload->select_get_no_telp_where(array('no_telepon' => $no_telepon), array('nomor_telepon' => $no_telepon),                   array('nomor_telepon' => $no_telepon));
                if($data_telepon){
                    $pesan = $pesan.'-telephone number is registered, please change your telephone number\\n';
                    $validasi = 1;
                }

            }

            if ($tempat_lahir == '') {
                $pesan = $pesan.'-Place of Birth Must be filled\\n';
                $validasi = 1;
            }

            if ($tgl_lahir == '') {
                $pesan = $pesan.'-Date of Birth Must be filled in\\n';
                $validasi = 1;
            }
            
            if($no_ktp != ''){
                $data_ktp = $this->m_upload-> select_get_jumlah_where('berkas_lamaran_kerja' , array('no_ktp' => $no_ktp));
                if($data_ktp != 0){
                    $pesan = $pesan.'-ID card is registered, please correct your ID number\\n';
                    $validasi = 1;
                }

            }

            if ($no_ktp == '') {
                $pesan = $pesan.'-ID number must be filled in\\n';
                $validasi = 1;
            }       

            $allowed =  array('gif','png' ,'jpg' ,'jpeg' ,'GIF' , 'PNG' , 'JPG' , 'JPEG');


            $nama_ktp = $_FILES['foto_ktp']['name'];
            $ext_ktp = pathinfo($nama_ktp, PATHINFO_EXTENSION);

            $nama_stnk = $_FILES['foto_stnk']['name'];
            $ext_stnk = pathinfo($nama_stnk, PATHINFO_EXTENSION);

            $nama_sim = $_FILES['foto_sim']['name'];
            $ext_sim = pathinfo($nama_sim, PATHINFO_EXTENSION);

            $nama_diri = $_FILES['foto_diri']['name'];
            $ext_diri = pathinfo($nama_diri, PATHINFO_EXTENSION);




             if ($_FILES['foto_ktp']['name'] == '') {
                 $pesan = $pesan.'-ID cards cannot be empty\\n';
                 $validasi = 1;
             }

             elseif($_FILES['foto_ktp']['name'] != ''){
                 if(!in_array($ext_ktp,$allowed)){
                     $pesan = $pesan.'-Your ID card is not suitable / incompatible! Please check again\\n';
                     $validasi = 1;
                 }
                 elseif($_FILES['foto_ktp']['name'] != '' && $_FILES["foto_ktp"]["size"] > 1000000){
                     $pesan = $pesan.'-Your ID card is too large\\n';
                     $validasi = 1;
                 }
             }





             elseif($_FILES['foto_stnk']['name'] != ''){
                 if(!in_array($ext_stnk,$allowed)){
                     $pesan = $pesan.'-Your vehicle registration photo is not suitable / incompatible! Please check again\\n';
                     $validasi = 1;
                 }
                 elseif($_FILES['foto_stnk']['name'] != '' && $_FILES["foto_stnk"]["size"] > 1000000){
                     $pesan = $pesan.'-Foto STNK Anda terlalu besar\\n';
                     $validasi = 1;
                 }

             }



             if ($_FILES['foto_stnk']['name'] == '' && $_FILES["foto_stnk"]["size"] == 0) {
                 $pesan = $pesan.'-The vehicle registration photo cannot be empty\\n';
                 $validasi = 1;
             }


             if ($_FILES['foto_sim']['name'] == '') {
                 $pesan = $pesan.'-Driving License photos cannot be empty\\n';
                 $validasi = 1;
             }

             elseif($_FILES['foto_sim']['name'] != '' ){
                 if(!in_array($ext_sim,$allowed)){
                     $pesan = $pesan.'-photo driving license is not suitable / incompatible! Please check again\\n';
                     $validasi = 1;
                 }
                 elseif($_FILES['foto_sim']['name'] != '' && $_FILES["foto_sim"]["size"] > 1000000){
                     $pesan = $pesan.'-Driving License photos are too large\\n';
                     $validasi = 1;
                 }

             }


             if($_FILES['foto_diri']['name'] != ''){
                 if(!in_array($ext_diri,$allowed)){
                     $pesan = $pesan.'-Your photo is not suitable / incompatible! Please check again\\n';
                     $validasi = 1;
                 }
                 elseif($_FILES["foto_diri"]["size"] > 1000000){
                     $pesan = $pesan.'-Photos Profile are too large\\n';
                     $validasi = 1;
                 }

             }


            if ($merk == '') {
                $pesan = $pesan.'-Vehicle Brands Must be filled in\\n';
                $validasi = 1;
            }

            if ($tipe == '') {
                $pesan = $pesan.'-Vehicle Type Required\\n';
                $validasi = 1;
            }

            if ($no_kendaraan == '') {
                $pesan = $pesan.'-Vehicle Number Must be filled in\\n';
                $validasi = 1;
            }

            if ($warna == '') {
                $pesan = $pesan.'-Vehicle Color Must be filled in\\n';
                $validasi = 1;
            }

            if($validasi == 1){

                echo "<script>
                alert('Sorry, there was an error filling out the Form:\\n".$pesan."');
                window.history.go(-1);
                </script>";
            }

            elseif($validasi == 0){


                $foto_diri = $this->input->post('foto_diri');

                $countjml = $this->db->query("SELECT COUNT(id) as jumlah FROM driver");
                $nilai = $countjml->result_array();
                $nilaitambah = $nilai[0]['jumlah'] + 1;
                $idinsert = "D$nilaitambah";            

                $data_driver = array('id' => $idinsert,
                  'nama_depan' => $nama_depan,
                  'nama_belakang' => $nama_belakang,
                  'email' => $email,
                  'password' => $password,
                  'no_telepon' => $no_telepon,
                  'tempat_lahir' => $tempat_lahir,
                  'tgl_lahir' => $tgl_lahir,
                  'no_ktp' => $no_ktp,
                  'job' => $job,
                  // 'rating' => 0,
                  // 'gender' =>$this->input->post('gender'),
                  'nama_bank' =>$this->input->post('nama_bank'),
                  'rekening_bank' =>$this->input->post('rekening_bank'),
                  'atas_nama' =>$this->input->post('nama_depan'),
                  'created_at'=>date('Y-m-d H:i:s'),
                  'status' =>2,

              );

                // $foto_ktp_ext = [
                //                 'file_name' = $foto_diri,
                //                 'upload_path' = $this->driver_path . 'foto_ktp/',
                //                 'allowed_types' = 'jpg|jpeg|png',
                //                 'max_size' = 1000;
                //             ];
                // $this->load->library('upload', $foto_ktp_ext);
                // $this->upload->initialize($foto_ktp_ext);
                
                // if(!$this->upload->do_upload('$foto_ktp_ext')){
                //    $foto_ktp_ext="";
                // }else{
                //    $foto_ktp_ext=$this->upload->file_name;
                // }

                $insert_driver = $this->m_upload->insert('driver', $data_driver);

                if($insert_driver){
                    $data_berkas = $this->m_upload->select_where('*' , 'driver', 'no_ktp', $no_ktp);
                    $pathfilesavektp = './upload/berkas_driver/foto_ktp/';
                    $pathfilesavestnk = './upload/berkas_driver/foto_stnk/';
                    $pathfilesavesim = './upload/berkas_driver/foto_sim/';
                    $pathfilesaveprofil = './upload/berkas_driver/foto_diri/';


                    $foto_ktp = 'ktp_'.$data_berkas[0]['id'].".".$ext_ktp;
                    $config['upload_path']          = $pathfilesavektp;
                    $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                    $config['file_name']            = 'ktp_'.$data_berkas[0]['id'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $this->upload->do_upload('foto_ktp');

                    $foto_stnk = 'stnk_'.$data_berkas[0]['id'].".".$ext_stnk;
                    $config1['upload_path']          = $pathfilesavestnk;
                    $config1['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                    $config1['file_name']           = 'stnk_'.$data_berkas[0]['id'];
                    $this->load->library('upload', $config1);
                    $this->upload->initialize($config1);
                    $this->upload->do_upload('foto_stnk');

                    $foto_sim = 'sim_'.$data_berkas[0]['id'].".".$ext_sim;

                    $sim['upload_path']          = $pathfilesavesim;
                    $sim['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                    $sim['file_name']           = 'sim_'.$data_berkas[0]['id'];
                    $this->load->library('upload', $sim);
                    $this->upload->initialize($sim);
                    $this->upload->do_upload('foto_sim');


                    if($_FILES['foto_diri']['name'] == '' && $_FILES["foto_diri"]["size"] == 0){
                        $foto_diri = "anonym.jpg";
                    }

                    else{
                        $foto_diri = 'diri_'.$data_berkas[0]['id'].".".$ext_diri;

                        $diri['upload_path']          = $pathfilesaveprofil;
                        $diri['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                        $diri['file_name']          = 'diri_'.$data_berkas[0]['id'];
                        $this->load->library('upload', $diri);
                        $this->upload->initialize($diri);
                        $this->upload->do_upload('foto_diri');
                    }

                    

                    $data_foto = array(
                      // 'foto_ktp' => $foto_ktp,
                      // 'foto_stnk' => $foto_stnk,
                      // 'foto_sim' => $foto_sim,
                      'foto' => $foto_diri
                  );
            // print_r($data_berkas);

                    $insert_foto_driver = $this->m_upload->update('id', $data_berkas[0]['id'], 'driver', $data_foto);


                    // $this->session->unset_userdata('form_isi'); 
                    // $this->session->set_userdata('form_isi', 1);
                    // redirect($this->input->post('redirect'));
                }


                $id_kendaraan = $this->m_upload->select_get_jumlah('kendaraan');
                $id_kendaraan = $id_kendaraan+1;
                $data_insert = array('id' => $id_kendaraan,
                 'merek' => $merk,
                 'tipe' => $tipe,
                 'jenis' => $jenis,
                 'nomor_kendaraan' => $no_kendaraan,
                 'warna' => $warna);

                $insert_kendaraan = $this->m_upload->insert('kendaraan', $data_insert);

                if($insert_kendaraan){

                    $id_lamaran = $this->m_upload->select_get_jumlah('berkas_lamaran_kerja');
                    $id_lamaran = $id_lamaran+1;
                    $data = $this->m_upload->select_table_order_limit('*','kendaraan' , 'id' , 1);
                    $data_lamaran = array('nomor' => $id_lamaran,
                      'nama_depan' => $nama_depan,
                      'nama_belakang' => $nama_belakang,
                      'email' => $email,
                      'no_telepon' => $no_telepon,
                      'tempat_lahir' => $tempat_lahir,
                      'tgl_lahir' => $tgl_lahir,
                      'no_ktp' => $no_ktp,
                      'kendaraan' => $data[0]['id'],
                      'job' => $job,
                      'foto_ktp' => '',
                      'foto_stnk' => '',
                      'foto_sim' => '',
                      'foto_diri' => '',
                      'is_valid' => 'no'
                    );
                    $insert_lamaran = $this->m_upload->insert('berkas_lamaran_kerja', $data_lamaran);

                    if($insert_lamaran){
                        $data_berkas = $this->m_upload->select_where('*' , 'berkas_lamaran_kerja', 'no_ktp', $no_ktp);
                        $pathfilesavektp = './upload/berkas_driver/foto_ktp/';
                        $pathfilesavestnk = './upload/berkas_driver/foto_stnk/';
                        $pathfilesavesim = './upload/berkas_driver/foto_sim/';
                        $pathfilesaveprofil = './upload/berkas_driver/foto_diri/';


                        $foto_ktp = 'ktp_'.$data_berkas[0]['nomor'].".".$ext_ktp;
                        $config['upload_path']          = $driver_path . '/foto_ktp/';
                        $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                        $config['file_name']            = 'ktp_'.$data_berkas[0]['nomor'];
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $this->upload->do_upload('foto_ktp');

                        $foto_stnk = 'stnk_'.$data_berkas[0]['nomor'].".".$ext_stnk;
                        $config1['upload_path']          = $driver_path . '/foto_stnk/';
                        $config1['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                        $config1['file_name']           = 'stnk_'.$data_berkas[0]['nomor'];
                        $this->load->library('upload', $config1);
                        $this->upload->initialize($config1);
                        $this->upload->do_upload('foto_stnk');

                        $foto_sim = 'sim_'.$data_berkas[0]['nomor'].".".$ext_sim;

                        $sim['upload_path']          = $driver_path . '/foto_sim/';
                        $sim['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                        $sim['file_name']           = 'sim_'.$data_berkas[0]['nomor'];
                        $this->load->library('upload', $sim);
                        $this->upload->initialize($sim);
                        $this->upload->do_upload('foto_sim');


                        if($_FILES['foto_diri']['name'] == '' && $_FILES["foto_diri"]["size"] == 0){
                            $foto_diri = "anonym.jpg";
                        }

                        else{
                            $foto_diri = 'diri_'.$data_berkas[0]['nomor'].".".$ext_diri;

                            $diri['upload_path']          = $driver_path . '/foto_diri/';
                            $diri['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                            $diri['file_name']          = 'diri_'.$data_berkas[0]['nomor'];
                            $this->load->library('upload', $diri);
                            $this->upload->initialize($diri);
                            $this->upload->do_upload('foto_diri');
                        }



                        $data_foto = array('foto_ktp' => $foto_ktp,
                          'foto_stnk' => $foto_stnk,
                          'foto_sim' => $foto_sim,
                          'foto_diri' => $foto_diri
                        );

                        $insert_foto = $this->m_upload->update('nomor', $data_berkas[0]['nomor'], 'berkas_lamaran_kerja', $data_foto);


                        $this->session->unset_userdata('form_isi'); 
                        $this->session->set_userdata('form_isi', 1);
                        redirect($this->input->post('redirect'));
                    }
                }

            }


        }
        
        
    }



    public function upload_mmassage(){
        $validasi = 0;

        $nama_lengkap   = $this->input->post('nama_lengkap');
        $jk             = $this->input->post('jk');
        $no_hp          = $this->input->post('no_hp');
        $no_ktp         = $this->input->post('no_ktp');
        $email          = $this->input->post('email');
        $tempat_lahir   = $this->input->post('tempat_lahir');
        $tgl_lahir      = $this->input->post('tgl_lahir');
        $alamat_tinggal = $this->input->post('alamat_tinggal');
        $kecamatan      = $this->input->post('kecamatan');
        $kota           = $this->input->post('kota');
        $pengalaman     = $this->input->post('pengalaman');
        $area_kerja     = $this->input->post('area_kerja');
        $pekerjaan_terakhir = $this->input->post('pekerjaan_terakhir');
        $telepon_keluarga   = $this->input->post('telepon_keluarga');
        $job=$this->input->post('job');


        $pesan = '';

        if ($nama_lengkap == '') {
            $pesan = '-Full names cannot be empty\\n';
            $validasi = 1;
        }

        if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_lengkap)) {

            $pesan = $pesan.'-invalid first name\\n';
            $validasi = 1;
        }

        if ($jk == '') {
            $pesan = $pesan.'-Gender cannot be empty\\n';
            $validasi = 1;
        }

        if ($no_hp == '') {
            $pesan = $pesan.'-phone must be filled in \\n';
            $validasi = 1;
        }

        if (strlen($no_hp) > 15) {
            $pesan = $pesan.'-Phone is invalid\\n';
            $validasi = 1;
        }
        
        if($no_hp != ''){
            $data_telepon = $this->m_upload->select_get_no_telp_where(array('no_telepon' => $no_hp), array('nomor_telepon' => $no_hp),                   array('nomor_telepon' => $no_hp));
            if($data_telepon){
                $pesan = $pesan.'-telephone number is registered, please change your telephone number\\n';
                $validasi = 1;
            }

        }
        
        if($no_ktp != ''){
            $data_ktp = $this->m_upload-> select_get_jumlah_where('pendaftaran_mmassage' , array('nomor_ktp' => $no_ktp));
            if($data_ktp != 0){
                $pesan = $pesan.'-ID card is registered, please check your ID number again\\n';
                $validasi = 1;
            }

        }
        
        if ($no_ktp == '') {
            $pesan = $pesan.'-ID number must be filled in\\n';
            $validasi = 1;
        }

        if ($email == '') {
            $pesan = $pesan.'-email cannot be empty\\n';
            $validasi = 1;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $pesan = $pesan.'-Invalid e-mail address\\n';
            $validasi = 1;
        }
        
        if($email != ''){
            $data_email = $this->m_upload-> select_get_jumlah_where('pendaftaran_mmassage' , array('email' => $email));
            if($data_email != 0){
                $pesan = $pesan.'-Email is registered, please change your email\\n';
                $validasi = 1;
            }

        }



        if ($tempat_lahir == '') {
            $pesan = $pesan.'-Place of Birth Must be filled\\n';
            $validasi = 1;
        }

        if ($tgl_lahir == '') {
            $pesan = $pesan.'-Date of Birth Must be filled in\\n';
            $validasi = 1;
        }

        if ($_FILES["foto_ktp"]["size"] == 0) {
         $pesan = $pesan.'-ID card size is not appropriate\\n';
         $validasi = 1;
     }

     if ($alamat_tinggal == '') {
        $pesan = $pesan.'-Address Must be filled in\\n';
        $validasi = 1;
    }

    if ($kecamatan == '') {
        $pesan = $pesan.'-District Must be filled\\n';
        $validasi = 1;
    }

    if ($kota == '') {
        $pesan = $pesan.'-City must be filled\\n';
        $validasi = 1;
    }

    if ($pengalaman == '') {
        $pesan = $pesan.'-Experience must be filled\\n';
        $validasi = 1;
    }

    if ($area_kerja == '0') {
        $pesan = $pesan.'-Work area Must be filled in\\n';
        $validasi = 1;
    }

    if ($pekerjaan_terakhir == '') {
        $pesan = $pesan.'-Last job Must be filled\\n';
        $validasi = 1;
    }

    if ($telepon_keluarga == '') {
        $pesan = $pesan.'-family phone must be filled\\n';
        $validasi = 1;
    }

    if (strlen($telepon_keluarga) > 12) {
        $pesan = $pesan.'-Phone is invalid\\n';
        $validasi = 1;
    }

    if($telepon_keluarga != ''){
        $data_telepon = $this->m_upload-> select_get_jumlah_where('pendaftaran_mmassage' , array('nama_telepon_keluarga' => $telepon_keluarga));
        if($data_telepon != 0){
            $pesan = $pesan.'-family phone number is registered, please change your family telephone number\\n';
            $validasi = 1;
        }

    }

        // if ($jenis_pijat == '') {
        //     $pesan = $pesan.'-jenis pijat harus diisi \\n';
        //     $validasi = 1;
        // }

    $allowed =  array('gif','png' ,'jpg' ,'JPG', 'PNG');

    $nama_ktp = $_FILES['foto_ktp']['name'];
    $ext_ktp = pathinfo($nama_ktp, PATHINFO_EXTENSION);

    if ($_FILES['foto_ktp']['name'] == '') {
        $pesan = $pesan.'-ID cards cannot be empty\\n';
        $validasi = 1;
    }

    elseif($_FILES['foto_ktp']['name'] != ''){
        if(!in_array($ext_ktp,$allowed)){
            $pesan = $pesan.'-Your ID card is not suitable / incompatible! Please check again\\n';
            $validasi = 1;
        }
        elseif($_FILES['foto_ktp']['name'] != '' && $_FILES["foto_ktp"]["size"] > 1000000){
            $pesan = $pesan.'-Foto KTP Anda terlalu besar\\n';
            $validasi = 1;
        }   
    }
    $nama_diri = $_FILES['foto_diri']['name'];
    $ext_diri = pathinfo($nama_diri, PATHINFO_EXTENSION);

    if ($_FILES['foto_diri']['name'] == '') {
        $pesan = $pesan.'-photo profile cannot be empty\\n';
        $validasi = 1;
    }

    elseif($_FILES['foto_diri']['name'] != ''){
        if(!in_array($ext_diri,$allowed)){
            $pesan = $pesan.'-photo profile is not suitable / incompatible! Please check again\\n';
            $validasi = 1;
        }
        elseif($_FILES["foto_diri"]["size"] > 1000000){
            $pesan = $pesan.'-Photo profile are too big\\n';
            $validasi = 1;
        }
    }

    if($validasi == 1){
            // print_r($pesan);
        echo "<script>
        alert('Sorry, there is a term for filling out the Form:\\n".$pesan."');
        window.history.go(-1);
        </script>";
    }

    elseif($validasi == 0){
        $jenis_pijat = $this->input->post('jenis_pijat');
        $jumlah_jenis = count($jenis_pijat);
        $tampung_jenis = '';
        for($i=0; $i < $jumlah_jenis; $i++){
            if($i == 0){
                $tampung_jenis = $_POST['jenis_pijat'][$i];
            }
            if($i != 0){
                $tampung_jenis = $tampung_jenis.','.$_POST['jenis_pijat'][$i];
            }
        }

            // print_r($jenis_pijat);
            // print_r($tampung_jenis);

        $data_insert = array('nama_lengkap' => $nama_lengkap,
         'nomor_telepon' => $no_hp,
         'email' => $email,
         'tanggal_lahir' => $tgl_lahir,
         'jenis_kelamin' => $jk,
         'nomor_ktp'    => $no_ktp,
         'tempat_lahir' => $tempat_lahir,
         'alamat_tinggal' => $alamat_tinggal,
         'kecamatan' => $kecamatan,
         'kota' => $kota,
         'pengalaman_pijat' => $pengalaman,
         'keahlian_pijat' => $tampung_jenis,
         'area_kerja' => $area_kerja,
         'pekerjaan_terakhir' => $pekerjaan_terakhir,
         'nama_telepon_keluarga' =>$telepon_keluarga,
         'foto_ktp' => '',
         'foto_diri' => '',
         'job'      => $job,
         'is_valid' => 0
     );
        $insert_lamaran = $this->m_upload->insert('pendaftaran_mmassage', $data_insert);

        if($insert_lamaran){
            $data_berkas = $this->m_upload->select_table_order_limit('*','pendaftaran_mmassage' , 'nomor' , 1);
            $data_foto = array('foto_ktp' => 'ktp_'.$data_berkas[0]['nomor'].".".$ext_ktp,
               'foto_diri' => 'diri_'.$data_berkas[0]['nomor'].".".$ext_diri);
            $insert_foto = $this->m_upload->update('nomor', $data_berkas[0]['nomor'], 'pendaftaran_mmassage', $data_foto);

            if($insert_foto){

                $pathfilesavektp = './upload/berkas_mmassage/foto_ktp/';
                $pathfilesaveprofil = './upload/berkas_mmassage/foto_diri/';

                $config['upload_path']          = $pathfilesavektp;
                $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                $config['file_name']            = 'ktp_'.$data_berkas[0]['nomor'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('foto_ktp');

                $diri['upload_path']          = $pathfilesaveprofil;
                $diri['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                $diri['file_name']          = 'diri_'.$data_berkas[0]['nomor'];
                $this->load->library('upload', $diri);
                $this->upload->initialize($diri);
                $this->upload->do_upload('foto_diri');


                $this->session->set_userdata('form_isi', 1);
                redirect($this->input->post('redirect'));
            }

        }

    }
}


public function upload_mservice(){
    $validasi = 0;

    $nama_lengkap   = $this->input->post('nama_lengkap');
    $no_ktp         = $this->input->post('no_ktp');
    $no_telepon     = $this->input->post('no_telepon');
    $email          = $this->input->post('email');
    $alamat         = $this->input->post('alamat');
    $kecamatan      = $this->input->post('kecamatan');
    $kota           = $this->input->post('kota');
    $tempat_lahir   = $this->input->post('tempat_lahir');
    $tgl_lahir      = $this->input->post('tgl_lahir');
    $peralatan      = $this->input->post('peralatan');
    $keahlian       = $this->input->post('keahlian');
    $area_kerja     = $this->input->post('area_kerja');
    $job            = $this->input->post('job');

    $pesan = "";

    if ($nama_lengkap == '') {
        $pesan = '-name cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_lengkap)) {

        $pesan = $pesan.'-invalid name\\n';
        $validasi = 1;
    }

    if($no_ktp != ''){
        $data_ktp = $this->m_upload-> select_get_jumlah_where('pendaftaran_acservice' , array('nomor_ktp' => $no_ktp));
        if($data_ktp != 0){
            $pesan = $pesan.'-ID card is registered\\n';
            $validasi = 1;
        }

    }

    if ($no_ktp == '') {
        $pesan = $pesan.'-ID number must be filled in\\n';
        $validasi = 1;
    }

    if ($_FILES["foto_ktp"]["size"] == 0) {
     $pesan = $pesan.'-ID card size is not appropriate\\n';
     $validasi = 1;
 }

 if ($no_telepon == '') {
    $pesan = $pesan.'-phone must be filled in \\n';
    $validasi = 1;
}


if($no_telepon != ''){
    $data_telepon = $this->m_upload->select_get_no_telp_where(array('no_telepon' => $no_telepon), array('nomor_telepon' => $no_telepon),                   array('nomor_telepon' => $no_telepon));
    if($data_telepon){
        $pesan = $pesan.'-phone number is registered, please change your phone number\\n';
        $validasi = 1;
    }

}

if (strlen($no_telepon) > 15) {
    $pesan = $pesan.'-Phone is invalid\\n';
    $validasi = 1;
}

if ($email == '') {
    $pesan = $pesan.'-email cannot be empty\\n';
    $validasi = 1;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $pesan = $pesan.'-Invalid e-mail address\\n';
    $validasi = 1;
}

if($email != ''){
    $data_email = $this->m_upload-> select_get_jumlah_where('pendaftaran_acservice' , array('email' => $email));
    if($data_email != 0){
        $pesan = $pesan.'-Email is registered, please change your email\\n';
        $validasi = 1;
    }

}

if ($alamat == '') {
    $pesan = $pesan.'-Address Must be filled in\\n';
    $validasi = 1;
}

if ($kecamatan == '') {
    $pesan = $pesan.'-District Must be filled\\n';
    $validasi = 1;
}

if ($kota == '') {
    $pesan = $pesan.'-City must be filled\\n';
    $validasi = 1;
}




if ($tempat_lahir == '') {
    $pesan = $pesan.'-Place of Birth Must be filled\\n';
    $validasi = 1;
}

if ($tgl_lahir == '') {
    $pesan = $pesan.'-Date of Birth Must be filled in\\n';
    $validasi = 1;
}


if ($peralatan == '') {
    $pesan = $pesan.'-Equipment Must be filled in at least 1\\n';
    $validasi = 1;
}

if ($keahlian == '') {
    $pesan = $pesan.'-expertise Must be filled in at least 1\\n';
    $validasi = 1;
}

if ($area_kerja == '0') {
    $pesan = $pesan.'-Work area Must be filled in\\n';
    $validasi = 1;
}

$allowed =  array('gif','png' ,'jpg' ,'jpeg' ,'GIF' , 'PNG' , 'JPG' , 'JPEG');
$nama_ktp = $_FILES['foto_ktp']['name'];
$ext_ktp = pathinfo($nama_ktp, PATHINFO_EXTENSION);

if(!in_array($ext_ktp,$allowed)){
    $pesan = $pesan.'-Your file is not suitable / incompatible! Please check again';
    $validasi = 1;
} $allowed =  array('gif','png' ,'jpg' ,'JPG', 'PNG');

$nama_ktp = $_FILES['foto_ktp']['name'];
$ext_ktp = pathinfo($nama_ktp, PATHINFO_EXTENSION);

if ($_FILES['foto_ktp']['name'] == '') {
    $pesan = $pesan.'-Foto KTP tidak boleh kosong\\n';
    $validasi = 1;
}

elseif($_FILES['foto_ktp']['name'] != ''){
    if(!in_array($ext_ktp,$allowed)){
        $pesan = $pesan.'-Your ID card is not suitable / incompatible! Please check again\\n';
        $validasi = 1;
    }
    elseif($_FILES['foto_ktp']['name'] != '' && $_FILES["foto_ktp"]["size"] > 1000000){
        $pesan = $pesan.'-Your ID card is too large\\n';
        $validasi = 1;
    }   
}
$nama_diri = $_FILES['foto_diri']['name'];
$ext_diri = pathinfo($nama_diri, PATHINFO_EXTENSION);

if ($_FILES['foto_diri']['name'] == '') {
    $pesan = $pesan.'-photo profile cannot be empty\\n';
    $validasi = 1;
}

elseif($_FILES['foto_diri']['name'] != ''){
    if(!in_array($ext_diri,$allowed)){
        $pesan = $pesan.'-Your photo is not suitable / incompatible! Please check again\\n';
        $validasi = 1;
    }
    elseif($_FILES["foto_diri"]["size"] > 1000000){
        $pesan = $pesan.'-Photo profile are too big\\n';
        $validasi = 1;
    }
}

if($validasi == 1){
            // print_r($pesan);
    echo "<script>
    alert('Sorry, there was an error filling out the Form :\\n".$pesan."');
    window.history.go(-1);
    </script>";
}

elseif($validasi == 0){
    $peralatan = $this->input->post('peralatan');
    $jumlah_jenis = count($peralatan);
    $tampung_peralatan = '';
    for($i=0; $i < $jumlah_jenis; $i++){
        if($i == 0){
            $tampung_peralatan = $peralatan[$i];
        }
        else{
            $tampung_peralatan = $tampung_peralatan.','.$peralatan[$i];
        }
    }
    $keahlian = $this->input->post('keahlian');
    $jumlah_keahlian = count($keahlian);
    $tampung_keahlian = '';
    for($i=0; $i < $jumlah_keahlian; $i++){
        if($i == 0){
            $tampung_keahlian = $keahlian[$i];
        }
        else{
            $tampung_keahlian = $tampung_keahlian.','.$keahlian[$i];
        }

    }

    $data_insert = array( 'nama_lengkap' => $nama_lengkap,
      'nomor_ktp'    => $no_ktp,
      'nomor_telepon'=> $no_telepon,
      'email'        => $email,
      'alamat_tinggal'=> $alamat,
      'kecamatan_tinggal' => $kecamatan,
      'kota_tinggal'      => $kota,
      'tempat_lahir'      => $tempat_lahir,
      'tanggal_lahir' => $tgl_lahir,
      'peralatan'         => $tampung_peralatan,
      'keahlian'          => $tampung_keahlian,
      'area_kerja'        => $area_kerja,
      'foto_ktp' => '',
      'job'     => $job,
      'is_valid' => 0,
      'foto_diri' => ''
  );
    $insert_lamaran = $this->m_upload->insert('pendaftaran_acservice', $data_insert);
    if($insert_lamaran){
        $data_berkas = $this->m_upload->select_table_order_limit('*','pendaftaran_acservice' , 'nomor' , 1);
        $data_foto = array('foto_ktp' => 'ktp_'.$data_berkas[0]['nomor'].".".$ext_ktp,
           'foto_diri' => 'diri_'.$data_berkas[0]['nomor'].".".$ext_diri);
        $insert_foto = $this->m_upload->update('nomor', $data_berkas[0]['nomor'], 'pendaftaran_acservice', $data_foto);
        if($insert_foto){
            $pathfilesavektp = './upload/berkas_mservice/foto_ktp/';
            $pathfilesaveprofil = './upload/berkas_mservice/foto_diri/';
            $config['upload_path']          = $pathfilesavektp;
            $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $config['file_name']            = 'ktp_'.$data_berkas[0]['nomor'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('foto_ktp');

            $diri['upload_path']          = $pathfilesaveprofil;
            $diri['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $diri['file_name']          = 'diri_'.$data_berkas[0]['nomor'];
            $this->load->library('upload', $diri);
            $this->upload->initialize($diri);
            $this->upload->do_upload('foto_diri');


            $this->session->set_userdata('form_isi', 1);
            redirect($this->input->post('redirect'));
        }
    }

}       

}

function upload_mfood(){
    $validasi = 0;
        // echo $this->input->post('email_penanggung_jawab');
        // echo $this->input->post('latitude');

    $nama_pemilik_restoran      = $this->input->post('nama_pemilik_restoran');
    $jenis_identitas            = $this->input->post('jenis_identitas');
    $no_identitas               = $this->input->post('no_identitas');
    $password1                  = $this->input->post('password1');
    $password2                  = $this->input->post('password2');
    $alamat_pemilik             = $this->input->post('alamat_pemilik');
    $kota                       = $this->input->post('kota');
    $nama_penanggung_jawab      = $this->input->post('nama_penanggung_jawab');
    $telepon_penanggung_jawab   = $this->input->post('telepon_penanggung_jawab');
    $email_penanggung_jawab     = $this->input->post('email_penanggung_jawab');

    $nama_restoran              = $this->input->post('nama_restoran');
    $alamat_restoran            = $this->input->post('alamat_restoran');
    $telepon_restoran           = $this->input->post('telepon_restoran');
    $jam_buka                   = $this->input->post('jam_buka');
    $jam_tutup                  = $this->input->post('jam_tutup');
    $kategori                   = $this->input->post('kategori');

    $pesan = "";
    if ($nama_pemilik_restoran == '') {
        $pesan = '-The name cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_pemilik_restoran)) {

        $pesan = $pesan.'-invalid name\\n';
        $validasi = 1;
    }

    if ($jenis_identitas == '') {
        $pesan = '-Fill in the Type of Identity\\n';
        $validasi = 1;
    }

    if($no_identitas != ''){
        $data_identitas = $this->m_upload-> select_get_jumlah_where('mitra_mmart_mfood' , array('nomor_identitas' => $no_identitas));
        if($data_identitas != 0){
            $pesan = $pesan.'-identity has been registered\\n';
            $validasi = 1;
        }

    }

    if ($no_identitas == '') {
        $pesan = $pesan.'-Identity Number Must be filled in\\n';
        $validasi = 1;
    }

    if($password1 != $password2){
        $pesan = $pesan.'-Password is not the same\\n';
        $validasi = 1;
    }

    if ($alamat_pemilik == '') {
        $pesan = $pesan.'-owners address Must be filled in\\n';
        $validasi = 1;
    }

    if ($kota == '') {
        $pesan = $pesan.'-city Must be filled in\\n';
        $validasi = 1;
    }

    if ($nama_penanggung_jawab == '') {
        $pesan = $pesan.'-The name of the person in charge cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_penanggung_jawab)) {

        $pesan = $pesan.'-The name of the person in charge is invalid\\n';
        $validasi = 1;
    }

    if ($telepon_penanggung_jawab == '') {
        $pesan = $pesan.'-phone must be filled in \\n';
        $validasi = 1;
    }

    if (strlen($telepon_penanggung_jawab) > 12) {
        $pesan = $pesan.'-Phone is invalid\\n';
        $validasi = 1;
    }


    if ($email_penanggung_jawab == '') {
        $pesan = $pesan.'-email cannot be empty\\n';
        $validasi = 1;
    }

    if (!filter_var($email_penanggung_jawab, FILTER_VALIDATE_EMAIL)) {
        $pesan = $pesan.'-Invalid e-mail address\\n';
        $validasi = 1;
    }

    if($email_penanggung_jawab != ''){
        $data_email = $this->m_upload-> select_get_jumlah_where('mitra_mmart_mfood' , array('email_penanggung_jawab' => $email_penanggung_jawab));
        if($data_email != 0){
            $pesan = $pesan.'-Email is registered, please change your email\\n';
            $validasi = 1;
        }

    }

    if ($nama_restoran == '') {
        $pesan = $pesan.'-Restaurant names cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_restoran)) {

        $pesan = $pesan.'-restaurant name is invalid\\n';
        $validasi = 1;
    }

    if ($alamat_restoran == '') {
        $pesan = $pesan.'-restaurant address Must be filled in\\n';
        $validasi = 1;
    }

    if ($telepon_restoran == '') {
        $pesan = $pesan.'-phone must be filled in \\n';
        $validasi = 1;
    }

    if($telepon_restoran != ''){
        $data_telepon = $this->m_upload-> select_get_jumlah_where('restoran' , array('kontak_telepon' => $telepon_restoran));
        if($data_telepon != 0){
            $pesan = $pesan.'-the restaurant telephone number is registered, please change your telephone number\\n';
            $validasi = 1;
        }

    }

    if (strlen($telepon_restoran) > 12) {
        $pesan = $pesan.'-Phone is invalid\\n';
        $validasi = 1;
    }

    if ($jam_buka == '') {
        $pesan = $pesan.'-opening cannot be empty\\n';
        $validasi = 1;
    }

    if ($jam_tutup == '') {
        $pesan = $pesan.'-closing cannot be empty\\n';
        $validasi = 1;
    }

    if ($kategori == '') {
        $pesan = $pesan.'-Restaurant categories cannot be empty\\n';
        $validasi = 1;
    }

//     if ($_FILES["foto_restoran"]["size"] == 0) {
//      $pesan = $pesan.'-The size of the restaurant photo is not appropriate\\n';
//      $validasi = 1;
//  }

//  $allowed =  array('gif','png' ,'jpg' ,'jpeg' ,'GIF' , 'PNG' , 'JPG' , 'JPEG');
//  $foto_restoran = $_FILES['foto_restoran']['name'];
//  $ext_foto = pathinfo($foto_restoran, PATHINFO_EXTENSION);

//  if(!in_array($ext_foto,$allowed)){
//     $pesan = $pesan.'-Your file is not suitable / incompatible! Please check again';
//     $validasi = 1;
// }

if($validasi == 1){
            // print_r($pesan);
    echo "<script>
    alert('Sorry, there was an error filling out the Form :\\n".$pesan."');
    window.history.go(-1);
    </script>";
}

elseif($validasi == 0){
    $deskripsi_resto    = $this->input->post('deskripsi_resto');
    $latitude           = $this->input->post('latitude');
    $longitude          = $this->input->post('longitude');
    $jenis_lapak        = $this->input->post('jenis_lapak');

    $data_insert = array('nama_resto'       => $nama_restoran,
     'alamat'           => $alamat_restoran,
     'latitude'         => $latitude,
     'longitude'        => $longitude,
     'jam_buka'         => $jam_buka,
     'jam_tutup'        => $jam_tutup,
     'deskripsi_resto'  => $deskripsi_resto,
     'kategori_resto'   => $kategori,
     'foto_resto'       => '',
     'kontak_telepon'   => $telepon_restoran
 );

    $insert_restoran = $this->m_upload->insert('restoran', $data_insert);
    if($insert_restoran){
        $data_restoran = $this->m_upload->select_table_order_limit('*','restoran' , 'id' , 1);
        $nama_foto = array('foto_resto' => 'resto_'.$data_restoran[0]['id'].".".$ext_foto);
        $insert_nama_foto = $this->m_upload->update('id', $data_restoran[0]['id'], 'restoran', $nama_foto);
        if($insert_nama_foto){
            $pathfilesaveresto = './upload/berkas_mmart_mfood/foto_restoran/';
            $config['upload_path']          = $pathfilesaveresto;
            $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $config['file_name']            = 'resto_'.$data_restoran[0]['id'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('foto_restoran');

            $data_pelapak = array(
                'nama_pemilik'              => $nama_pemilik_restoran,
                'jenis_identitas'           => $jenis_identitas,
                'nomor_identitas'           => $no_identitas,
                'alamat_pemilik'            => $alamat_pemilik,
                'kota'                      => $kota,
                'nama_penanggung_jawab'     => $nama_penanggung_jawab,
                'email_penanggung_jawab'    => $email_penanggung_jawab,
                'password'                  => md5($password1),
                'telepon_penanggung_jawab'  => $telepon_penanggung_jawab,
                'jenis_lapak'               => $jenis_lapak,
                'lapak'                     => $data_restoran[0]['id'],
                'is_valid' => 0
            );

            $insert_pelapak = $this->m_upload->insert('mitra_mmart_mfood', $data_pelapak);
            $this->session->set_userdata('form_isi', 1);
            redirect($this->input->post('redirect'));
        }
    }

}
}


function upload_mmart(){
    $validasi = 0;
        // echo $this->input->post('email_penanggung_jawab');
        // echo $this->input->post('latitude');

    $nama_pemilik_toko          = $this->input->post('nama_pemilik_toko');
    $jenis_identitas            = $this->input->post('jenis_identitas');
    $no_identitas               = $this->input->post('no_identitas');
    $password1                  = $this->input->post('password1');
    $password2                  = $this->input->post('password2');
    $alamat_pemilik             = $this->input->post('alamat_pemilik');
    $kota                       = $this->input->post('kota');
    $nama_penanggung_jawab      = $this->input->post('nama_penanggung_jawab');
    $telepon_penanggung_jawab   = $this->input->post('telepon_penanggung_jawab');
    $email_penanggung_jawab     = $this->input->post('email_penanggung_jawab');

    $nama_toko                  = $this->input->post('nama_toko');
    $alamat_toko                = $this->input->post('alamat_toko');
    $telepon_toko               = $this->input->post('telepon_toko');
    $jam_buka                   = $this->input->post('jam_buka');
    $jam_tutup                  = $this->input->post('jam_tutup');
    $kategori                   = $this->input->post('kategori');

    $pesan = "";
    if ($nama_pemilik_toko == '') {
        $pesan = '-name cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_pemilik_toko)) {

        $pesan = $pesan.'-invalid name\\n';
        $validasi = 1;
    }

    if ($jenis_identitas == '') {
        $pesan = '-Fill in the Type of Identity\\n';
        $validasi = 1;
    }

    if($no_identitas != ''){
        $data_identitas = $this->m_upload-> select_get_jumlah_where('mitra_mmart_mfood' , array('nomor_identitas' => $no_identitas));
        if($data_identitas != 0){
            $pesan = $pesan.'-identity has been registered\\n';
            $validasi = 1;
        }

    }

    if ($no_identitas == '') {
        $pesan = $pesan.'-Identity Number Must be filled in\\n';
        $validasi = 1;
    }

    if($password1 != $password2){
        $pesan = $pesan.'-password not match\\n';
        $validasi = 1;
    }

    if ($alamat_pemilik == '') {
        $pesan = $pesan.'-owners address Must be filled in\\n';
        $validasi = 1;
    }

    if ($kota == '') {
        $pesan = $pesan.'-city Must be filled in\\n';
        $validasi = 1;
    }

    if ($nama_penanggung_jawab == '') {
        $pesan = $pesan.'-name of the person in charge cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_penanggung_jawab)) {

        $pesan = $pesan.'-name of the person in charge is invalid\\n';
        $validasi = 1;
    }

    if ($telepon_penanggung_jawab == '') {
        $pesan = $pesan.'-phone must be filled in \\n';
        $validasi = 1;
    }

    if (strlen($telepon_penanggung_jawab) > 12) {
        $pesan = $pesan.'-Phone is invalid\\n';
        $validasi = 1;
    }

    if ($email_penanggung_jawab == '') {
        $pesan = $pesan.'-email cannot be empty\\n';
        $validasi = 1;
    }

    if (!filter_var($email_penanggung_jawab, FILTER_VALIDATE_EMAIL)) {
        $pesan = $pesan.'-Invalid e-mail address\\n';
        $validasi = 1;
    }

    if($email_penanggung_jawab != ''){
        $data_email = $this->m_upload-> select_get_jumlah_where('mitra_mmart_mfood' , array('email_penanggung_jawab' => $email_penanggung_jawab));
        if($data_email != 0){
            $pesan = $pesan.'-Email is registered, please change your email\\n';
            $validasi = 1;
        }

    }

    if ($nama_toko == '') {
        $pesan = $pesan.'-Store name cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama_toko)) {

        $pesan = $pesan.'-invalid store name\\n';
        $validasi = 1;
    }

    if ($alamat_toko == '') {
        $pesan = $pesan.'-Store address Must be filled in\\n';
        $validasi = 1;
    }

    if ($telepon_toko == '') {
        $pesan = $pesan.'-phone must be filled in \\n';
        $validasi = 1;
    }

    if (strlen($telepon_toko) > 12) {
        $pesan = $pesan.'-Phone is invalid\\n';
        $validasi = 1;
    }

    if($telepon_toko != ''){
        $data_telepon = $this->m_upload-> select_get_jumlah_where('toko' , array('kontak_telepon' => $telepon_toko));
        if($data_telepon != 0){
            $pesan = $pesan.'-telephone number of the shop is registered, please change your telephone number\\n';
            $validasi = 1;
        }

    }

    if ($jam_buka == '') {
        $pesan = $pesan.'-opening cannot be empty\\n';
        $validasi = 1;
    }

    if ($jam_tutup == '') {
        $pesan = $pesan.'-closing cannot be empty\\n';
        $validasi = 1;
    }

    if ($kategori == '') {
        $pesan = $pesan.'-Store category cannot be empty\\n';
        $validasi = 1;
    }

//     if ($_FILES["foto_toko"]["size"] == 0) {
//      $pesan = $pesan.'-The size of the shop photo does not match\\n';
//      $validasi = 1;
//  }

//  $allowed =  array('gif','png' ,'jpg' ,'jpeg' ,'GIF' , 'PNG' , 'JPG' , 'JPEG');
//  $foto_toko = $_FILES['foto_toko']['name'];
//  $ext_foto = pathinfo($foto_toko, PATHINFO_EXTENSION);

//  if(!in_array($ext_foto,$allowed)){
//     $pesan = $pesan.'-Your file is not suitable / incompatible! Please check again';
//     $validasi = 1;
// }

if($validasi == 1){
            // print_r($pesan);
    echo "<script>
    alert('Sorry, there was an error filling out the Form :\\n".$pesan."');
    window.history.go(-1);
    </script>";
}

elseif($validasi == 0){
    $deskripsi_toko     = $this->input->post('deskripsi_toko');
    $latitude           = $this->input->post('latitude');
    $longitude          = $this->input->post('longitude');
    $jenis_lapak        = $this->input->post('jenis_lapak');

    $data_insert = array('nama_toko'        => $nama_toko,
     'alamat'           => $alamat_toko,
     'latitude'         => $latitude,
     'longitude'        => $longitude,
     'deskripsi'        => $deskripsi_toko,
     'jam_buka'         => $jam_buka,
     'jam_tutup'        => $jam_tutup,
     'kategori_toko'    => $kategori,
     'kontak_telepon'   => $telepon_toko,
     'foto_toko'        => ''

 );

    $insert_toko = $this->m_upload->insert('toko', $data_insert);
    if($insert_toko){
        $data_toko = $this->m_upload->select_table_order_limit('*','toko' , 'id' , 1);
        $nama_foto = array('foto_toko' => 'toko_'.$data_toko[0]['id'].".".$ext_foto);
        $insert_nama_foto = $this->m_upload->update('id', $data_toko[0]['id'], 'toko', $nama_foto);
        if($insert_nama_foto){
            $config['upload_path']          = '.upload/berkas_mmart_mfood/foto_toko/';
            $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
                        // $config['max_size']             = 100;
                        // $config['max_width']            = 1024;
                        // $config['max_height']           = 768;
            $config['file_name']            = 'toko_'.$data_toko[0]['id'];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload('foto_toko');

            $data_pelapak = array(
                'nama_pemilik'              => $nama_pemilik_toko,
                'jenis_identitas'           => $jenis_identitas,
                'nomor_identitas'           => $no_identitas,
                'alamat_pemilik'            => $alamat_pemilik,
                'kota'                      => $kota,
                'nama_penanggung_jawab'     => $nama_penanggung_jawab,
                'email_penanggung_jawab'    => $email_penanggung_jawab,
                'password'                  => md5($password1),
                'telepon_penanggung_jawab'  => $telepon_penanggung_jawab,
                'jenis_lapak'               => $jenis_lapak,
                'lapak'                     => $data_toko[0]['id']
            );

            $insert_pelapak = $this->m_upload->insert('mitra_mmart_mfood', $data_pelapak);
            $this->session->set_userdata('form_isi', 1);
            redirect($this->input->post('redirect'));
        }
    }

}
}

function hubungi_kami(){
    $validasi = 0;
    $nama       = $this->input->post('nama');
    $email      = $this->input->post('email');
    $telepon    = $this->input->post('telepon');
    $subjek     = $this->input->post('subjek');
    $pesan_isi  = $this->input->post('pesan');

    $pesan = "";
    if ($nama == '') {
        $pesan = '-The name cannot be empty\\n';
        $validasi = 1;
    }

    if (!preg_match("/^[a-zA-Z]+(([\'\,\.\- ][a-zA-Z ])?[a-zA-Z]*)*$/",$nama)) {

        $pesan = $pesan.'-invalid name\\n';
        $validasi = 1;
    }
    if ($email == '') {
        $pesan = $pesan.'-email cannot be empty\\n';
        $validasi = 1;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pesan = $pesan.'-Invalid e-mail address\\n';
        $validasi = 1;
    }

    if ($telepon == '') {
        $pesan = $pesan.'-phone must be filled in \\n';
        $validasi = 1;
    }

    if (strlen($telepon) > 12) {
        $pesan = $pesan.'-Phone is invalid\\n';
        $validasi = 1;
    }
    if ($subjek == '') {
        $pesan = $pesan.'-The subject must be filled \\n';
        $validasi = 1;
    }
    if ($pesan_isi == '') {
        $pesan = $pesan.'-the message must be filled \\n';
        $validasi = 1;
    }

    if($validasi == 1){
            // print_r($pesan);
        echo "<script>
        alert('Maaf, ada kesalahan pengisian Formulir :\\n".$pesan."');
        window.history.go(-1);
        </script>";
    }

    elseif($validasi == 0){
        $data_insert = array(
         'nama'         => $nama,
         'email'        => $email,
         'telepon'      => $telepon,
         'subjek'       => $subjek,
         'isi_bantuan'  => $pesan_isi
     );

        $insert_help = $this->m_upload->insert('help_general', $data_insert);
        $this->session->set_userdata('hubungi_isi', 1);
        redirect($this->input->post('redirect'));



    }

}
}
