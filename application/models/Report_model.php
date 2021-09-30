<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {
	public function Get_occurrence_list_bck($start,$end) {
		$data = $this->db->query("SELECT a.occ_id,occ_no,occ_sub,occ_detail,occ_risk_index,occ_probability,occ_severity,occ_reff,
									occ_ambiguity,occ_date,b.cat_name,c.cat_sub_desc,a.occ_sub_category,occ_sub_spec,occ_level_type,
									occ_status,occ_confirm_stats,occ_send_to,created_date,created_by,created_by_name,created_hide,
									permission,occ_follow_last_by,d.follow_desc,d.follow_date,d.follow_by,follow_date,follow_by_name
-- 									GROUP_CONCAT(d.follow_by )as follow_by,
-- 									GROUP_CONCAT(d.follow_date )as follow_date,
-- 				 					GROUP_CONCAT(d.follow_by_name )as follow_by_name
								FROM tbl_occ a
								JOIN tbl_occ_cattegory b ON a.occ_category = b.cat_id
								JOIN tbl_occ_subcattegory c ON a.occ_sub_category = c.cat_sub_id
								LEFT JOIN tbl_occ_follow d ON a.occ_id	= d.occ_id
								WHERE date(a.created_date) BETWEEN '$start' AND '$end'
								GROUP BY a.occ_id
								ORDER BY d.follow_date
								");
	    	return $data->result();
	}
	public function Get_occurrence_list($start,$end) {
		$month_start = substr($start, 5, 2) ; 
		$year_start  = substr($start, 0, 4) ; 
		$month_end = substr($end, 5, 2) ; 
		$year_end  = substr($end, 0, 4);

		$data = $this->db->query("SELECT 	toc.occ_id,toc.occ_no,
											tcat.cat_name,
											tsubc.cat_sub_desc,
											toc.occ_sub,
											toc.occ_risk_index,
											toc.occ_final_index,
											toc.occ_date,
											toc.occ_detail,
											toc.occ_send_to,
											toc.created_date,
											toc.created_by,
											toc.created_by_name,
											toc.created_by_unit,
											toc.created_hide,
											y.follow_by,
											y.follow_by_name,
											y.follow_by_unit,
											y.follow_desc,
											y.follow_date,
											toc.occ_follow_last_by,
											toc.occ_status,
											toc.occ_confirm_stats,
											toc.InsertBy,
											DATEDIFF(CURDATE(),toc.occ_estfinish_date) as OVERDUESTATS
											FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow GROUP BY 2) AS x
											LEFT JOIN(
											SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow) AS y
											ON x.follow_date=y.follow_date
											RIGHT JOIN tbl_occ AS toc ON toc.occ_id=x.occ_id
											JOIN tbl_occ_cattegory AS tcat ON tcat.cat_id = toc.occ_category
											JOIN tbl_occ_subcattegory AS tsubc ON tsubc.cat_sub_id = toc.occ_sub_category
											WHERE (date(toc.created_date) BETWEEN '$start' AND '$end' AND toc.permission = '1')
											OR (SUBSTRING(toc.occ_no, 5 , 2) BETWEEN '$month_start' AND '$month_end') 
											AND ((SUBSTRING(toc.occ_no, 8 , 4) BETWEEN '$year_start' AND '$year_end') AND toc.permission = '1')
											GROUP BY occ_id
											UNION
									SELECT 	toc.occ_id,toc.occ_no,
											tcat.cat_name,
											tsubc.cat_sub_desc,
											toc.occ_sub,
											toc.occ_risk_index,
											tod.occ_final_index,
											toc.occ_date,
											toc.occ_detail,
											toc.occ_send_to,
											toc.created_date,
											toc.created_by,
											toc.created_by_name,
											toc.created_by_unit,
											toc.created_hide,
											y.follow_by,
											y.follow_by_name,
											y.follow_by_unit,
											y.follow_desc,
											y.follow_date,
											toc.occ_follow_last_by,
											toc.occ_status,
											toc.occ_confirm_stats,
											toc.InsertBy,
											DATEDIFF(CURDATE(),toc.occ_estfinish_date) as OVERDUESTATS
											FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow_old GROUP BY 2) AS x
											LEFT JOIN(
											SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow) AS y
											ON x.follow_date=y.follow_date
											RIGHT JOIN tbl_occ_old AS toc ON toc.occ_id=x.occ_id
											RIGHT JOIN tbl_occ AS tod ON tod.occ_id=x.occ_id
											JOIN tbl_occ_cattegory AS tcat ON tcat.cat_id = toc.occ_category
											JOIN tbl_occ_subcattegory AS tsubc ON tsubc.cat_sub_id = toc.occ_sub_category
											WHERE date(toc.created_date) BETWEEN '$start' AND '$end' AND toc.permission = '1'
											OR (SUBSTRING(toc.occ_no, 5 , 2) BETWEEN '$month_start' AND '$month_end') 
											AND ((SUBSTRING(toc.occ_no, 8 , 4) BETWEEN '$year_start' AND '$year_end') AND toc.permission = '1')
											GROUP BY occ_id
											ORDER BY occ_no
											");
												    	return $data->result();
	}
	public function Get_occurrence_list_yearly($start) {
		$data = $this->db->query("SELECT 	toc.occ_id,toc.occ_no,
											tcat.cat_name,
											tsubc.cat_sub_desc,
											toc.occ_sub,
											toc.occ_risk_index,
											toc.occ_date,
											toc.occ_detail,
											toc.occ_send_to,
											toc.created_date,
											toc.created_by,
											toc.created_by_name,
											toc.created_by_unit,
											toc.created_hide,
											y.follow_by,
											y.follow_by_name,
											y.follow_by_unit,
											y.follow_desc,
											y.follow_date,
											toc.occ_follow_last_by,
											toc.occ_status,
											toc.occ_confirm_stats,
											toc.InsertBy
											FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow GROUP BY 2) AS x
											LEFT JOIN(
											SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow) AS y
											ON x.follow_date=y.follow_date
											RIGHT JOIN tbl_occ AS toc ON toc.occ_id=x.occ_id
											JOIN tbl_occ_cattegory AS tcat ON tcat.cat_id = toc.occ_category
											JOIN tbl_occ_subcattegory AS tsubc ON tsubc.cat_sub_id = toc.occ_sub_category
											WHERE date(toc.created_date) BETWEEN '$start' AND '$end' AND toc.permission = '1'
											GROUP BY occ_id
											UNION
									SELECT 	toc.occ_id,toc.occ_no,
											tcat.cat_name,
											tsubc.cat_sub_desc,
											toc.occ_sub,
											toc.occ_risk_index,
											toc.occ_date,
											toc.occ_detail,
											toc.occ_send_to,
											toc.created_date,
											toc.created_by,
											toc.created_by_name,
											toc.created_by_unit,
											toc.created_hide,
											y.follow_by,
											y.follow_by_name,
											y.follow_by_unit,
											y.follow_desc,
											y.follow_date,
											toc.occ_follow_last_by,
											toc.occ_status,
											toc.occ_confirm_stats,
											toc.InsertBy
											FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow_old GROUP BY 2) AS x
											LEFT JOIN(
											SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow) AS y
											ON x.follow_date=y.follow_date
											RIGHT JOIN tbl_occ_old AS toc ON toc.occ_id=x.occ_id
											JOIN tbl_occ_cattegory AS tcat ON tcat.cat_id = toc.occ_category
											JOIN tbl_occ_subcattegory AS tsubc ON tsubc.cat_sub_id = toc.occ_sub_category
											WHERE date(toc.created_date) BETWEEN '$start' AND '$end' AND toc.permission = '1'
											GROUP BY occ_id
											ORDER BY occ_no
											");
												    	return $data->result();
	}
	public function Get_occurrence_filtered($numb,$occ_sub,$occ_cat,$o_date_s,$o_date_u,$i_date_s,$i_date_u,$s_occ_to,$s_occ_by_unit,$s_occ_status,$s_occ_risk,$s_keyword) {
		if ($numb == '' AND $occ_sub == '' AND $occ_cat == '' AND $o_date_s == '' AND $o_date_u == '' AND $i_date_s == '' AND $i_date_u == '' AND $s_occ_to == '' AND $s_occ_by_unit == '' AND $s_occ_status == '' AND $s_occ_risk == '' AND $s_keyword == '') {
			$strSearch = "";
		}
		else {
				if($numb!=''){
					$arrQry[0] = "a.occ_no LIKE '%".$numb."%'";
				}
				if($occ_sub!=''){
					$arrQry[1] = "a.occ_sub LIKE '%".$occ_sub."%'";
				}
				if($occ_cat!=''){
					$arrQry[2] = "a.occ_category = '".$occ_cat."'";
				}
					if($o_date_s!=''  && $o_date_u!=''){
						if($o_date_s!=''  && $o_date_u!=''){
							$arrQry[3] = "(date(occ_date) BETWEEN '".$o_date_s."' AND '".$o_date_u."')";
						}
						else{
							$arrQry[4] = "occ_date = '".$o_date_s."'";
						}
					}
				
					if($i_date_s!=''  && $i_date_u!=''){
						if($i_date_s!=''  && $i_date_u!=''){
							$arrQry[5] = "(date (created_date) BETWEEN '".$i_date_s."' AND '".$i_date_u."')";
						}
						else{
							$arrQry[6] = "created_date = '".$i_date_s."'";
						}
					}
				if($s_occ_to!=''){
					$arrQry[7] = "a.occ_send_to like '%".$s_occ_to."%'";
				}
				if($s_occ_by_unit!=''){
					$arrQry[8] = "a.created_by_unit like '%".$s_occ_by_unit."%'";
				}
				if($s_occ_status!=''){
					if($s_occ_status == '11'){
							$arrQry[9] = "a.occ_status = '1' AND a.occ_confirm_stats = '1'";
					}
					if($s_occ_status == '12'){
							$arrQry[9] = "a.occ_status = '1' AND a.occ_confirm_stats = '2'";
					}
					if($s_occ_status == '13'){
							$arrQry[9] = "a.occ_status = '1' AND a.occ_confirm_stats = '3'";
					}
					if($s_occ_status == '00'){
							$arrQry[9] = "a.occ_status = '0' AND a.occ_confirm_stats = '0'";
					}
					if($s_occ_status == '33'){
							$arrQry[9] = "a.occ_status = '3' AND a.occ_confirm_stats = '3'";
					}
					if($s_occ_status == '99'){
							$arrQry[9] = "DATEDIFF(CURDATE(),a.occ_estfinish_date) >= '0'";
					}
					
				}
				if($s_occ_risk !=''){
					$arrQry[10] = "a.occ_risk_index = '".$s_occ_risk."'";
				}
				if($s_keyword !=''){
					$arrQry[11] = "a.occ_detail like '%".$s_keyword."%'";
				}

				if(count($arrQry)>0)
				{
				$strSearch = implode(" AND ",$arrQry);
				}
				if($strSearch != '')
				{
					$strSearch = "WHERE ".$strSearch;
				}
		}
		
		$data = $this->db->query ("SELECT 	a.occ_id,a.occ_no,
											tcat.cat_name,
											tsubc.cat_sub_desc,
											a.occ_sub,
											a.occ_date,
											a.occ_detail,
											a.occ_send_to,
											a.created_date,
											a.created_by,
											a.created_by_name,
											a.created_by_unit,
											a.created_hide,
											y.follow_by,
											y.follow_by_name,
											y.follow_desc,
											y.follow_date,
											a.occ_follow_last_by,
											a.occ_status,
											a.occ_confirm_stats,
											a.InsertBy,
											a.occ_risk_index,
											DATEDIFF(CURDATE(),a.occ_estfinish_date) as OVERDUESTATS
			FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow GROUP BY 2) AS x
			LEFT JOIN(
			SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow) AS y
			ON x.follow_date=y.follow_date
			RIGHT JOIN tbl_occ AS a ON a.occ_id=x.occ_id
			JOIN tbl_occ_cattegory AS tcat ON tcat.cat_id = a.occ_category
			JOIN tbl_occ_subcattegory AS tsubc ON tsubc.cat_sub_id = a.occ_sub_category
			$strSearch
			GROUP BY occ_id
			UNION
			SELECT 	a.occ_id,a.occ_no,
											tcat.cat_name,
											tsubc.cat_sub_desc,
											a.occ_sub,
											a.occ_date,
											a.occ_detail,
											a.occ_send_to,
											a.created_date,
											a.created_by,
											a.created_by_name,
											a.created_by_unit,
											a.created_hide,
											y.follow_by,
											y.follow_by_name,
											y.follow_desc,
											y.follow_date,
											a.occ_follow_last_by,
											a.occ_status,
											a.occ_confirm_stats,
											a.InsertBy,
											a.occ_risk_index,
											DATEDIFF(CURDATE(),a.occ_estfinish_date) as OVERDUESTATS
			FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow_old GROUP BY 2) AS x
			LEFT JOIN(
			SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow_old) AS y
			ON x.follow_date=y.follow_date
			RIGHT JOIN tbl_occ_old AS a ON a.occ_id=x.occ_id
			JOIN tbl_occ_cattegory AS tcat ON tcat.cat_id = a.occ_category
			JOIN tbl_occ_subcattegory AS tsubc ON tsubc.cat_sub_id = a.occ_sub_category
			$strSearch
			GROUP BY occ_id
			");
				    	return $data->result();
				}
}