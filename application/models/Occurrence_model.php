<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Occurrence_model extends CI_Model {
	public function GetMaxID() {
	    	$data = $this->db->query("SELECT MAX(occ_no) as MaxID FROM tbl_occ
	    							  WHERE SUBSTRING(occ_no ,4,10) = date_format(curdate(), '/%m/%Y')
	    							  AND permission = '1'");
	    	return $data->result();
	}
	public function GetMaxID_need_verified() {
	    	$data = $this->db->query("SELECT MAX(occ_no) as MaxID FROM tbl_occ
	    							  WHERE SUBSTRING(occ_no ,4,11) = date_format(curdate(), '/%m/%Y')+'NV'
	    							  AND permission = '0'");
	    	return $data->result();
	}
	public function GetMaxIDDraft() {
	    	$data = $this->db->query("SELECT MAX(occ_no) as MaxID FROM tbl_occ_reject
	    							  WHERE SUBSTRING(occ_no ,4,10) = date_format(curdate(), '/%m/%Y')+'NH'");
	    	return $data->result();
	}
	public function GetMaxIDOHR() {
	    	$data = $this->db->query("SELECT MAX(occ_no) as MaxID FROM tbl_occ_ohr
									  WHERE SUBSTRING(occ_no ,4,8) = date_format(curdate(), '/%m/%Y')");
	    	return $data->result();
	}
	public function GetMaxfollowID() {
	    	$data = $this->db->query("SELECT MAX(follow_occ_file_id) as MaxIDFoll FROM tbl_occ_follow");
	    	return $data->result();
	}
	public function Get_occ_for_move($id){
		$data = $this->db->query("SELECT * FROM tbl_occ WHERE occ_id = '$id'");
   	 	return $data->result();
	}
	public function Getoccunit_Open($whstats,$whunit) {
		$data = $this->db->query("SELECT * FROM tbl_occ $whstats $whunit ORDER BY created_date DESC");
			    	
	    	return $data->result();
	}
	public function Getoccunit() {
		$data = $this->db->query("SELECT *,DATEDIFF(CURDATE(),occ_response_date) as countdown FROM tbl_occ WHERE permission = '0' ORDER BY created_date DESC");
			    	
	    	return $data->result();
	}
	public function Getoccunit_verified() {
		$data = $this->db->query("SELECT *,DATEDIFF(CURDATE(),occ_estfinish_date) as duedate FROM tbl_occ WHERE permission = '1' ");
	    	return $data->result();
	}
	public function Getoccunit_verified_waiting_close() {
		$data = $this->db->query("SELECT  toc.*,
											y.follow_date,
											DATEDIFF(CURDATE(),occ_estfinish_date) as duedate,
											DATEDIFF(CURDATE(),y.follow_date) as WAITINGSTATS
									FROM (SELECT MAX(follow_date) AS follow_date,occ_id FROM tbl_occ_follow GROUP BY 2) AS x
									LEFT JOIN(
									SELECT follow_date,follow_desc,follow_by,follow_by_name,follow_by_unit FROM tbl_occ_follow) AS y
									ON x.follow_date=y.follow_date
									RIGHT JOIN tbl_occ AS toc ON toc.occ_id=x.occ_id						
									WHERE (permission = '1') AND (occ_status = '1' AND occ_confirm_stats = '3')
									AND DATEDIFF(CURDATE(),y.follow_date) >= '5'
									GROUP BY occ_id
									ORDER BY occ_no
								");
	    	return $data->result();
	}
	public function Getoccunit_verified_by_year($id) {
		if ($id == '0000') {
			$where = "" ; 
		}
		else{
			$where = "AND (YEAR(occ_date) = '$id')" ; 	
		}

		$data = $this->db->query("SELECT *,DATEDIFF(CURDATE(),occ_estfinish_date) as duedate, YEAR(occ_date) as inyear 
								  FROM tbl_occ 
								  WHERE permission = '1'
								  $where ");
	    	return $data->result();
	}
	public function Getoccunit_in() {
		$byself = $this->session->userdata('occ_users_1103')->unit; 
		$childunit = $this->db->query("SELECT group_unit FROM tbl_group_unit WHERE unit = '$byself'")->result_array();
		// //add function to get child by parent 
		// //TFS -> CHILDE
		// //JIKA punya child maka tambahkan where
		
		$whereparent ="";
		if(count($childunit)>0){
			$child = array();
			foreach ($childunit as $key => $value) {
				array_push($child, $value['group_unit']);
				//'a','b'
			}
			// print_r($child);
			$a=implode("','",$child);
			$whereparent= " OR a.occ_send_to IN ('$a')";
		}
		
		$where = substr($byself, 0,2 );
		
		// $data = $this->db->query("	SELECT a.*,b.follow_next,c.status_desc,DATEDIFF(CURDATE(),a.occ_estfinish_date) as duedate FROM tbl_occ a
		// LEFT JOIN tbl_occ_follow b ON b.occ_id = a.occ_id
		// LEFT JOIN tbl_occ_status c ON a.occ_status = c.status_id
		// WHERE (a.permission = '1' AND a.occ_send_to = '$byself')
		// OR (a.permission = '1' AND SUBSTRING(a.occ_send_to ,1 , 2) LIKE '%$where')
		// OR (a.permission = '1' AND SUBSTRING(a.occ_follow_last_by ,1 , 2) LIKE '%$where')
		// OR (a.permission='1' AND b.follow_next LIKE '%$byself' )
		// GROUP BY a.occ_id");
		// die(); 	
		$data = $this->db->query("	SELECT a.*,b.follow_next,c.status_desc,DATEDIFF(CURDATE(),a.occ_estfinish_date) as duedate FROM tbl_occ a
									LEFT JOIN tbl_occ_follow b ON b.occ_id = a.occ_id
									LEFT JOIN tbl_occ_status c ON a.occ_status = c.status_id
									WHERE (a.permission = '1' AND a.occ_send_to = '$byself')
									OR (a.permission = '1' AND SUBSTRING(a.occ_send_to ,1 , 2) LIKE '%$where')
									OR (a.permission = '1' AND SUBSTRING(a.occ_follow_last_by ,1 , 2) LIKE '%$where')
									OR (a.permission='1' AND b.follow_next LIKE '%$byself' )
									$whereparent
									GROUP BY a.occ_id");
	    return $data->result();
	}
	public function Getoccunit_out() {
		$byself = $this->session->userdata('occ_users_1103')->username; 
		$data = $this->db->query("SELECT occ_id,occ_no,
									CONCAT('<a href=# onclick=v_occ_detail(',CONVERT(occ_id USING utf8),')>',occ_sub,'</a>') as occ_sub,
									occ_detail,occ_risk_index,occ_probability,occ_severity,
									occ_reff,occ_ambiguity,occ_date,occ_estfinish_date,occ_category,occ_sub_category,
									occ_sub_spec,occ_status,occ_confirm_stats,occ_send_to,created_date,created_by,created_by_name,
									created_hide,permission,occ_follow_last_by
								   FROM tbl_occ 
								   WHERE created_by = '$byself'
								   UNION
								   SELECT
									occ_id,occ_no,
									CONCAT('<a href=# onclick=v_ohr_detail(',CONVERT(occ_id USING utf8),')>',occ_sub,'</a>') as occ_sub,
									occ_detail,occ_risk_index,occ_probability,occ_severity,
									occ_reff,occ_ambiguity,occ_date,occ_estfinish_date,occ_category,occ_sub_category,
									occ_sub_spec,occ_status,occ_confirm_stats,occ_send_to,created_date,created_by,created_by_name,created_hide,
									permission,occ_follow_last_by
								   FROM tbl_occ_ohr
								   WHERE created_by = '$byself'");
	    	return $data->result();
	}
	public function Get_detail_nocc($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_reject a
									LEFT JOIN tbl_occ_cattegory b ON a.occ_category = b.cat_id
									LEFT JOIN tbl_occ_subcattegory c ON a.occ_sub_category = c.cat_sub_id
									-- LEFT JOIN tbl_occ_follow d ON  a.occ_id	= d.occ_id
									WHERE a.occ_id = '$id'
									GROUP BY a.occ_id
									");
   	 	return $data->result();
	}
	public function Get_detail_ohr($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_ohr a
									LEFT JOIN tbl_occ_cattegory b ON a.occ_category = b.cat_id
									LEFT JOIN tbl_occ_subcattegory c ON a.occ_sub_category = c.cat_sub_id
									-- LEFT JOIN tbl_occ_follow d ON  a.occ_id	= d.occ_id
									WHERE a.occ_id = '$id'
									GROUP BY a.occ_id
									");
   	 	return $data->result();
	}
	public function Get_detail_occ($id){
		$data = $this->db->query("SELECT *, DATE_SUB(a.occ_estfinish_date, INTERVAL (WEEKDAY(a.occ_estfinish_date)) DAY) as countdown,DATEDIFF(CURDATE(),a.occ_estfinish_date) 	as duedate, DATEDIFF(CURDATE(),a.occ_response_date) as verifikator_resp FROM tbl_occ a
									LEFT JOIN tbl_occ_cattegory b ON a.occ_category = b.cat_id
									LEFT JOIN tbl_occ_subcattegory c ON a.occ_sub_category = c.cat_sub_id
									-- LEFT JOIN tbl_occ_follow d ON  a.occ_id	= d.occ_id
									WHERE a.occ_id = '$id'
									GROUP BY a.occ_id
									");
   	 	return $data->result();
	}
	public function Get_occ_file($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_file a
									WHERE a.occ_id = '$id' AND file_name != '-'");
   	 	return $data->result();
	}
	public function Get_occ_file_fo($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_file_fo a
									WHERE a.follow_occ_file_id = '$id' AND a.file_name != '-' ");
   	 	return $data->result();
	}
	public function Get_occ_file_ohr($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_file_ohr a
									WHERE a.follow_occ_file_id = '$id' AND a.file_name != '-' ");
   	 	return $data->result();
	}
	public function Get_detail_follow($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_follow b WHERE b.follow_id = '$id'");
   	 	return $data->result();
	}
	public function Get_occ_follow($id){
		$data = $this->db->query("SELECT * FROM tbl_occ a 
								  JOIN tbl_occ_follow b ON a.occ_id = b.occ_id 
								  WHERE b.occ_id = '$id'
								  ORDER BY follow_date ASC");
   	 	return $data->result();
	}
	public function Insert($table, $data){

    	return $this->db->insert($table, $data);
	}
	public function Getprobability() {
		$data = $this->db->query("SELECT * FROM z_probability_copy");
			    	
	    	return $data->result();
	}
	public function Getseverity() {
		$data = $this->db->query("SELECT * FROM z_severity_copy");	
	    	return $data->result();
	}
	public function Check_Closestats($ic) {
	    	$data = $this->db->query("SELECT * FROM tbl_occ WHERE occ_id = '$ic'");
	    	return $data->result();
	}
	public function Getocc_NON() {
		$byself = $this->session->userdata('occ_users_1103')->username; 
		$role = $this->session->userdata('occ_users_1103')->role; 
		if ($role == 1) {
			$data = $this->db->query("SELECT * FROM tbl_occ_reject");
		}else{
			$data = $this->db->query("SELECT * FROM tbl_occ_reject
								  WHERE created_by = '$byself'");
		}
		
	    	return $data->result();
	}
	public function getmaster_group() {	
			$data = $this->db->query("SELECT * FROM tbl_master_group");		
	    	return $data->result();
	}
	public function Getocc_OHR() {
		$byself = $this->session->userdata('occ_users_1103')->username; 
		$role = $this->session->userdata('occ_users_1103')->role; 
		if ($role == 1) {
			$data = $this->db->query("SELECT * FROM tbl_occ_ohr");
		}else{
			$data = $this->db->query("SELECT * FROM tbl_occ_ohr
								  WHERE created_by = '$byself'");
		}
		
	    	return $data->result();
	}
	public function Get_non_occ_follow($id){
		$data = $this->db->query("SELECT * FROM tbl_occ_reject a 
								  WHERE a.occ_id = '$id'");
   	 	return $data->result();
	}
	public function Get_OHR_occ_follow($id,$id2,$id3,$id4){
		$id = $id.'/'.$id2.'/'.$id3.'/'.$id4;
		$data = $this->db->query("SELECT *
								FROM tbl_occ_follow_ohr b 
								WHERE b.occ_id = '$id'");
   	 	return $data->result();
	}
	public function Get_detail_karyawan($nopeg){
		$this->employe = $this->load->database('employe',TRUE);
		$data = $this->employe->query("SELECT PERNR,EMPLNAME,UNIT FROM TBL_SOE_HEAD where PERNR = '$nopeg'");
   	 	return $data->result();
	}
	public function GET_MAIL_PERSONEL($ocby){
		$this->employe = $this->load->database('employe',TRUE);
		$data = $this->employe->query("	SELECT EMAIL,UNIT,JABATAN
                    					FROM TBL_SOE_HEAD a
                    					WHERE CONVERT(VARCHAR(20),a.PERNR)  = '$ocby'");
		return $data->result();
	}
	public function GET_MAIL_UNIT($repto){
		$this->employe = $this->load->database('employe',TRUE);
		$data = $this->employe->query("	SELECT EMAIL,UNIT,JABATAN
					                    FROM TBL_SOE_HEAD a
					                    WHERE a.unit  LIKE '%".$repto."%'
					                    AND EMAIL != ''");
		return $data->result();
	}
	public function Check_Last_follow($ic){
    	$data = $this->db->query("SELECT * FROM tbl_occ_follow 
								  WHERE occ_id = '$ic'
								  ORDER BY follow_date DESC LIMIT 1");
    	return $data->result();
	}
	public function notif_must_be_close($ocby,$ocid){
		$datamail = $this->GET_MAIL_PERSONEL($ocby);
		$dataior =  $this->Check_Closestats($ocid);
		$ocno	= $dataior[0]->occ_no ;
		$ocsub	= $dataior[0]->occ_sub ;
		$mimail = $datamail[0]->EMAIL ;
		$date = date("d-m-Y");
					$config = Array('protocol'  => 'smtp',
									'smtp_host' => 'mail.gmf-aeroasia.co.id',
									'smtp_port' => 587,
									'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
									'smtp_pass' => 'app.notif',
									'mailtype'  => 'html',
									'charset'   => 'iso-8859-1',
									'wordwrap'  => TRUE );

						$mp 		 = $this->occurrence_model->GET_MAIL_PERSONEL($ocby);
				                	foreach ($mp as $mpd){ 
											$mimail = $mpd->EMAIL; 
									}
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('app.notif@gmf-aeroasia.co.id','IOR accomplish & need verification by (Reporter)');		
						$this->email->bcc(array('danangyogi11@gmail.com'));
						$this->email->to($mimail);
						$this->email->subject('IOR accomplish & need verification by (Reporter)');

						$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>Accordance to Internal Occurrence Report No. "'.$ocno.'" &ndash; "'.$ocsub.' 
									that you have reported,<br>the follow up rectification of this Internal Occurrence Report has already accomplished. Please verify the follow up result until the next 5 days so report will be closed.
									</strong>
									</p>';
						$pesan .= 'Click <a href="https://ior.gmf-aeroasia.co.id/" target="_blank">Here</a> 
									to see detail report via Internal Occurrence Report System.<br><br>';
						$pesan .= ' <br><i style="color: red ;">Note : This is the system generated message. 
										Kindly do not reply.</i>
										<br>Thank you for your attention and good cooperation.
										<p>Cengkareng, "'.$date.'"</p>
									</p>';
						$pesan .= ' <p>	
									<p></p>
								    NEW IOR Application - 2019 (TQY) <br>
								    PT Garuda Maintenance Facility Aero Asia <br>
								    Safety Inspection Unit, Room 1.13, 1st Floor, Hangar 2, Soekarno Hatta Int`l Airport.<br>
								    P : +62 21 550 8190 <br>
								    E : list-TQY@gmf-aeroasia.co.id </p>
									</p>
								   <br>';
						$pesan .= " <img src='http://intranet.gmf-aeroasia.co.id/app_icasset/assets/images/tqy-sgn.jpg'> ";
						$this->email->message($pesan); 
						$this->email->send();
	}
	public function notif_must_be_close_user($ocby,$ocid){
		$datamail = $this->GET_MAIL_PERSONEL($ocby);
		$dataior =  $this->Check_Closestats($ocid);
		$ocno	= $dataior[0]->occ_no ;
		$ocsub	= $dataior[0]->occ_sub ;
		$mimail = $datamail[0]->EMAIL ;
		$date = date("d-m-Y");
					$config = Array('protocol'  => 'smtp',
									'smtp_host' => 'mail.gmf-aeroasia.co.id',
									'smtp_port' => 587,
									'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
									'smtp_pass' => 'app.notif',
									'mailtype'  => 'html',
									'charset'   => 'iso-8859-1',
									'wordwrap'  => TRUE );

						$mp 		 = $this->occurrence_model->GET_MAIL_PERSONEL($ocby);
				                	foreach ($mp as $mpd){ 
											$mimail = $mpd->EMAIL; 
									}
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('app.notif@gmf-aeroasia.co.id','IOR accomplish & need verification by (Admin)');		
						$this->email->bcc(array('danangyogi11@gmail.com'));
						$this->email->to('hariyadi_wirja@gmf-aeroasia.co.id,syafri@gmf-aeroasia.co.id,dimas.prabowo@gmf-aeroasia.co.id,akhmad.aa@gmf-aeroasia.co.id,angga.dwi@gmf-aeroasia.co.id,teguh.rp@gmf-aeroasia.co.id,s.anham@gmf-aeroasia.co.id,m.hafiluddin@gmf-aeroasia.co.id,danang.wl@gmf-aeroasia.co.id,aviecenna@gmf-aeroasia.co.id,dwi.basitha@gmf-aeroasia.co.id,muh.royhan@gmf-aeroasia.co.id,ozzysta.ayudya@gmf-aeroasia.co.id,arief.budiman@gmf-aeroasia.co.id,triawan.r@gmf-aeroasia.co.id,reza.sani@gmf-aeroasia.co.id,ra.nugroho@gmf-aeroasia.co.id,satriana.provis@gmf-aeroasia.co.id');

						$this->email->subject('IOR accomplish & need verification by (Admin)');

						$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>Accordance to Internal Occurrence Report No. "'.$ocno.'" &ndash; "'.$ocsub.' 
									that you have reported,<br>the follow up rectification of this Internal Occurrence Report has already accomplished. Please verify the follow up result until the next 5 days so report will be closed.
									</strong>
									</p>';
						$pesan .= 'Click <a href="https://ior.gmf-aeroasia.co.id/" target="_blank">Here</a> 
									to see detail report via Internal Occurrence Report System.<br><br>';
						$pesan .= ' <br><i style="color: red ;">Note : This is the system generated message. 
										Kindly do not reply.</i>
										<br>Thank you for your attention and good cooperation.
										<p>Cengkareng, "'.$date.'"</p>
									</p>';
						$pesan .= ' <p>	
									<p></p>
								    NEW IOR Application - 2019 (TQY) <br>
								    PT Garuda Maintenance Facility Aero Asia <br>
								    Safety Inspection Unit, Room 1.13, 1st Floor, Hangar 2, Soekarno Hatta Int`l Airport.<br>
								    P : +62 21 550 8190 <br>
								    E : list-TQY@gmf-aeroasia.co.id </p>
									</p>
								   <br>';
						$pesan .= " <img src='http://intranet.gmf-aeroasia.co.id/app_icasset/assets/images/tqy-sgn.jpg'> ";
						$this->email->message($pesan); 
						$this->email->send();
	}
	public function notif_not_close($ocby,$ocid){
		$dataior =  $this->Check_Closestats($ocid);
		$ocno	= $dataior[0]->occ_no ;
		$ocsub	= $dataior[0]->occ_sub ;
		$octo	= $dataior[0]->occ_send_to ;
		$datalastfoll = $this->Check_Last_follow($ocid);
		if (empty($datalastfoll)) {
			$last = '' ;
		}
		else{
			$last = $datalastfoll[0]->follow_next ;	
		}
		if ($last == null || $last == '' || $last == '-' ) {
			$last = $octo ;
		}
		else{
			$last = $datalastfoll[0]->follow_next ; 
		}
		$targunit = substr($last, 0, 3) ; 
		$datamail = $this->GET_MAIL_UNIT($targunit);
		$haha='';
		foreach ($datamail as $datatomail ) {
			$haha .= $datatomail->EMAIL.',' ;
		}
		$mimail_notclose = rtrim($haha, ',');
		
		$date = date("d-m-Y");
					$config = Array('protocol'  => 'smtp',
									'smtp_host' => 'mail.gmf-aeroasia.co.id',
									'smtp_port' => 587,
									'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
									'smtp_pass' => 'app.notif',
									'mailtype'  => 'html',
									'charset'   => 'iso-8859-1',
									'wordwrap'  => TRUE );
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('app.notif@gmf-aeroasia.co.id','IOR Not Clear Notification');		
						$this->email->bcc(array('danangyogi11@gmail.com'));
						$this->email->to($mimail_notclose);
						$this->email->subject('IOR Not Clear Notification');

						$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>Accordance to Internal Occurrence Report No.  "'.$ocno.'" - " '.$ocsub.' "
									that you have request to close, <br>we already verify and evaluate the Internal Occurrence Report. Its stil not clear or still not solved and need more action.</strong>
									</p>';
						$pesan .= 'Click <a href="https://ior.gmf-aeroasia.co.id/" target="_blank">Here</a> 
									to see detail report via Internal Occurrence Report System.<br><br>';
						$pesan .= ' <br><i style="color: red ;">Note : This is the system generated message. 
										Kindly do not reply.</i>
										<br>Thank you for your attention and good cooperation.
										<p>Cengkareng, "'.$date.'"</p>
									</p>';
						$pesan .= ' <p>	
									<p></p>
								    NEW IOR Application - 2019 (TQY) <br>
								    PT Garuda Maintenance Facility Aero Asia <br>
								    Safety Inspection Unit, Room 1.13, 1st Floor, Hangar 2, Soekarno Hatta Int`l Airport.<br>
								    P : +62 21 550 8190 <br>
								    E : list-TQY@gmf-aeroasia.co.id </p>
									</p>
								   <br>';
						$pesan .= " <img src='http://intranet.gmf-aeroasia.co.id/app_icasset/assets/images/tqy-sgn.jpg'> ";
						$this->email->message($pesan); 
						$this->email->send();
	}
	public function notif_are_closed($ocby,$ocid){
		$dataior  	  =  $this->Check_Closestats($ocid);
		$ocno	= $dataior[0]->occ_no ;
		$ocsub	= $dataior[0]->occ_sub ;
		$octo	= $dataior[0]->occ_send_to ;
		$datalastfoll = $this->Check_Last_follow($ocid);
		if (empty($datalastfoll)) {
			$last = '' ;
		}
		else{
			$last = $datalastfoll[0]->follow_next ;	
		}
		if ($last == null || $last == '' || $last == '-' ) {
			$last = $octo ;
		}
		else{
			$last = $datalastfoll[0]->follow_next ; 
		}
		
		$targunit = substr($last, 0, 3) ; 

		$datamail = $this->GET_MAIL_UNIT($targunit);
		$haha='';
		foreach ($datamail as $datatomail ) {
			$haha .= $datatomail->EMAIL.',' ;
		}
		$mimail_close = rtrim($haha, ',');
		
		$date = date("d-m-Y");
					$config = Array('protocol'  => 'smtp',
									'smtp_host' => 'mail.gmf-aeroasia.co.id',
									'smtp_port' => 587,
									'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
									'smtp_pass' => 'app.notif',
									'mailtype'  => 'html',
									'charset'   => 'iso-8859-1',
									'wordwrap'  => TRUE );

						$mp 		 = $this->occurrence_model->GET_MAIL_PERSONEL($ocby);
				                	foreach ($mp as $mpd){ 
											$mimail = $mpd->EMAIL; 
									}
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('app.notif@gmf-aeroasia.co.id','IOR accomplish & Closed');		
						$this->email->bcc(array('danangyogi11@gmail.com'));
						$this->email->to($mimail_close);
						$this->email->subject('IOR accomplish & Closed');

						$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>We already verify and evaluate the follow up rectification of the Internal Occurrence 
									Report No. "'.$ocno.'" &ndash; "'.$ocsub.'"  which sent to your unit, 
									<br>It`s already addressing the potential hazard that appears and complies with safety standards. 
									IOR is closed, thank you for joining our safety reporting.</strong>
									</p>';
						$pesan .= 'Click <a href="https://ior.gmf-aeroasia.co.id/" target="_blank">Here</a> 
									to see detail report via Internal Occurrence Report System.<br><br>';
						$pesan .= ' <br><i style="color: red ;">Note : This is the system generated message. 
										Kindly do not reply.</i>
										<br>Thank you for your attention and good cooperation.
										<p>Cengkareng, "'.$date.'"</p>
									</p>';
						$pesan .= ' <p>	
									<p></p>
								    NEW IOR Application - 2019 (TQY) <br>
								    PT Garuda Maintenance Facility Aero Asia <br>
								    Safety Inspection Unit, Room 1.13, 1st Floor, Hangar 2, Soekarno Hatta Int`l Airport.<br>
								    P : +62 21 550 8190 <br>
								    E : list-TQY@gmf-aeroasia.co.id </p>
									</p>
								   <br>';
						$pesan .= " <img src='http://intranet.gmf-aeroasia.co.id/app_icasset/assets/images/tqy-sgn.jpg'> ";
						$this->email->message($pesan); 
						$this->email->send();
	}
	public function GetNumber($id) {
	    	$data = $this->db->query("SELECT * FROM tbl_occ_ohr WHERE occ_id = '$id'");
	    	return $data->result();
	}

	function emailsend($id)
	{
		$this->db->select('created_by,occ_id,occ_sub,occ_no,occ_send_to');
		$this->db->where('occ_id',$id);
		return $query = $this->db->get('tbl_occ')->row_array();
		// print_r($query);
		// die();
	}

	function sendtounit($unit)
	{
		$this->employe = $this->load->database('employee_back',TRUE);
		$data = $this->employe->query("SELECT nama,unit,EMAIL FROM v_tabpersonel_active WHERE unit LIKE '%$unit%'  LIMIT 100");
   	 	return $data->result_array();
	}
	

}