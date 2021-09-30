<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	// public function Get_unit() {
	// 	$this->employe= $this->load->database('employe',TRUE);
	// 	$unit = $this->employe->query("SELECT DISTINCT desc_unit FROM tblunit"); 
	// 	 return $unit ;
	// }
	public function Getocc_cat() {
		$cat = $this->db->query("SELECT
									cat_id,
									cat_name 
								FROM
									tbl_occ_cattegory 
								WHERE
									cat_id IN ('11','12','13','14','15','16','17','18','19',
										'20','21','22','23','24','25','26') 
								ORDER BY
									cat_id"); 
		// $cat = $this->db->query("
		// 						SELECT cat_id ,cat_name
		// 						FROM tbl_occ_cattegory
		// 						ORDER BY cat_id"); 
		 return $cat ;
	}
	public function Getocc_subcat() {
		$cat = $this->db->query("
								SELECT cat_sub_id ,cat_sub_desc
								FROM tbl_occ_subcattegory
								"); 
		 return $cat ;
	}
	public function Getocc_status() {
		$status = $this->db->query("
									SELECT status_id,status_desc
									FROM tbl_occ_status
									ORDER BY status_id ASC "); 
		 return $status ;
	}
	public function Getocc_unit() {
		$this->employee_back= $this->load->database('employee_back',TRUE);
		$unit = $this->employee_back->query("SELECT DISTINCT REPLACE
												( UNIT, 'JKT', '' ) AS unit 
											FROM
												v_tabpersonel_active 
											ORDER BY
												UNIT");
		// $unit = $this->employee_back->query("SELECT DISTINCT
		// 										UNIT as unit
		// 									FROM
		// 										tabpersonel 
		// 									ORDER BY
		// 										UNIT"); 
		 return $unit ;
	}
	public function Getocc_unit_old() {
		$unit = $this->db->query("
									SELECT DISTINCT unit
									FROM tbl_unit
									ORDER BY unit ASC "); 
		 return $unit ;
	}
	public function Getocc_accreg() {
		$acreg = $this->db->query("
									SELECT DISTINCT acreg
									FROM tbl_acreg
									ORDER BY acreg ASC "); 
		 return $acreg ;
	}
	public function Get_OLD_OCC_PER_UNIT() {
		$acreg = $this->db->query(" SELECT occ_send_to,COUNT(occ_id)AS total_received
									FROM tbl_occ_old
									WHERE occ_send_to != null OR occ_send_to != ''
									GROUP BY occ_send_to"); 
		 return $acreg ;
	}
}