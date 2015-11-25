<?php

Class company_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function login($data) {
        $query = $this->db->get_where('users', array('email' => $data['user_name'], 'password' => $data['password']));
        $result = ($query->num_rows() > 0) ? $query->first_row() : '';
        return $result;
    }

    function showCompany() {
        $sql = "select c.*, t.country from company c LEFT JOIN country t ON t.id = c.company_country where c.is_deleted = '1' AND c.status = '1' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
        
    }
    
    function showCompanyJson() {
        $sql = "select company_name from company where is_deleted = '1' AND status = '1' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            foreach($query->result() as $result){
                $company[] = $result->company_name;
            }
        }
        return $company;
    }
    
    function searchCompany($search) {
        $search_element = addslashes($search["search"]);
        $sql = "select c.id from company c  where  ( c.company_name LIKE '%" . $search_element . "%' OR c.company_description LIKE '%" . $search_element . "%' ) AND c.is_deleted = '1' AND c.status = '1' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function searchCompanyAutoSagetion($search) {
        if(!empty($search["country"])){
            $sql = "select c.id, c.company_name from company c  where c.company_country = '" . $search["country"] . "' AND ( c.company_name LIKE '%" . $search["search"] . "%' ) AND c.is_deleted = '1' AND c.status = '1' ";
        }else{
            $sql = "select c.id, c.company_name from company c  where  ( c.company_name LIKE '%" . $search["search"] . "%' ) AND c.is_deleted = '1' AND c.status = '1' ";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function listingCompany($paging) {
        $sql = "select c.id from company c where c.is_deleted = '1' AND c.status = '1' order by c.id DESC limit " . $paging['start'] . ", " . $paging['count'] . " ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function countCompany() {
        $sql = "select count(*) as count from company where is_deleted = '1'  AND status = '1' ";
        $query = $this->db->query($sql);
        $result = $query->first_row()->count;
        return $result;
    }
    
    function showCompanyPopular() {
        $sql = "select * from company where is_deleted = '1' AND popular = '1' AND status = '1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function viewCompanyLimit() {
        $sql = "select * from company where is_deleted = '1' AND status = '1' order by id DESC limit 0,12";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function viewCompanyDetails($id) {
        $sql = "select c.*, count(r.rating) as count, sum(r.rating) as total, t.country from company c 
		LEFT JOIN company_review r ON r.company = c.id
		LEFT JOIN country t ON t.id = c.company_country
		where c.id =  '" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        return $result;
    }
    
    function viewCompanyDetailsOnchange($id, $table) {
        $sql = "select * from ".$table." where id =  '" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        return $result;
    }

    function viewCompanyReview($id) {
        $sql = "select r.*, u.nikname from company_review r
		LEFT JOIN users u ON u.id = r.posted_by 
		where r.is_deleted = '1' AND r.status = '1' AND r.company = '" . $id . "' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function collectUserCommentMail($id, $user_id) {
        $sql = "select r.posted_by, u.nikname, u.email, c.company_name from company_review r
                    LEFT JOIN users u ON u.id = r.posted_by 
                    LEFT JOIN company c ON c.id = r.company WHERE r.company = '" . $id . "' AND r.posted_by != '".$user_id."' group by r.posted_by";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

    function checkIPTrust($company, $ip) {
        $sql = "select id from trust WHERE ip = '" . $ip . "' AND 	company = '" . $company . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function countTrust($company) {
        $sql = "select trust from company WHERE id = '" . $company . "' ";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function viewCountry() {
        $sql = "select * from country order by country";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function viewCountryName($country) {
        $sql = "select country from country where id = ".$country." ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->country;
            return $result;
        }
    }

    function viewMailWithCountry($country) {
        $sql = "select * from users where ( country LIKE '%,".$country."' OR country LIKE '".$country.",%' OR country LIKE '".$country."' OR country LIKE '%,".$country.",%' ) ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function viewCountryCount() {
        $sql = "select count(*) as count from country ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->first_row()->count;
            return $result;
        }
    }

    function viewForumLimit() {
        $sql = "select * from (select * from forum WHERE abuse = '1' AND status = '1' AND is_deleted = '1' order by id DESC limit 0,100)tmp order by tmp.id asc";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->result();
        }
    }

    function companyWithProfile($profile) {
        $sql = "select * from company WHERE created_by = '" . $profile . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->result();
        }
    }
    
    function checkCompanyExist($name, $country) {
        $name = addslashes($name);
        $sql = "select * from company WHERE company_name = '" . $name . "' AND company_country = '".$country."' ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return $query->result()[0]->id;
        }else{
            return false;
        }
    }
    
//    function showCompanyPopular() {
//        $sql = "select c.*, t.country from company c LEFT JOIN country t ON t.id = c.company_country where c.is_deleted = '1' AND c.status = '1' ";
//        $query = $this->db->query($sql);
//        $result = $query->result();
//        return $result;
//    }
    
    function showCompanyAdmin() {
        $sql = "select c.*, t.country from company c LEFT JOIN country t ON t.id = c.company_country where c.is_deleted = '1' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function viewBannerDetails($id) {
        $sql = "select * from banner where id =  '" . $id . "' ";
        $query = $this->db->query($sql);
        $result = $query->first_row();
        return $result;
    }
    
    function showAllReviewOrderCompany() {
        $sql = "select r.*, u.nikname, c.company_name from company_review r
		LEFT JOIN users u ON u.id = r.posted_by
                LEFT JOIN company c ON c.id = r.company
		where r.is_deleted = '1' order by id DESC ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function showAllReviewOrderCompanyAbuse($id) {
        $sql = "select count(report) as abuse from review_report WHERE review_id = ".$id." group by review_id ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }
    
    function showAllAbuseById($id) {
        $sql = "select r.*, u.nikname from review_report r
		LEFT JOIN users u ON u.id = r.userid
		where r.is_deleted = '1' AND r.review_id = '".$id."' order by id DESC ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        }
    }

}

?>
