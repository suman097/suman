<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('company_model');
        $this->load->model('notification_model');
        date_default_timezone_set ( 'Asia/Kolkata' );
    }

    public function index() {
        //print_r($_SERVER);die;
        $data['suman'] = array();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['company'] = $this->company_model->viewCompanyLimit();
        $data['popular_company'] = $this->company_model->showCompanyPopular();
        $data['country'] = $this->company_model->viewCountry();
        $data['count_country'] = $this->company_model->viewCountryCount();
        $data['forum'] = $this->company_model->viewForumLimit();
        $data['home_about'] = $this->users_model->getContentPage("home_about");
        $data['details'] = $this->company_model->viewBannerDetails(1);
        foreach ($data['popular_company'] as $comp) {
            $data['company_details'][$comp->id] = $this->company_model->viewCompanyDetails($comp->id);
        }
        //print_r($data['company_details']); die;
        $this->load->view('users/index', $data);
    }

    public function ajaxCheckNikName() {
        $name = $this->input->post('name');
        $space = strpos($name, " ");
        if ($space === false) {
            $result = $this->users_model->checkNikName($name);
            if ($result) {
                echo "exist";
            } else {
                echo "Done";
            }
        } else {
            echo "space";
        }
    }

    public function ajaxCheckIPTrust() {
        $company = $this->input->post('company');
        $ip = $this->input->post('ip');
        $result = $this->company_model->checkIPTrust($company, $ip);
        if ($result) {
            echo "You have already trust this company!";
        } else {
            $create = array(
                'ip' => $ip,
                'company' => $company
            );
            $this->db->insert('trust', $create);
            $trust_result = $this->company_model->countTrust($company);
            $trust = $trust_result[0]->trust + 1;
            $updata = array(
                'trust' => $trust
            );
            $this->db->update('company', $updata, "id = " . $company);
            echo "This company is trust successfully.For see effect please refresh your page.";
        }
    }

    public function ajaxInsertComment() {
        $content = $this->input->post('content');
        $date = date("Y-m-d H:i:s");
        $nik = $this->input->post('nik');
        $create = array(
            'nik' => $nik,
            'content' => $content,
            'date' => $date
        );
        $this->db->insert('forum', $create);
        $forum = $this->company_model->viewForumLimit();
        $html = "";
        if (isset($forum)) {
            $c = 0;
            foreach ($forum as $for) {
                $c++;
                if ($c % 2 != 0) {
                    $html .= '<div class="chat-box-online-left">
			<a href = "' . base_url('home/userProfile') . '/' . $for->nik . '"><img src="' . base_url() . 'images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />';
                    $html .= '-  ' . $for->nik . '</a>
							 <br />
							' . $for->content . '
							 <br>
							 ( <small>' . $for->date . '</small> )
							 </div>
							 <hr class="hr-clas-low" />';
                } else {
                    $html .= '<div class="chat-box-online-right">
			<a href = "' . base_url('home/userProfile') . '/' . $for->nik . '"><img src="' . base_url() . 'images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />';
                    $html .= '-  ' . $for->nik . '</a>
								<br />
								' . $for->content . '
								<br>
								( <small>' . $for->date . '</small> )
								</div>
								<hr class="hr-clas-low" />';
                }
            }
        }
        echo $html;
    }

    public function ajaxRegister() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $country = implode(",",$this->input->post('country'));
        //print_r($country); die;
        $rand_verify = rand(1000000000000, 9999999999999);
        $create = array(
            'users_type' => 2,
            'email' => $email,
            'password' => $password,
            'nikname' => $name,
            'country' => $country,
            'verify' => $rand_verify,
            'status' => 1,
            'is_deleted' => 1
        );
        $this->db->insert('users', $create);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $newdata = (object) array(
                        'logged_in' => TRUE,
                        'logged_id' => $insert_id,
                        'users_type' => 2,
                        'users_nikname' => $name
            );
            $this->session->set_userdata('users', $newdata);
        }
        if (isset($email)) {
            $subject = "Your Register successfully done.";
            $to = $email;
            $message = "
			<HTML>
			<HEAD>
			<TITLE>Your Register successfully done</TITLE>
			</HEAD>
			<BODY>
			<TABLE>
			<TR>
			<TD>
			Hi,
			</TD>
			</TR>
			<TR>
			<TD>
			

                            Your Registration successfully done on <a href = 'www.streetremarks.com'>www.streetremarks.com</a>.
			
			
			<br><br>
			-- 
			-- Thanks and warm regards,<BR>

                        Team <BR>
                        Streetremarks<BR>
                        Comment & Review a company<BR><BR>

                        support@streetremarks.com<BR>
			<BR><BR>
			============
			<BR><BR>
			
			
			IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE
			
			This electronic communication is intended by the sender only for the access
			and use by the addressee and may contain legally privileged and
			confidential information. If you are not the addressee, you are notified
			that any transmission, disclosure, use, access to, storage or photocopying
			of this e-mail and any attachments is strictly prohibited. The legal
			privilege and confidentiality attached to this e-mail and any attachments
			is not waived, lost or destroyed by reason of a mistaken delivery to you.
			If you have received this e-mail and any attachments in error please
			immediately delete it and all copies from your system and notify the sender
			by e-mail.<BR><BR>
			==================
			<BR><BR>
				
			</TD>
			</TR>
			</TABLE>
			";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            // More headers
            $headers .= 'From: streetremarks<www.streetremarks.com>' . "\r\n";

            mail($to, $subject, $message, $headers);
        }
    }

    public function searchCompany() {
        $seesion_details = $this->session->userdata('users');
        $data['country'] = $this->company_model->viewCountry();
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        //$searchdata['country'] = $this->input->post('country');
        $searchdata['country'] = NULL;
        $searchdata['search'] = $this->input->post('search');
        //print_r($searchdata['country']);
        //print_r($searchdata['search']); die;
        $data['search_company'] = $this->company_model->searchCompany($searchdata);
        $data['forum'] = $this->company_model->viewForumLimit();
        if (isset($data['search_company'])) {
            foreach ($data['search_company'] as $com) {
                $data['details_review'][$com->id] = $this->company_model->viewCompanyDetails($com->id);
            }
        }
        $data['company'] = $this->company_model->viewCompanyLimit();
        foreach ($data['company'] as $comp) {
            $data['company_details'][$comp->id] = $this->company_model->viewCompanyDetails($comp->id);
        }
        //print_r($data['details_review']); die;
        $this->load->view('users/search_company', $data);
    }

    public function companyListing($page = NULL) {
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['forum'] = $this->company_model->viewForumLimit();
        if ($page) {
            $paging['start'] = ($page - 1) * 10;
        } else {
            $paging['start'] = 0;
            $page = 1;
        }
        $paging['count'] = 10;
        $data['total_row'] = $this->company_model->countCompany();
        $data['count'] = $paging['count'];
        $data['page'] = $page;
        //print_r($data['total_row']); die;
        $data['search_company'] = $this->company_model->listingCompany($paging);
        if (isset($data['search_company'])) {
            foreach ($data['search_company'] as $com) {
                $data['details_review'][$com->id] = $this->company_model->viewCompanyDetails($com->id);
            }
        }
        $data['company'] = $this->company_model->viewCompanyLimit();
        foreach ($data['company'] as $comp) {
            $data['company_details'][$comp->id] = $this->company_model->viewCompanyDetails($comp->id);
        }
        //print_r($data['details_review']); die;
        $this->load->view('users/listing_company', $data);
    }

    public function loginUsers() {
        //error_reporting(0);
        $logindata['user_name'] = $this->input->post('name');
        $logindata['password'] = md5($this->input->post('password'));
        $recent_page = $this->input->post('hid_page');
        $result = $this->users_model->loginUser($logindata);
        if ($result) {
            if ($result->users_type == '2') {
                $newdata = (object) array(
                            'logged_in' => TRUE,
                            'logged_id' => $result->id,
                            'users_type' => $result->users_type,
                            'users_nikname' => $result->nikname
                );
                $this->session->set_userdata('users', $newdata);
                if ($recent_page != "home") {
                    redirect("home/" . $recent_page."?msg=login successful");
                } else {
                    redirect('home?msg=login successful');
                }
            } else {
                $data['login_error'] = true;
                //echo "<script type = 'text/javascript'>alert('Sign in not success');</script>";
                if ($recent_page != "home") {
                    redirect("home/" . $recent_page."?msg_error=Invalid nickname or password.Click on login tab for signin or forget password");
                } else {
                    redirect('home');
                }
            }
        } else {
            $data['login_error'] = true;
            //echo "<script type = 'text/javascript'>alert('Sign in not success');</script>";
            if ($recent_page != "home") {
                redirect("home/" . $recent_page."?msg_error=Invalid nickname or password.Click on login tab for signin or forget password");
            } else {
                redirect('home?msg_error=Invalid nickname or password.Click on login tab for signin or forget password');
            }
        }
    }

    public function usersLogout() {
        $this->session->unset_userdata('users');
        $this->session->sess_destroy();
        redirect('home');
    }

    public function companyRegister() {
        $data['suman'] = array();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['forum'] = $this->company_model->viewForumLimit();
        $data['country'] = $this->company_model->viewCountry();
        if (!$this->input->post()) {
            $this->load->view('users/company_register', $data);
        } else {
            $this->form_validation->set_rules('company', 'Company Name', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|max_length[200]');
            $this->form_validation->set_message('max_length', 'Max 200 characters only allowed');
            $this->form_validation->set_message('required', '%s can\'t be blank');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('users/company_register', $data);
            } else {
                $name = $this->input->post('company');
                $country = $this->input->post('country');
                $details = $this->input->post('description');
                $weblink = $this->input->post('weblink');
                $city = $this->input->post('city');
                $status = 1;
                $check_company = $this->company_model->checkCompanyExist($name, $country);
                //print_r($check_company); die;
                if ($check_company) {
                    redirect('home/companyDetails/' . $check_company);
                } else {
                    $create = array(
                        'created_by' => $data['logged_id'],
                        'company_name' => $name,
                        'company_description' => $details,
                        'weblink' => $weblink,
                        'company_country' => $country,
                        'company_city' => $city,
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
                            redirect("home/companyRegister");
                        }
                    }
                    $result = $this->db->insert('company', $create);
                    $id = $this->db->insert_id();
                    $company_json = json_encode($this->company_model->showCompanyJson());
                    //include($_SERVER['DOCUMENT_ROOT']."/company.php"); die; 
                    //print_r($company_json); die;
                    $file = fopen($_SERVER['DOCUMENT_ROOT']."/company.php","w+");
                    fwrite($file,$company_json);
                    fclose($file);
                    $emails = $this->company_model->viewMailWithCountry($country);
                    $country_name = $this->company_model->viewCountryName($country);
                    //print_r($_SERVER['DOCUMENT_ROOT'] . '/project/company_sourav/www/application/libraries/phpmailer/PHPMailerAutoload.php'); die;
                    if (!empty($emails)) {
                        foreach ($emails as $email) {
                            if (isset($email)) {
                                $subject = "Notification: A newly registered need your review";
                                $to = $email->email;
                                $message = "
                                            <HTML>
                                            <HEAD>
                                            <TITLE>Notification: A newly registered need your review</TITLE>
                                            </HEAD>
                                            <BODY>
                                            <TABLE>
                                            <TR>
                                            <TD>
                                            Hi,
                                            </TD>
                                            </TR>
                                            <TR>
                                            <TD>
                                            " . $name . "," . $country_name . " just got registered.
                                            " . $data['users_nikname'] . " is calling for reviews. To give your reviews simply <a href = '" . base_url('home/companyDetails') . "/" . $id . "'>click here </a>
                                                
                                            <br><br>
                                            -- Thanks and warm regards,
                                            <br><br>
                                            Team Streetremarks<br>
                                            <a href = 'www.streetremarks.com'>www.streetremarks.com</a><br>
                                            streetremarks<br>
                                            
                                            <BR><BR>
                                            ============
                                            <BR><BR>


                                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                                            This electronic communication is intended by the sender only for the access
                                            and use by the addressee and may contain legally privileged and
                                            confidential information. If you are not the addressee, you are notified
                                            that any transmission, disclosure, use, access to, storage or photocopying
                                            of this e-mail and any attachments is strictly prohibited. The legal
                                            privilege and confidentiality attached to this e-mail and any attachments
                                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                                            If you have received this e-mail and any attachments in error please
                                            immediately delete it and all copies from your system and notify the sender
                                            by e-mail.<BR><BR>
                                            ==================
                                            <BR><BR>

                                            </TD>
                                            </TR>
                                            </TABLE>
                                            ";

                                // Always set content-type when sending HTML email
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                                // More headers
                                $headers .= 'From: streetremarks<www.streetremarks.com>' . "\r\n";

                                mail($to, $subject, $message, $headers);
                            }
                            $create_notification = array(
                                'sender_id' => 0,
                                'receiver_id' => $email->id,
                                'massage' => "A new company register in your interest country zone.Please give a review for it.",
                                'time' => time(),
                                'read_status' => 1,
                                'status' => 1,
                                'is_deleted' => 1
                            );
                            $this->db->insert('notification', $create_notification);
                        }
                    }
                    redirect('home/companyDetails/' . $id);
                }
            }
        }
    }

    public function forgetPassword() {
        $data['forum'] = $this->company_model->viewForumLimit();
        $data['country'] = $this->company_model->viewCountry();
        if (!$this->input->post()) {
            $this->load->view('users/forget_password', $data);
        } else {
            $this->form_validation->set_rules('nikname', 'Nickname', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|max_length[200]');
            $this->form_validation->set_message('max_length', 'Max 200 characters only allowed');
            $this->form_validation->set_message('required', '%s can\'t be blank');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('users/company_register', $data);
            } else {
                $nikname = $this->input->post('nikname');
                $email = $this->input->post('email');
                $user_status = $this->users_model->selectUsersWithEmailNickname($nikname, $email);
                if ($user_status) {
                    //print_r($user_status->status); die;
                    if ($user_status->status == 1) {

                        $first_rand = rand(100, 999);
                        $second_rand = "";
                        for ($k = 0; $k <= 2; $k++) {
                            $asci_number = rand(97, 122);
                            $second_rand .= chr($asci_number);
                        }
                        $third_rand = rand(100, 999);
                        $password = $first_rand . $second_rand . $third_rand;
                        $update = array(
                            'password' => md5($password)
                        );
                        $this->db->update('users', $update, array('id' => $user_status->id));
                        $subject = "Your reset password";
                        $to = $user_status->email;
                        $message = "
                            <HTML>
                            <HEAD>
                            <TITLE>Your reset password</TITLE>
                            </HEAD>
                            <BODY>
                            <TABLE>
                            <TR>
                            <TD>

                            </TD>
                            </TR>
                            <TR>
                            <TD>Hi " . $user_status->nikname . ", Your reset password is " . $password . ".
                            <br><br>
                            <br><br>
                                                -- Thanks and warm regards,
                                                <br><br>
                                                Team Streetremarks<br>
                                                <a href = 'www.streetremarks.com'>www.streetremarks.com</a><br>
                                                streetremarks<br>

                                                <BR><BR>
                            ============
                            <BR><BR>


                            IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                            This electronic communication is intended by the sender only for the access
                            and use by the addressee and may contain legally privileged and
                            confidential information. If you are not the addressee, you are notified
                            that any transmission, disclosure, use, access to, storage or photocopying
                            of this e-mail and any attachments is strictly prohibited. The legal
                            privilege and confidentiality attached to this e-mail and any attachments
                            is not waived, lost or destroyed by reason of a mistaken delivery to you.
                            If you have received this e-mail and any attachments in error please
                            immediately delete it and all copies from your system and notify the sender
                            by e-mail.<BR><BR>
                            ==================
                            <BR><BR>

                            </TD>
                            </TR>
                            </TABLE>
                            ";

                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                        // More headers
                        $headers .= 'From: streetremarks<www.streetremarks.com>' . "\r\n";

                        mail($to, $subject, $message, $headers);
                        redirect('home');
                    } else {
                        redirect('home/forgetPassword?error_msg=you are blocked by admin');
                    }
                } else {
                    redirect('home/forgetPassword?error_msg=your details not match with our database');
                }
            }
        }
    }

    public function companyDetails($id) {
        $data['company_id'] = $id;
        $data['country'] = $this->company_model->viewCountry();
        $seesion_details = $this->session->userdata('users');
        //$data['company'] = $this->company_model->viewCompanyLimit();
        $data['company'] = $this->company_model->showCompanyPopular();
        $data['forum'] = $this->company_model->viewForumLimit();
        foreach ($data['company'] as $comp) {
            $data['company_details'][$comp->id] = $this->company_model->viewCompanyDetails($comp->id);
        }
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        if (!$this->input->post()) {
            $data['details'] = $this->company_model->viewCompanyDetails($id);
            $data['review'] = $this->company_model->viewCompanyReview($id);
            $this->load->view('users/company', $data);
        } else {
            $title = $this->input->post('title');
            $review = $this->input->post('review');
            $id = $this->input->post('hid_id');
            $status = 1;
            $create = array(
                'posted_by' => $data['logged_id'],
                'company' => $id,
                'title' => $title,
                'review' => $review,
                'rating' => $this->input->post('rating_review'),
                'date' => date('Y-m-d'),
                'status' => $status,
                'is_deleted' => "1"
            );
            $result = $this->db->insert('company_review', $create);
            $this->session->unset_userdata('comments');
            $user_mail = $this->company_model->collectUserCommentMail($id, $data['logged_id']);
            //print_r($user_mail);
            //die;
            if (!empty($user_mail)) {
                foreach ($user_mail as $mail_data) {
                    $subject = "Notification: New review and comments";
                    $to = $mail_data->email;
                    $message = "
                        <HTML>
                        <HEAD>
                        <TITLE>Notification: New review and comments</TITLE>
                        </HEAD>
                        <BODY>
                        <TABLE>
                        <TR>
                        <TD>

                        </TD>
                        </TR>
                        <TR>
                        <TD>Hi " . $mail_data->nikname . ", " . $mail_data->company_name . " has new comments.<br>
                             To check please  <a href = '" . base_url('home/companyDetails') . "/" . $id . "'>click here</a>
                        <br><br>
                        <br><br>
                                            -- Thanks and warm regards,
                                            <br><br>
                                            Team Streetremarks<br>
                                            <a href = 'www.streetremarks.com'>www.streetremarks.com</a><br>
                                            streetremarks<br>
                                            
                                            <BR><BR>
                        ============
                        <BR><BR>


                        IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE

                        This electronic communication is intended by the sender only for the access
                        and use by the addressee and may contain legally privileged and
                        confidential information. If you are not the addressee, you are notified
                        that any transmission, disclosure, use, access to, storage or photocopying
                        of this e-mail and any attachments is strictly prohibited. The legal
                        privilege and confidentiality attached to this e-mail and any attachments
                        is not waived, lost or destroyed by reason of a mistaken delivery to you.
                        If you have received this e-mail and any attachments in error please
                        immediately delete it and all copies from your system and notify the sender
                        by e-mail.<BR><BR>
                        ==================
                        <BR><BR>

                        </TD>
                        </TR>
                        </TABLE>
                        ";

                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                    // More headers
                    $headers .= 'From: streetremarks<www.streetremarks.com>' . "\r\n";

                    mail($to, $subject, $message, $headers);
                }
            }
            redirect("home/companyDetails/" . $id);
        }
    }

    public function profile() {
        $data['suman'] = array();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['forum'] = $this->company_model->viewForumLimit();
        $data['country'] = $this->company_model->viewCountry();
        //print_r($seesion_details); die;
        $data['details'] = $this->users_model->viewProfileDetails($seesion_details->logged_id);
        $data['company'] = $this->company_model->companyWithProfile($seesion_details->logged_id);
        if ($data['company']) {
            foreach ($data['company'] as $comp) {
                $data['company_details'][$comp->id] = $this->company_model->viewCompanyDetails($comp->id);
            }
        }

        $data['related_company'] = $this->company_model->showCompanyPopular();
        foreach ($data['related_company'] as $rel_comp) {
            $data['rel_company_details'][$rel_comp->id] = $this->company_model->viewCompanyDetails($rel_comp->id);
        }
        $this->load->view('users/profile', $data);
    }

    public function updateProfileCheck() {
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $update_country = implode(",", $this->input->post('country'));
        $update = array(
            'country' => $update_country
        );
        $this->db->update('users', $update, "id = " . $data['logged_id']);
        redirect('home/profile');
    }
    
    public function ajaxUpdatePassword() {
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $old_password_status = $this->users_model->viewProfileDetails($data['logged_id']);
        if($old_password_status->password != md5($old_password)){
            echo "password not match";
        }else{
            $update = array(
                'password' => md5($new_password)
            );
            $this->db->update('users', $update, "id = " . $data['logged_id']);
            echo "done";
        }
        exit;
    }

    public function updateCompany($edit) {
        $data['suman'] = array();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['forum'] = $this->company_model->viewForumLimit();
        $back_link = ((((($edit - 54) + 49) / 65) - 78) / 99);

        $data['company'] = $this->company_model->viewCompanyDetails($back_link);
        $data['country'] = $this->company_model->viewCountry();
        if ($this->input->post()) {
            $edit = ((((($this->input->post('hid_id') * 99) + 78) * 65) - 49) + 54);
            $this->form_validation->set_rules('company', 'Company Name', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('country', 'Country', 'trim|required|max_length[200]');
            $this->form_validation->set_message('max_length', 'Max 200 characters only allowed');
            $this->form_validation->set_message('required', '%s can\'t be blank');
            $link = ((((($data['company']->id * 99) + 78) * 65) - 49) + 54);
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('users/company_register', $data);
            } else {
                $name = $this->input->post('company');
                $country = $this->input->post('country');
                $details = $this->input->post('description');
                $weblink = $this->input->post('weblink');
                $company_id = $this->input->post('hid_id');
                $status = 1;

                $update = array(
                    'created_by' => $data['logged_id'],
                    'company_name' => $name,
                    'company_description' => $details,
                    'weblink' => $weblink,
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
                        redirect("home/updateCompany/" . $edit);
                    }
                }
                $this->db->update('company', $update, "id = " . $company_id);
                redirect("home/profile");
            }
        }
        $this->load->view('users/edit_company', $data);
    }

    public function userProfile() {
        $data['suman'] = array();
        $data['country'] = $this->company_model->viewCountry();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['forum'] = $this->company_model->viewForumLimit();
        $nik_name_user = $this->uri->segment(3);
        $data['nik_name_user'] = $nik_name_user;
        $data['details'] = $this->users_model->viewProfileDetailsNikname($nik_name_user);
        $data['related_company'] = $this->company_model->showCompanyPopular();
        foreach ($data['related_company'] as $rel_comp) {
            $data['rel_company_details'][$rel_comp->id] = $this->company_model->viewCompanyDetails($rel_comp->id);
        }
        $this->load->view('users/userProfile', $data);
    }

    public function mailToUsers() {
        $data['suman'] = array();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $title = $this->input->post('title');
        $body = $this->input->post('review');
        $email = $this->input->post('email');
        $profile = $this->input->post('hid_profile');
        $user_nikname = $data['users_nikname'];
        if (isset($email)) {
            $subject = $title;
            $to = $email;
            $message = "
			<HTML>
			<HEAD>
			<TITLE>" . $title . "/Mail Notification from user" . $user_nikname . "</TITLE>
			</HEAD>
			<BODY>
			<TABLE>
			<TR>
			<TD>
			Hi,
			</TD>
			</TR>
			<TR>
			<TD>
			
			" . $body . " 
			
			
			<br><br>
			-- 
			Thanks and warm regards,<BR>
			
			" . $user_nikname . ",<BR><BR>
			
			<br><br>
                                            -- Thanks and warm regards,
                                            <br><br>
                                            Team Streetremarks<br>
                                            <a href = 'www.streetremarks.com'>www.streetremarks.com</a><br>
                                            streetremarks<br>
                                            
                                            <BR><BR>
			============
			<BR><BR>
			
			
			IMPORTANT NOTICE: CONFIDENTIAL AND LEGAL PRIVILEGE
			
			This electronic communication is intended by the sender only for the access
			and use by the addressee and may contain legally privileged and
			confidential information. If you are not the addressee, you are notified
			that any transmission, disclosure, use, access to, storage or photocopying
			of this e-mail and any attachments is strictly prohibited. The legal
			privilege and confidentiality attached to this e-mail and any attachments
			is not waived, lost or destroyed by reason of a mistaken delivery to you.
			If you have received this e-mail and any attachments in error please
			immediately delete it and all copies from your system and notify the sender
			by e-mail.<BR><BR>
			==================
			<BR><BR>
				
			</TD>
			</TR>
			</TABLE>
			";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

            // More headers
            $headers .= 'From: streetremarks<www.streetremarks.com>' . "\r\n";

            mail($to, $subject, $message, $headers);
        }
        redirect("home/userProfile/" . $profile);
    }

    public function content($page) {
        $data['suman'] = array();
        $seesion_details = $this->session->userdata('users');
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        $data['content'] = $this->users_model->getContentPage($page);
        $this->load->view('users/page', $data);
    }

    public function updateProfileInfo() {
        $seesion_details = $this->session->userdata('users');
        $id = $seesion_details->logged_id;
        $email = $this->input->post('mail');
        $create = array(
            'email' => $email
        );
        if ($_FILES['image']['name'] != "") {
            if (!is_dir(FCPATH . '/images/users')) {
                mkdir(FCPATH . '/images/users');
            }

            $config['upload_path'] = 'images/users/'; // Location to save the image
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
            $config['max_size'] = '10000'; // in KB
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {

                $config2['image_library'] = 'gd2';
                $config2['source_image'] = 'images/users/' . $this->upload->file_name;
                $config2['create_thumb'] = false;
                $config2['maintain_ratio'] = TRUE;
                $config2['master_dim'] = 'width';
                $config2['width'] = 150; // image re-size  properties
                $config2['height'] = 150; // image re-size  properties 
                $config2['new_image'] = 'images/users/thumb' . $this->upload->file_name; // image re-size  properties 
                $this->load->library('image_lib', $config2); //codeigniter default function
                $this->image_lib->resize();
                $create['image'] = $this->upload->file_name;
            } else {
                $data['user_image'] = $this->upload->display_errors();
                redirect("home/profile");
            }
            $this->db->update('users', $create, "id = " . $id);
            redirect("home/profile");
        }
    }

    public function ajaxAutoSearchCompany() {

        $searchdata['country'] = $this->input->post('country');
        $searchdata['search'] = $this->input->post('key');
        $search_company = $this->company_model->searchCompanyAutoSagetion($searchdata);
        $html = "";
        $html .= "<ul>";
        if (!empty($search_company)) {
            foreach ($search_company as $company) {
                $html .= "<li><a href='javascript:void(0);' onclick = \"onclickAutoSagetion('" . $company->company_name . "')\">" . $company->company_name . "</a></li>";
            }
        }
        $html .= "</ul>";
        //print_r($search_company); die;
        echo $html;
        exit;
    }

    public function reportAbuse($id, $company_id) {
        $data['report_id'] = $id;
        $data['company_id'] = $company_id;
        $seesion_details = $this->session->userdata('users');
        $data['company'] = $this->company_model->showCompanyPopular();
        $data['forum'] = $this->company_model->viewForumLimit();
        foreach ($data['company'] as $comp) {
            $data['company_details'][$comp->id] = $this->company_model->viewCompanyDetails($comp->id);
        }
        if ($seesion_details) {
            $data['users_type'] = $seesion_details->users_type;
            $data['logged_id'] = $seesion_details->logged_id;
            $data['users_nikname'] = $seesion_details->users_nikname;
        }
        if (!$this->input->post()) {
            $this->load->view('users/report', $data);
        } else {
            $company = $this->input->post('hid_company');
            $create = array(
                'review_id' => $this->input->post('hid_id'),
                'userid' => $data['logged_id'],
                'report' => $this->input->post('reason'),
                'status' => 1,
                'is_deleted' => "1"
            );
            $result = $this->db->insert('review_report', $create);
            redirect("home/companyDetails/" . $company);
        }
    }

    public function ajaxInsertSessionComment() {
        $title = $this->input->post('title');
        $post = $this->input->post('post');
        $session_comment = (object) array(
                    'title' => $title,
                    'post' => $post
        );
        $this->session->set_userdata('comments', $session_comment);
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */