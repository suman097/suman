<?php

Class Posts_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function searchTalent($search_category, $search_content = NULL ) {
        $sql = "select p.*, u.name, u.id as users_id, c.category_name, t.country from post p
        LEFT JOIN users u ON u.id = p.users_id
        LEFT JOIN category c ON c.id = p.category
        LEFT JOIN country t ON t.id = p.country
        where p.category = '".$search_category."' AND p.title LIKE '%".$search_content."%' AND p.description LIKE '%".$search_content."%' AND p.status = '1'  AND p.is_deleted = '1' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function searchTalentForAjax($search) {
        $sql = "select p.*, u.name, u.id as users_id, c.category_name, t.country from post p
        LEFT JOIN users u ON u.id = p.users_id
        LEFT JOIN category c ON c.id = p.category
        LEFT JOIN country t ON t.id = p.country
        where p.category = '".$search['category']."' AND p.country = '".$search['country']."' AND p.city LIKE '%".$search['city']."%' AND p.status = '1'  AND p.is_deleted = '1' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function viewCountry() {
        $sql = "select * from country order by id";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewPostsProfile($user) {
        $sql = "select * from post where users_id = '".$user."' order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function viewPostsContents($post_id) {
        $sql = "select * from posts_content where post_id = '".$post_id."' order by id DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    
}

?>
