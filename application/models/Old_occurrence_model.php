<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Old_occurrence_model extends CI_Model {
	public function get_old_list($id) {
		$data = $this->db->query("	SELECT a.*,b.follow_next,c.status_desc,DATEDIFF(CURDATE(),a.occ_estfinish_date) as duedate 
									FROM tbl_occ_old a
									LEFT JOIN tbl_occ_follow b ON b.occ_id = a.occ_id
									LEFT JOIN tbl_occ_status c ON a.occ_status = c.status_id
									WHERE (a.occ_send_to = '$id')
									GROUP BY a.occ_id");
	    	return $data->result();
	}
}