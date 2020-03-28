<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","512M");

class C_utama extends MX_Controller {

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



	function join(){
		$this->template->load('layout/template','front/regis_joyn');
		
	}
	
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
	
		$this->template->load('layout/template','front/j_ride', array('form' => 0 ));
	}

	function j_car(){
	
		$this->template->load('layout/template','front/j_car', array('error' => ' ' ));
	}

	function j_box(){
		$jenis = $this->m_upload->select_where('*' , 'jenis_kendaraan', 'id >', '2');
		$this->template->load('layout/template','front/j_box', array('jenis' => $jenis));
	}
	function j_food(){
		$jenis = $this->m_upload->select('*' , 'kategori_resto');
		$this->template->load('layout/template','front/j_food', array('jenis' => $jenis ));
	}
	function j_mangfood_personal(){
		$this->template->load('layout/template','front/j_food_personal', array('error' => ' ' ));
	}
	function j_food_company(){
		$this->template->load('layout/template','front/j_food_company', array('error' => ' ' ));
	}

	function j_service(){
		$keahlian = $this->m_upload->select('*', 'mservice_jenis');
		$jenis = $this->m_upload->select('*' , 'peralatan_service');
		$area = $this->m_upload->select('*', 'cabang_perusahaan');
		$this->template->load('layout/template','front/j_service', array('jenis' => $jenis, 'area'=> $area, 'keahlian'=>$keahlian ));
	}

	function j_massage(){
		$area = $this->m_upload->select('*', 'cabang_perusahaan');
		$jenis = $this->m_upload->select('*' , 'layanan_pijat');
		$this->template->load('layout/template','front/j_massage', array('jenis' => $jenis, 'area' => $area ));
	}

	function j_mart(){
		$jenis = $this->m_upload->select('*' , 'kategori_toko');
		$this->template->load('layout/template','front/j_mart', array('jenis' => $jenis ));
	}
	
	function hubungi_kami(){
		$this->template->load('layout/template','front/hubungi_kami');
	}

	function faq(){
		$this->template->load('layout/template','front/faq');
	}
	
	function faq_app(){
		$this->template->load('layout/template','front/faq_app');
	}
	
	
	
	function kebijakanprivasiapp(){
		$this->template->load('layout/template','front/kebijakan_privasi_app');
		
	}
	
	
	
	function syaratKetentuanapp(){
		$this->template->load('layout/template','front/syarat_dan_ketentuan_app');
		
	}
}
