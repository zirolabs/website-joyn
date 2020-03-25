<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit","512M");

class C_utama extends CI_Controller {

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
		$this->template->load('layout_regis/template','front/index', array('data' => $data));
		
	}

	// function cobaonepage(){
	// 	$this->template->load('layout_regis/template','regis/cobaonepage');
	// }

	function home(){
		// $data = $this->m_upload->select_table_order_limit('*', 'blog_content', 'tanggal', 2);
		$data = $this->m_upload->select('*', 'blog_content');
		$this->template->load('layout_regis/template','front/index', array('data' => $data));
	}



	function join(){
		$this->template->load('layout_regis/template','regis/regis_joyn');
		
	}
	
	function blog(){
		$this->template->load('layout_regis/template','regis/blog');
		
	}
	
	function kebijakanPrivasi(){
		$this->template->load('layout_regis/template','regis/kebijakan_privasi');
		
	}
	
	function syaratKetentuan(){
		$this->template->load('layout_regis/template','regis/syarat_dan_ketentuan');
		
	}
	
	function forgot_password(){
		$this->template->load('layout_regis/template','regis/pengguna');
	}





	// function tesfitur(){
	// 	$this->template->load('layout_regis/template','regis/tesfitur', array('error' => ' ' ));
	// }


	function j_ride(){
	
		$this->template->load('layout_regis/template','regis/j_ride', array('form' => 0 ));
	}

	function j_car(){
	
		$this->template->load('layout_regis/template','regis/j_car', array('error' => ' ' ));
	}

	function j_pick(){
		$jenis = $this->m_upload->select_where('*' , 'jenis_kendaraan', 'id >', '2');
		$this->template->load('layout_regis/template','regis/j_pick', array('jenis' => $jenis));
	}
	function j_food(){
		$jenis = $this->m_upload->select('*' , 'kategori_resto');
		$this->template->load('layout_regis/template','regis/j_food', array('jenis' => $jenis ));
	}
	function j_mangfood_personal(){
		$this->template->load('layout_regis/template','regis/j_food_personal', array('error' => ' ' ));
	}
	function j_food_company(){
		$this->template->load('layout_regis/template','regis/j_food_company', array('error' => ' ' ));
	}

	function j_service(){
		$keahlian = $this->m_upload->select('*', 'mservice_jenis');
		$jenis = $this->m_upload->select('*' , 'peralatan_service');
		$area = $this->m_upload->select('*', 'cabang_perusahaan');
		$this->template->load('layout_regis/template','regis/j_service', array('jenis' => $jenis, 'area'=> $area, 'keahlian'=>$keahlian ));
	}

	function j_massage(){
		$area = $this->m_upload->select('*', 'cabang_perusahaan');
		$jenis = $this->m_upload->select('*' , 'layanan_pijat');
		$this->template->load('layout_regis/template','regis/j_massage', array('jenis' => $jenis, 'area' => $area ));
	}

	function j_mart(){
		$jenis = $this->m_upload->select('*' , 'kategori_toko');
		$this->template->load('layout_regis/template','regis/j_mart', array('jenis' => $jenis ));
	}
	
	function hubungi_kami(){
		$this->template->load('layout_regis/template','regis/hubungi_kami');
	}

	function faq(){
		$this->template->load('layout_regis/template','regis/faq');
	}
	
	function faq_app(){
		$this->template->load('layout_regis/template','regis/faq_app');
	}
	
	
	
	function kebijakanprivasiapp(){
		$this->template->load('layout_regis/template','regis/kebijakan_privasi_app');
		
	}
	
	
	
	function syaratKetentuanapp(){
		$this->template->load('layout_regis/template','regis/syarat_dan_ketentuan_app');
		
	}
}
