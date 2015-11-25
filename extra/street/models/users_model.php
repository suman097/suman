<?php

Class users_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function login($data) {
        $query = $this->db->get_where('users', array('email' => $data['user_name'], 'password' => $data['password']));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function checkNikName($name) {
        $sql = 'SELECT * FROM users WHERE nikname = "' . $name . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function loginUser($data) {
        $query = $this->db->get_where('users', array('nikname' => $data['user_name'], 'password' => $data['password'], 'users_type' => 2, 'status' => 1));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function viewProfileDetails($id) {

        $sql = 'SELECT * FROM users WHERE id = "' . $id . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }
        return $result;
    }

    function viewProfileDetailsNikname($nikname) {

        $sql = 'SELECT * FROM users WHERE nikname = "' . $nikname . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }
        return $result;
    }

    function getPages() {

        $sql = 'SELECT * FROM page where status = 1 AND is_deleted = 1';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
        return $result;
    }
    
    function showUsers() {

        $sql = 'SELECT * FROM users where users_type = 2';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
        return $result;
    }
    
    function selectUsersWithEmailNickname($nikname, $email) {

        $sql = 'SELECT * FROM users where nikname = "'.$nikname.'" AND email = "'.$email.'"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }else{
            $result = false;
        }
        return $result;
    }

    function getContentPage($page) {

        $sql = 'SELECT * FROM page where slug = "' . $page . '"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }
        return $result;
    }

    function getPagesWithId($eid) {

        $sql = 'SELECT * FROM page where id = "' . $eid . '"';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        }
        return $result;
    }

    function getUsersCount() {

        $sql = 'SELECT count(*) as user FROM users';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->user;
        }
        return $result;
    }

    function getCompanyCount() {

        $sql = 'SELECT count(*) as companys FROM company';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->companys;
        }
        return $result;
    }

    function getReviewCount() {

        $sql = 'SELECT count(*) as review FROM company_review';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->review;
        }
        return $result;
    }

    function getNotificationCount() {

        $sql = 'SELECT count(*) as notification FROM forum';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->notification;
        }
        return $result;
    }

}

?>
