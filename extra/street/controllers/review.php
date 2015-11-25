<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    

class Review extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
		$this->load->model('company_model');
        
    }

    public function index() {
		$data['suman'] = array();
        $this->load->view('users/company', $data);
        
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */