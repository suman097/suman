<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends CI_Controller {

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

    public function index() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['country'] = $this->company_model->viewCountry();
        if (!$this->input->post()) {
            $this->load->view('admin/company/add_company', $data);
        } else {

            $name = $this->input->post('name');
            $country = $this->input->post('country');
            $details = $this->input->post('details');
            $status = $this->input->post('status');

            $create = array(
                'company_name' => $name,
                'company_description' => $details,
                'company_country' => $country,
                'status' => $status,
                'is_deleted' => "1"
            );
            if ($_FILES['logo_image']['name'] != "") {
                if (!is_dir(FCPATH . '/images/company')) {
                    mkdir(FCPATH . '/images/company');
                }

                $config['upload_path'] = 'images/company/'; // Location to save the image
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                $config['max_size'] = '10000'; // in KB
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('logo_image')) {

                    $config2['image_library'] = 'gd2';
                    $config2['source_image'] = 'images/company/' . $this->upload->file_name;
                    $config2['create_thumb'] = false;
                    $config2['maintain_ratio'] = TRUE;
                    $config2['master_dim'] = 'width';
                    $config2['width'] = 150; // image re-size  properties
                    $config2['height'] = 150; // image re-size  properties 
                    $config2['new_image'] = 'images/company/thumb' . $this->upload->file_name; // image re-size  properties 
                    $this->load->library('image_lib', $config2); //codeigniter default function
                    $this->image_lib->resize();
                    $create['company_logo'] = $this->upload->file_name;
                    $this->upload->do_upload('banner_image');
                    $create['company_banner'] = $this->upload->file_name;
                } else {
                    $data['company_logo'] = $this->upload->display_errors();
                    redirect("company");
                }
            }
            $result = $this->db->insert('company', $create);
            redirect("company");
        }
    }
    
    public function editCompany($eid) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['country'] = $this->company_model->viewCountry();
        $data['details'] = $this->company_model->viewCompanyDetails($eid);
        //print_r($data['details']); die;
        if (!$this->input->post()) {
            $this->load->view('admin/company/edit_company', $data);
        } else {

            $name = $this->input->post('name');
            $country = $this->input->post('country');
            $details = $this->input->post('details');
            $status = $this->input->post('status');
            $hid = $this->input->post('hidden_id');
            $update = array(
                'company_name' => $name,
                'company_description' => $details,
                'company_country' => $country,
                'status' => $status,
            );
            if ($_FILES['logo_image']['name'] != "") {
                if (!is_dir(FCPATH . '/images/company')) {
                    mkdir(FCPATH . '/images/company');
                }

                $config['upload_path'] = 'images/company/'; // Location to save the image
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                $config['max_size'] = '10000'; // in KB
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('logo_image')) {

                    $config2['image_library'] = 'gd2';
                    $config2['source_image'] = 'images/company/' . $this->upload->file_name;
                    $config2['create_thumb'] = false;
                    $config2['maintain_ratio'] = TRUE;
                    $config2['master_dim'] = 'width';
                    $config2['width'] = 150; // image re-size  properties
                    $config2['height'] = 150; // image re-size  properties 
                    $config2['new_image'] = 'images/company/thumb' . $this->upload->file_name; // image re-size  properties 
                    $this->load->library('image_lib', $config2); //codeigniter default function
                    $this->image_lib->resize();
                    $update['company_logo'] = $this->upload->file_name;
                    $this->upload->do_upload('banner_image');
                    $update['company_banner'] = $this->upload->file_name;
                } else {
                    $data['company_logo'] = $this->upload->display_errors();
                    redirect("company/editCompany/".$hid);
                }
            }
            $this->db->update('company', $update, array('id' => $hid));
            redirect("company/manageCompany");
        }
    }

    public function manageCompany() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['company'] = $this->company_model->showCompanyAdmin();
        $this->load->view('admin/company/view_company', $data);
    }
    
    public function manageUsers() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['users'] = $this->users_model->showUsers();
        $this->load->view('admin/company/view_users', $data);
    }
    
    
    public function popularCompany() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        
        if ($this->input->post()) {
            $recent_popular = $this->company_model->showCompanyPopular();
            foreach($recent_popular as $popular){
                $update_0 = array(
                    'popular' => 0
                );
                $this->db->update('company', $update_0, array('id' => $popular->id));
            }
            $check = $this->input->post('company');
            //print_r($check); die;
            foreach($check as $key_id => $value){
                $update_recent = array(
                    'popular' => 1
                );
                $this->db->update('company', $update_recent, array('id' => $key_id));
            }
        }
        $data['company_count'] = $this->company_model->countCompany();
        $data['company'] = $this->company_model->showCompany();
        $this->load->view('admin/company/popular_company', $data);
    }
    
    public function manageReview() {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['review'] = $this->company_model->showAllReviewOrderCompany();
        foreach($data['review'] as $review){
            $data['review_abuse'][$review->id] = $this->company_model->showAllReviewOrderCompanyAbuse($review->id);
        }
        $this->load->view('admin/company/review_company', $data);
    }
    
    public function abuseDetails($id) {
        $seesion_details = $this->session->userdata('admin');
        $data['users_type'] = $seesion_details->users_type;
        $data['users_nikname'] = $seesion_details->users_nikname;
        $data['abuse'] = $this->company_model->showAllAbuseById($id);
        $this->load->view('admin/company/abuse_company', $data);
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */