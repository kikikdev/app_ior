<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {

	public function Get_set_category() {
			    	$data = $this->db->query("SELECT *
			    							  FROM tbl_occ_cattegory");
	    	return $data->result();
	}
	public function Get_set_subcategory() {
			    	$data = $this->db->query("SELECT * FROM tbl_occ_subcattegory a
												JOIN tbl_occ_cattegory b on b.cat_id = a.cat_id ");
	    	return $data->result();
	}
	function Get_Auth($username,$pass) {
			$data = $this->db->query("SELECT * FROM users WHERE username = '$username' AND password ='$pass'");
			return $data;
	}
	public function Get_det_category($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_cattegory WHERE cat_id = '$id'");
   	 	return $data->result();
	}
	public function GetMaxID() {
	    	$data = $this->db->query("SELECT MAX(occ_no) as MaxID FROM tbl_occ");
	    	return $data->result();
	}
}