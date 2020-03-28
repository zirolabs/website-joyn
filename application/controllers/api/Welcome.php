<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Public_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
//        $this->load->model('driver_model');
//        $this->load->library('ion_auth');
    }

    public function index() {
//        $this->db->select('*');
//        $post = $this->db->get('content_translations');
//        $this->data['post'] = $post;
//        $this->render('public/page_view');
        echo 'API - Server GOEKS';
    }

}
