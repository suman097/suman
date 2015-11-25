<?php

Class notification_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    
	
	function viewMyNotification($sid, $rid ) {
        $sql = 'SELECT n.*, r.nikname as receiver FROM notification n 
		LEFT JOIN users r ON r.id = n.receiver_id
		WHERE ( n.sender_id = "' . $sid . '" AND n.receiver_id = "' . $rid . '" ) OR ( n.receiver_id = "' . $sid . '" AND n.sender_id = "' . $rid . '" ) AND n.status = 1 AND n.is_deleted = 1';
		
		/*$sql = 'SELECT n.*, r.nikname as receiver, s.nikname as sender, FROM notification n 
		LEFT JOIN users r ON r.id = n.receiver_id
		LEFT JOIN users s ON s.id = n.sender_id
		WHERE ( n.sender_id = "' . $sid . '" AND n.receiver_id = "' . $rid . '" ) OR ( n.receiver_id = "' . $sid . '" AND n.sender_id = "' . $rid . '" ) AND n.status = 1 AND n.is_deleted = 1';*/
		
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
        }
    }
	
}

?>
