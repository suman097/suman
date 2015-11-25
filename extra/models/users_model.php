<?php

Class users_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function login($data) {
        $query = $this->db->get_where('admin', array('email' => $data['user_name'], 'password' => $data['password']));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function checkUserLogin($email, $password) {
        $query = $this->db->get_where('users', array('email' => $email, 'password' => $password, 'is_deleted' => 1, 'status' => 1));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function viewProfileDetails($id) {

        $sql = 'SELECT * FROM users WHERE id = "' . $id . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        } else {
            $result = false;
        }
        return $result;
    }

    function viewFriendsProfile($friends_id, $id) {

        $sql = 'SELECT * FROM friends WHERE ( users_id = "' . $id . '"  AND friends_id = "' . $friends_id . '" ) OR ( friends_id = "' . $id . '"  AND users_id = "' . $friends_id . '" ) AND is_deleted = 1 ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row();
        } else {
            $result = false;
        }
        return $result;
    }

    function viewNotificationProfile($id) {

        $sql = 'SELECT f.*, u.name FROM friends f
                LEFT JOIN users u ON u.id = f.users_id WHERE f.friends_id = "' . $id . '" AND f.is_deleted = 1 AND f.status = 0 ORDER BY f.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        } else {
            $result = false;
        }
        return $result;
    }
    
    function viewFriendsListProfile($id) {

        $sql = 'SELECT f.*, u.name as profile_name1, u.id as profile_id1, p.name as profile_name2, p.id as profile_id2 FROM friends f
                LEFT JOIN users p ON p.id = f.friends_id
                LEFT JOIN users u ON u.id = f.users_id WHERE ( f.friends_id = "' . $id . '" OR f.users_id = "' . $id . '" ) AND f.is_deleted = 1 AND f.status = 1 ORDER BY f.id DESC';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        } else {
            $result = false;
        }
        return $result;
    }

    function checkEmailUser($email) {
        $sql = 'SELECT * FROM users WHERE email = "' . $email . '" ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->first_row()->id;
        } else {
            return false;
        }
    }

    function searchUsersProfile($search) {

        $sql = 'SELECT * FROM users where ( email = "' . $search . '" OR name LIKE "%' . $search . '%" ) AND status = 1 AND is_deleted = 1 ';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
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
    
    function getPages() {

        $sql = 'SELECT * FROM page where status = 1 AND is_deleted = 1';
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
        return $result;
    }

    
}

?>
