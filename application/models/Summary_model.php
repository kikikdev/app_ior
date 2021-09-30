<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Summary_model extends CI_Model {
	public function Get_summary(){
		$byself   = $this->session->userdata('occ_users_1103')->username; 
		$unitself = $this->session->userdata('occ_users_1103')->unit; 
		$roleself = $this->session->userdata('occ_users_1103')->role; 
			$data = $this->db->query(" 
							SELECT
					coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' then 1 end),0) ior_received,
					coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' AND occ_status = '1' AND occ_confirm_stats = '2' then 1 end),0) ior_progress,
					coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' AND occ_status = '1' AND occ_confirm_stats = '1' then 1 end),0) ior_open,
					coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' AND occ_status = '3' AND occ_confirm_stats = '3' then 1 end),0) ior_closed,
					coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' AND occ_status = '0' AND occ_confirm_stats = '0' then 1 end),0) ior_transfer_ncr,
					coalesce(sum(case when created_by  = '$byself' AND permission = '0' then 1 end),0) w_verif,
					coalesce(sum(case when created_by  = '$byself' AND permission = '1' then 1 end),0) h_verif
							FROM tbl_occ 
								");
   	 	return $data->result();
	}
	public function Get_summary__s(){
		$byself   = $this->session->userdata('occ_users_1103')->username; 
		$unitself = $this->session->userdata('occ_users_1103')->unit; 
		$roleself = $this->session->userdata('occ_users_1103')->role; 
		if ($roleself == "1") {
			$if = "coalesce(sum(case when permission = '0' then 1 end),0) need_verified," ;
		}
		else{
			$if = "coalesce(sum(case when permission = '0' AND created_by = '$byself' then 1 end),0) need_verified," ;
		}
			$data = $this->db->query("SELECT occ_send_to,
										coalesce(sum(case when created_by = '$byself' OR  occ_send_to = '$unitself' AND permission = '1' then 1 end),0) ior_total,
										coalesce(sum(case when permission = '1' AND created_by = '$byself' then 1 end),0) verified,
										$if
										coalesce(sum(case when created_by = '$byself' then 1 end),0) ior_sent,
										coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' then 1 end),0) ior_received,
										coalesce(sum(case when occ_send_to = '$unitself' AND permission = '1' then 1 end),0) received_ior_unit
										FROM tbl_occ ");
   	 	return $data->result();
	}
	public function Get_summary_monthly(){
		$byself   = $this->session->userdata('occ_users_1103')->username; 
		$unitself = $this->session->userdata('occ_users_1103')->unit;
		$roleself = $this->session->userdata('occ_users_1103')->role; 
			$data = $this->db->query("SELECT
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '01' then 1 end),0)Jan,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '02' then 1 end),0)Feb,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '03' then 1 end),0)Mar,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '04' then 1 end),0)Apr,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '05' then 1 end),0)May,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '06' then 1 end),0)Jun,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '07' then 1 end),0)Jul,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '08' then 1 end),0)Aug,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '09' then 1 end),0)Sept,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '10' then 1 end),0)Oct,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '11' then 1 end),0)Nov,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '12' then 1 end),0)Decc
										FROM tbl_occ
										WHERE occ_send_to = '$unitself' AND SUBSTR(occ_date, 1,4) =  YEAR(CURDATE())
									 ");
   	 	return $data->result_array();
	}
	public function Get_summary_monthly_status(){
		$unitself = $this->session->userdata('occ_users_1103')->unit;
		$roleself = $this->session->userdata('occ_users_1103')->role; 
		if ($roleself == '1') {
			$where = "" ;
		}
		else{
			$where = "WHERE a.occ_send_to = '$unitself'" ;
		}
		$data = $this->db->query("	SELECT b.status_desc,
									coalesce(sum(case when 
										 a.occ_status = '1' AND a.occ_confirm_stats = '1' AND b.status_desc = 'Open' AND a.occ_send_to = '$unitself' AND a.permission = '1' 
									OR a.occ_status = '3' AND a.occ_confirm_stats = '3' AND a.occ_send_to = '$unitself' AND a.permission = '1' 
									OR a.occ_status = '0' AND a.occ_confirm_stats = '0' AND a.occ_send_to = '$unitself' AND a.permission = '1' 
									OR a.occ_status = '1' AND a.occ_confirm_stats = '2' AND b.status_desc = 'Progress' AND a.occ_send_to = '$unitself' AND a.permission = '1' 
									OR a.occ_status = '1' AND a.occ_confirm_stats = '3' AND b.status_desc = 'Waiting Close' AND a.occ_send_to = '$unitself' AND a.permission = '1' 
									then 1 end),0) AS open
									FROM tbl_occ a
									LEFT JOIN tbl_occ_status b ON a.occ_status = b.status_id 
									$where
									GROUP BY b.status_desc");
	   	 	return $data->result();
	}
	public function Get_summary_monthly_permission(){
		$unitself = $this->session->userdata('occ_users_1103')->unit;
		$roleself = $this->session->userdata('occ_users_1103')->role; 
		if ($roleself == '1') {
		$where = "";
		}
		else{
			$where = "WHERE a.occ_send_to = '$unitself'";
		}
			$data = $this->db->query("SELECT b.permission_desc,
										coalesce(sum(case when a.permission = '0' OR a.permission = '1' then 1 end),0) AS open
										FROM tbl_occ a
										RIGHt JOIN tbl_permission b ON a.permission = b.permission_id 
										$where
										GROUP BY b.permission_desc");
   	 	return $data->result();
	}
	public function Get_summary_monthlyAll(){ 
			$data = $this->db->query("SELECT occ_send_to,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '01' then 1 end),0)Jan,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '02' then 1 end),0)Feb,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '03' then 1 end),0)Mar,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '04' then 1 end),0)Apr,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '05' then 1 end),0)May,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '06' then 1 end),0)Jun,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '07' then 1 end),0)Jul,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '08' then 1 end),0)Aug,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '09' then 1 end),0)Sept,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '10' then 1 end),0)Oct,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '11' then 1 end),0)Nov,
										coalesce(sum(case when SUBSTR(occ_date, 6,2 ) = '12' then 1 end),0)Decc
										FROM tbl_occ 
										GROUP BY occ_send_to
									 ");
   	 	return $data->result_array();
	}
	public function GetList_out_NeedV() {
		$byself = $this->session->userdata('occ_users_1103')->username; 
		$data = $this->db->query("SELECT * FROM tbl_occ WHERE created_by = '$byself' ");
	    	return $data->result();
	}
	public function Getoccunit_in() {
		$byself = $this->session->userdata('occ_users_1103')->unit; 
		$data = $this->db->query("SELECT * FROM tbl_occ WHERE occ_send_to = '$byself' AND permission = '1'");
	    	return $data->result();
	}

	/*public function getWorkingDays($startDate, $endDate){
			 $begin=strtotime($startDate);
			 $end=strtotime($endDate);
			 if($begin>$end){
			  echo "startdate is in the future! <br />";
			  return 0;
			 }else{
			   $no_days=0;
			   $weekends=0;
					  while($begin<=$end){
					    $no_days++; // no of days in the given interval
					    $what_day=date("N",$begin);
					     if($what_day>5) { // 6 and 7 are weekend days
					          $weekends++;
					     };
					    $begin+=86400; // +1 day
					  };
			  $working_days=$no_days-$weekends;
			  return $working_days;
			 }
	}*/
}

