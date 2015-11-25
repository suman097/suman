<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Image extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('company_model');
        if (!$this->session->userdata('admin')) {
            redirect('login');
        }
    }

    
    public function index($eid = 1) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['details'] = $this->company_model->viewBannerDetails($eid);
        if (!$this->input->post()) {
            $this->load->view('admin/settings/edit_banner', $data);
        } else {
            //print_r("suman"); die;
            $hid = $eid;
            $update['banner_text'] = $this->input->post('details');
            $this->db->update('banner', $update, array('id' => $hid));
            redirect("image/index");
        }
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */