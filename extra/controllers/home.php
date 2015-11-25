<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('users_model');
        $this->load->model('category_model');
        $this->load->model('posts_model');
    }

    public function index() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        //print_r($data['categories']); die;
        $this->load->view('users/index', $data);
    }

    public function ajaxRegisterUsers() {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $rand_verify = rand(1000000000000, 9999999999999);
        $create = array(
            'email' => $email,
            'password' => $password,
            'name' => $name
        );
        $this->db->insert('users', $create);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $newdata = (object) array(
                        'logged_in' => TRUE,
                        'logged_id' => $insert_id,
                        'users_name' => $name
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
			

                            Your Registration successfully done on <a href = 'www.talent.com'>www.talent.com</a>.
			
			
			<br><br>
			-- 
			-- Thanks and warm regards,<BR>

                        Team <BR>
                        Talent<BR>
                        Talent company<BR><BR>

                        support@talent.com<BR>
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
            $headers .= 'From: Talent<www.talent.com>' . "\r\n";

            mail($to, $subject, $message, $headers);
        }
    }
    
    public function ajaxForgetPassword() {
        $email = $this->input->post('email');
        $result = $this->users_model->checkEmailUser($email);
        if($result){
            $genarate_id =(((( $result * 82736 ) - 2534 ) + 87213 ) -342 );
            $update = array(
                'forget_password' => $genarate_id
            );
            $this->db->update('users', $update, "id = " . $result );
            if (isset($email)) {
                $subject = "Here is your forget password link";
                $to = $email;
                $message = "
                            <HTML>
                            <HEAD>
                            <TITLE>Here is your forget password link</TITLE>
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


                                If you change your password.Please <a href = '".base_url("home/forgetChangePassword")."/".$genarate_id."'>click here</a>.


                            <br><br>
                            -- 
                            -- Thanks and warm regards,<BR>

                            Team <BR>
                            Talent<BR>
                            Talent company<BR><BR>

                            support@talent.com<BR>
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
                $headers .= 'From: Talent<www.talent.com>' . "\r\n";

                mail($to, $subject, $message, $headers);
            }
            echo "done";
            exit;
        }else{
            echo "not done";
            exit;
        }
    }

    public function ajaxCheckEmail() {
        $email = $this->input->post('email');
        $result = $this->users_model->checkEmailUser($email);
        if ($result) {
            echo "exist";
        } else {
            echo "Done";
        }
    }

    public function ajaxLoginUsers() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $result = $this->users_model->checkUserLogin($email, $password);
        if ($result) {
            $newdata = (object) array(
                        'logged_in' => TRUE,
                        'logged_id' => $result->id,
                        'users_name' => $result->name
            );
            $this->session->set_userdata('users', $newdata);
            echo "done";
        } else {
            echo "error";
        }
    }

    public function logout() {
        $this->session->unset_userdata('users');
        $this->session->sess_destroy();
        redirect('home');
    }
    
    public function profile() {
        $seesion_details = $this->session->userdata('users');
        $data['users_name'] = $seesion_details->users_name;
        $data['users_loged_in_id'] = $seesion_details->logged_id;
        $data['categories'] = $this->category_model->showCategoryUsers();
        if (!empty($data['users_name'])) {
            $data['profile'] = $this->users_model->viewProfileDetails($seesion_details->logged_id);
            $data['categories'] = $this->category_model->showCategoryUsers();
            $data['posts'] = $this->posts_model->viewPostsProfile($seesion_details->logged_id);
            if(!empty($data['posts'])){
                foreach ($data['posts'] as $post) {
                    $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
                }
            }
            $data['notification'] = $this->users_model->viewNotificationProfile($seesion_details->logged_id);
            $data['friend_list'] = $this->users_model->viewFriendsListProfile($seesion_details->logged_id);
            //print_r($data['friend_list']); die;
            $this->load->view('users/profile', $data);
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function forgetChangePassword($forget_id) {
        $database_forget_id = (((( $forget_id + 342 ) - 87213 ) + 2534 ) / 82736 );
        $data['profile'] = $this->users_model->viewProfileDetails($database_forget_id);
        $data['categories'] = $this->category_model->showCategoryUsers();
        //print_r($data['profile']); die;
        if($this->input->post()){
            $password = md5($this->input->post('password'));
            $id = $this->input->post('profile_id');
            $update = array(
                'password' => $password
            );
            $this->db->update('users', $update, "id = " . $id );
            $this->session->set_flashdata('error_password', "Password successfully changed");
            redirect('home/forgetChangePassword/'.$forget_id);
        }else{
            $this->load->view('users/forget_password', $data);
        }
    }
    
    public function editProfile() {
        $seesion_details = $this->session->userdata('users');
        $data['users_name'] = $seesion_details->users_name;
        $data['users_loged_in_id'] = $seesion_details->logged_id;
        $data['categories'] = $this->category_model->showCategoryUsers();
        if (!empty($data['users_name'])) {
            if(!$this->input->post()){
                $data['profile'] = $this->users_model->viewProfileDetails($data['users_loged_in_id']);
                $data['countries'] = $this->posts_model->viewCountry();
                $this->load->view('users/edit_profile', $data);
            }else{
                $users_input = $this->input->post();
                //print_r($users_input); die;
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
                        $users_input['image'] = $this->upload->file_name;
                    } else {
                        $data['image'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['image']);
                        redirect("home/profile");
                    }
                    $this->db->update('users', $users_input, "id = " . $data['users_loged_in_id']);
                    redirect("home/profile");
                }
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function talentProfile($id) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }

        $user_id = ((( $id + 769 ) - 5364 ) / 26 );

        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['friends'] = $this->users_model->viewProfileDetails($user_id);
        $data['friends_status'] = $this->users_model->viewFriendsProfile($user_id, $seesion_details->logged_id);
        $data['friends_profile_id'] = $id;
        $data['posts'] = $this->posts_model->viewPostsProfile($user_id);
        if(!empty($data['posts'])){
            foreach ($data['posts'] as $post) {
                $data['post_contents'][$post->id] = $this->posts_model->viewPostsContents($post->id);
            }
        }
        $data['friend_list'] = $this->users_model->viewFriendsListProfile($user_id);
        //print_r($seesion_details->logged_id); die;
        $this->load->view('users/friend_profile', $data);
    }

    public function friendsAction($id) {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }

        $user_id = ((( $id + 769 ) - 5364 ) / 26 );
        $data['categories'] = $this->category_model->showCategoryUsers();
        $data['friends'] = $this->users_model->viewProfileDetails($user_id);
        $data['friends_status'] = $this->users_model->viewFriendsProfile($user_id, $seesion_details->logged_id);
        if (!empty($data['friends_status'])) {
            
        } else {
            $create = array(
                'users_id' => $seesion_details->logged_id,
                'friends_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('friends', $create);
        }
        $data['friends_profile_id'] = $id;
        redirect('home/talentProfile/' . $id);
    }
    
    public function actionNotification($action, $notification) {
        $data['categories'] = $this->category_model->showCategoryUsers();
        $user_id = (((( $notification + 769 ) - 5364 ) / 26 ) - 3453 );
        if ($action == "7892737F9837g87wq872") {
            $update = array(
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            );
        } else if($action == "2378868ghas897239812fg21871") {
            $update = array(
                'status' => 2,
                'updated_at' => date('Y-m-d H:i:s')
            );
        }
        $this->db->update('friends', $update, "id = " . $user_id);
        redirect('home/profile');
    }

    public function ajaxSuggestFriend() {
        $category = $this->input->post('category');
        $email = $this->input->post('email');

        $create = array(
            'email' => $email,
            'category' => $category
        );
        $this->db->insert('suggestion', $create);
        $details = $this->category_model->viewCategoryDetails($category);
        if (isset($email)) {
            $subject = "Notification Suggest";
            $to = $email;
            $message = "
			<HTML>
			<HEAD>
			<TITLE>Notification Suggest</TITLE>
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
			

                            Your friend Suggest your mail address for your " . $details->category_name . " talent to our website.<br>
                            Please register our website talent for explore your talent.
			
			
			<br><br>
			-- 
			-- Thanks and warm regards,<BR>

                        Team <BR>
                        Talent<BR>
                        Talent company<BR><BR>

                        support@talent.com<BR>
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
            $headers .= 'From: Talent<www.talent.com>' . "\r\n";

            mail($to, $subject, $message, $headers);
        }
    }

    public function profileSearch() {
        $seesion_details = $this->session->userdata('users');
        $data['users_name'] = $seesion_details->users_name;
        if (!empty($data['users_name'])) {
            $data['categories'] = $this->category_model->showCategoryUsers();
            $search = $this->input->get('search');
            $data['search_results'] = $this->users_model->searchUsersProfile($search);
            //print_r($data['search_results']); die;
            $this->load->view('users/search_profile', $data);
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function postTalent() {
        $seesion_details = $this->session->userdata('users');
        $data['users_name'] = $seesion_details->users_name;
        if (!empty($data['users_name'])) {
            $data['categories'] = $this->category_model->showCategoryUsers();
            $data['countries'] = $this->posts_model->viewCountry();
            //print_r($data['countries']); die;
            if ($this->input->post()) {
                $create = array(
                    'users_id' => $seesion_details->logged_id,
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'speciality' => $this->input->post('speciality'),
                    'category' => $this->input->post('category'),
                    'country' => $this->input->post('country'),
                    'city' => $this->input->post('city'),
                );
                $this->db->insert('post', $create);
                $insert_id = $this->db->insert_id();
                if ($_FILES['photo1']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }

                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('photo1')) {
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "2";
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['photo1'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['photo1']);
                        redirect("home/postTalent");
                    }
                }
                if ($_FILES['photo2']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }

                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('photo2')) {
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "2";
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['photo2'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['photo2']);
                        redirect("home/postTalent");
                    }
                }
                if ($_FILES['photo3']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }

                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '10000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('photo3')) {
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "2";
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['photo3'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['photo3']);
                        redirect("home/postTalent");
                    }
                }
                if ($_FILES['video']['name'] != "") {
                    if (!is_dir(FCPATH . '/images/talent')) {
                        mkdir(FCPATH . '/images/talent');
                    }
                    
                    $config['upload_path'] = 'images/talent/'; // Location to save the image
                    $config['allowed_types'] = 'avi|mpg|mpeg|wmv|jpg|mp4';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    $config['max_size'] = '100000'; // in KB
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('video')) {
                        $posts['post_id'] = $insert_id;
                        $posts['elements'] = $this->upload->file_name;
                        $posts['elements_type'] = "3";
                        //print_r($posts); die;
                        $this->db->insert('posts_content', $posts);
                    } else {
                        $data['video'] = $this->upload->display_errors();
                        $this->session->set_flashdata('error_upload', $data['video']);
                        redirect("home/postTalent");
                    }
                }
                redirect('home/profile');
            } else {
                $this->load->view('users/post_talent', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('home');
        }
    }

    public function searchTalent() {
        $seesion_details = $this->session->userdata('users');
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }
        $data['categories'] = $this->category_model->showCategoryUsers();
        $search_category = $this->input->get('category');
        $search_content = $this->input->get('search');
        $data['searching_category'] = $search_category;
        $data['results'] = $this->posts_model->searchTalent($search_category, $search_content);
        $data['countries'] = $this->posts_model->viewCountry();
        //print_r($data['results']); die;
        $this->load->view('users/search_talent', $data);
    }

    public function onclickAjaxSearchTalent() {
        $data['categories'] = $this->category_model->showCategoryUsers();
        $search_data['country'] = $this->input->post('country');
        $search_data['city'] = $this->input->post('city');
        $search_data['category'] = $this->input->post('category');

        $data['results'] = $this->posts_model->searchTalentForAjax($search_data);
        $data['countries'] = $this->posts_model->viewCountry();
        if (!empty($data['results'])) {
            $this->load->view('users/search_talent_ajax', $data);
        } else {
            echo "no data";
        }
    }
    
    public function content($page) {
        $seesion_details = $this->session->userdata('users');
        $data['categories'] = $this->category_model->showCategoryUsers();
        if (!empty($seesion_details)) {
            $data['users_name'] = $seesion_details->users_name;
        }
        $data['content'] = $this->users_model->getContentPage($page);
        $this->load->view('users/page', $data);
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */