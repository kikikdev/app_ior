
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('occurrence_model');
		$this->load->model('setting_model');
	}
	public function index(){
		$this->page->template('login_tpl');
		$this->page->view();
	}
	public function index2(){
		$this->load->library('user_agent');
		if ($this->agent->is_browser()){
		        $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot()){
		        $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile()){
		        $agent = $this->agent->mobile();
		}
		else{
		        $agent = 'Unidentified User Agent';
		}
		echo $agent;
		echo $this->agent->platform();
	}
	public function login(){
		ini_set("max_execution_time","0");
		// //$password	= "iormaster"; 
		$username 	= $this->input->post('uname');   
		$password 	= $_POST['pwd'];
		$password   = str_replace("'","-", $password);
		
		if ($username != null AND $password != null ) {
	 		$dn = "DC=gmf-aeroasia,DC=co,DC=id";
		    $ldapconn 	= ldap_connect("192.168.240.66") or die ("Could not connect to LDAP server.");
		    if ($ldapconn) {
							ldap_set_option(@$ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
							ldap_set_option(@$ldapconn, LDAP_OPT_REFERRALS,0);
			$ldapbind = ldap_bind($ldapconn, "ldap", "aeroasia");
				if($ldapbind){
					@$sr		= ldap_search($ldapconn, $dn, "samaccountname=$username");
					@$srmail	= ldap_search($ldapconn, $dn, "mail=$username@gmf-aeroasia.co.id"); 				
					@$info 		= ldap_get_entries($ldapconn, @$sr);
					@$infomail 	= ldap_get_entries($ldapconn, @$srmail);
					@$usermail	= substr(@$infomail[0]["mail"][0], 0, strpos(@$infomail[0]["mail"][0], '@'));
					@$bind		= @ldap_bind($ldapconn, $info[0][dn], $password);
					if ((@$info[0]["samaccountname"][0] != $username) AND (@$usermail != $username)){
							$pass = password($password);
							$src = $this->setting_model->Get_Auth($username,$pass);
							if ($src->num_rows() == 0) {
								$this->session->set_flashdata('status', 'failed');
								// echo "users not exist wherever OR wrong password!";
								//redirect(base_url());
								echo "2";
							}
							else {
								$users = $src->row();
								$this->session->set_userdata('occ_users_1103', $users);
								echo "1";
								//redirect(site_url('dashboard'));
							}
						} 
					else {
							if ((@$info[0]["samaccountname"][0] == $username AND $bind) OR (@$usermail == $username AND $bind)){ 
								$srcad = $this->db->query("SELECT id,username,name,role,unit 
															FROM users 
															WHERE username = '$username'");    
			                        if ($srcad->num_rows() == 1) {
			                        	$users = $srcad->row();
										echo "1";
										$this->session->set_userdata('occ_users_1103', $users);
										redirect(site_url('dashboard'));
			                        }
			                        else{
						                $this->employe = $this->load->database('employe',TRUE);

						                $srcad = $this->employe->query("
									                	SELECT '-' as id,a.PERNR as username,a.EMPLNAME as name,a.JABATAN, a.UNIT as unit, '0' as role , a.EMAIL
														FROM TBL_SOE_HEAD a
														WHERE CONVERT(VARCHAR(20),a.PERNR)  = '$username'
														OR a.EMAIL = '$username@gmf-aeroasia.co.id'			
						                								");
						                $users = $srcad->row();
						                $this->session->set_userdata('occ_users_1103',$users);
						                echo "1";
				                     	//redirect(site_url('dashboard'));
				                        }
							}
							else{
								// echo "Your username is exist on LDAP, but your password is wrong " ;
								//redirect(site_url('dashboard'));
								echo "3";
							}
						}
					ldap_close($ldapconn);
				}
			}
		}
		else {
			echo "LDAP Connection trouble,, please try again 2/3 time";
			//redirect(site_url('dashboard'));
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	public function ftp_attach(){
            $config['upload_path'] 	  = 'uploads/';
            $config['allowed_types']  = '*';
            // $config['allowed_types']  = 'jpeg|gif|jpg|png|mp4|flv|pdf|doc|docx|xls|xlsx|ppt';
            $this->load->library('upload', $config);
            
            if($this->upload->do_upload('fileattach')){
                //Get uploaded file information
                $upload_data = $this->upload->data();
                $fileName = $upload_data['orig_name'];
                //File path at local server
                $source = 'uploads/'.$fileName;
                //Load codeigniter FTP class
                $this->load->library('ftp');
                
                //FTP configuration
                // prod
                $ftp_config['hostname'] = 'tq-stg.gmf-aeroasia.co.id';
                // $ftp_config['hostname'] = '192.168.40.107';
                 $ftp_config['username'] = 'ior';
                 $ftp_config['password'] = 'aeroasia';
                // dev
                //$ftp_config['hostname'] = '192.168.40.127';
                //$ftp_config['username'] = 'usergmf';
                //$ftp_config['password'] = 'aeroasia';
                $ftp_config['debug']    = TRUE;
                
                //Connect to the remote server
                $this->ftp->connect($ftp_config);
                //File upload path of remote server
                $header = date('dmy_his');
                $header = preg_replace('/\s/','',$header);
				$fileName =  $header.$fileName ;
				//prod
				$destination = '/Upload_IOR/'.$fileName;
				//dev
                //$destination = '/File_IOR_TEST/Uploads/'.$fileName;
                //Upload file to the remote server
                $this->ftp->upload($source, ".".$destination);
                //Close FTP connection
                $this->ftp->close();
                return array('status'=>'1', 'message'=>$fileName);
            }
    }
	public function send_ior(){
		// $this->load->library('ftp');
		// $upload = $this->ftp_attach();
		// $upload = $this->ftp_attach_ku();

		// if($upload['status'] == '1'){
		// 	$file = $upload['message'];
		// 	$file = preg_replace('/\s/','',$file);
		// }

		// if (!$file || $file == null) {
		// 	echo "file type NOT allowed !!!";
		// }

		$header = date("m/Y");
		$beginday= date("Y-m-d");
		$id 	= $this->occurrence_model->GetMaxID_need_verified();
	                foreach ($id as $plist){ 
							$GetMaxID = $plist->MaxID; 
							$GetMaxID = str_pad($GetMaxID + 1, 3, 0, STR_PAD_LEFT);
							$GetMaxID = substr($GetMaxID, 0,3);
							$GetMaxID = $GetMaxID.'/'.$header.'/NV' ;
					}
		if ($GetMaxID == null || $GetMaxID == '') {
		 		$GetMaxID = '001/'.$header.'NV' ;
		}



		// $dataOccFile = array (	
		// 	'file_name'		=> preg_replace('!\s+!', '_',  $file),
		// 	'file_type'		=> substr($file, -3),
 	// 		'occ_id'		=> $GetMaxID,
		// );
		// $isfineFile = $this->occurrence_model->Insert('tbl_occ_file', $dataOccFile);

		$occ_file_name	= $this->input->POST('file_name');

		if($occ_file_name || !empty($occ_file_name) || !is_null($occ_file_name)){
		foreach ($occ_file_name as $keys => $value) {
		$dataOccFile = array (	
			'file_name'		=> preg_replace('!\s+!', '_',  $occ_file_name[$keys]),
			'file_type'		=> substr($occ_file_name[$keys], -3),
			'occ_id'		=> $GetMaxID,
		);
		 $isfineFile = $this->occurrence_model->Insert('tbl_occ_file', $dataOccFile);
		}}

		$occ_no 		=   $GetMaxID;
		$occ_sub		=	$this->input->POST('occ_subject');	
		$occ_detail		=	$this->input->POST('occ_detail');
		$ocd = str_replace("'"," ",$occ_detail);
		$occ_risk_index	=	'0';
		$occ_probability=	'0';
		$occ_severity	=	'0';
		$occ_reff		=	$this->input->POST('occ_reference');
		$occ_ambiguity	=	'0';
		$occ_date		= 	$this->input->POST('occ_date') . date(" H:i:s");
		$created_date	=	date("Y-m-d H:i:s");
		$occ_category 		= '8';
		$occ_sub_category 	= '79';
		$sub_category_spec	= '';
		$occ_level_type		= '';
		$occ_level_sub		= '';
		$occ_level_sub_child= '';
		$occ_status			= 	"1";
		$occ_send_to 		= 'N/A';
		$occ_follow_last_by = 'N/A' ;
		$occ_by 			= $this->input->POST('occ_sender_mail');
		$occ_by_name 		= $this->input->POST('occ_sender_name');
		$occ_by_unit 		= 'UNKNOWN';
		$occ_permission 	=  "0" ;
		$occ_hide_reporter  = $this->input->POST('hide_reporter'); 
		$occ_est_finish		= date('Y-m-d', strtotime($beginday. ' + 9 weekdays'));
									$beginday= date("Y-m-d");
                                    $lastday = date('Y-m-d', strtotime($beginday. ' + 3 weekdays'));
		$occ_response_date  = $lastday ;
			$dataOcc 		= array( 'occ_no'   => $occ_no,
						      'occ_sub'			=> $occ_sub,
						      'occ_detail'		=> $ocd,
						      'occ_risk_index'  => $occ_risk_index,
							  'occ_probability' => $occ_probability,
							  'occ_severity'	=> $occ_severity,
						      'occ_reff'		=> $occ_reff,
						      'occ_ambiguity' 	=> $occ_ambiguity,
						      'occ_date'		=> $occ_date,
						      'occ_estfinish_date' => $occ_est_finish,
						      'occ_response_date' => $occ_response_date,
						      'occ_category'	=> $occ_category,
						      'occ_sub_category'=> $occ_sub_category,
						      'occ_sub_spec'	=> $sub_category_spec,
						      'occ_level_type'	=> $occ_level_type,
						      'occ_level_sub '  => $occ_level_sub,
						      'occ_level_sub_child' => $occ_level_sub_child,
						      'occ_status'		=> $occ_status,
						      'occ_send_to'		=> $occ_send_to,
						      'created_date'	=> $created_date,
						      'created_by'		=> $occ_by,
						      'created_by_name'	=> $occ_by_name,
						      'created_by_unit'	=> $occ_by_unit,
						      'permission'		=> $occ_permission,
						      'created_hide'	=> $occ_hide_reporter,
						      'occ_confirm_stats'	=> '1',
						      'occ_follow_last_by'	=> $occ_follow_last_by,
							);
			$dataVendor = array(  'email'		=> $occ_by_name,
								  'name'		=> $occ_by,
								  'occ_no'		=> $GetMaxID,
							);
			$isfineVendor = $this->occurrence_model->Insert('tbl_vendored_mail', $dataVendor);

		    $isfineOcc = $this->occurrence_model->Insert('tbl_occ', $dataOcc);
				if ($isfineOcc){
						echo json_encode(array("status" => TRUE ,
												"target" => $occ_no ));
		        }
	}
	public function GET_MAIL_UNIT($repto){
		$this->employe = $this->load->database('employe',TRUE);
		$data = $this->employe->query("	SELECT EMAIL,UNIT,JABATAN
					                    FROM TBL_SOE_HEAD a
					                    WHERE a.unit  LIKE '%".$repto."%'
					                    AND EMAIL != ''")->result();
		$get_unit = $this->db->query("SELECT group_unit FROM tbl_group_unit WHERE unit = '$repto'")->result_array();

		$bismillah = "";
        foreach ($get_unit as $get_unit) {
                $bismillah .= "'".$get_unit['group_unit']."'".",";
             }
        $alhamdulillah = rtrim($bismillah, ",");
		$get_email = $this->employe->query("SELECT UNIT, EMAIL from TBL_SOE_HEAD WHERE UNIT IN ($alhamdulillah) AND EMAIL != ''")->result();
		$datafinal = array_merge($data,$get_email);
		return $datafinal;
		// return $data->result();
	}
	public function Check_Last_follow($ic){
    	$data = $this->db->query("SELECT * FROM tbl_occ_follow 
								  WHERE occ_id = '$ic'
								  ORDER BY follow_date DESC LIMIT 1");
    	return $data->result();
	}
	public function REMINDER_6DAYS_IOR_OPEN_NO_RESPONSE(){
		$schtask	= 'NOTIF_ON_OPEN_OVERDUE_LAST';
		$schtime 	= date("Y-m-d H:i:s");
		$schlog 	= array( 'sched_runing'	=> $schtask,
							 'sched_at'		=>  $schtime,
							);
		$schlogstats 	= $this->occurrence_model->Insert('scheduler_log', $schlog);
		$config = Array('protocol'  => 'smtp',
									'smtp_host' => 'mail.gmf-aeroasia.co.id',
									'smtp_port' => 25,
									'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
									'smtp_pass' => 'app.notif',
									'mailtype'  => 'html',
									'charset'   => 'iso-8859-1',
									'wordwrap'  => TRUE );
		$date = date("d-m-Y");
		$sixdays = $this->db->query("SELECT occ_id,occ_no,occ_estfinish_date,occ_send_to,occ_sub,
											DATEDIFF(CURDATE(),occ_estfinish_date) AS OVERDUEDAYS
								   	FROM tbl_occ
								   	WHERE (occ_status = '1' AND occ_confirm_stats = '1' AND permission = '1')
								   	AND (DATEDIFF(CURDATE(),occ_estfinish_date)  =  '5')
								   ")->result();
		foreach ($sixdays as $datasixdays ) {
			$ocno  = $datasixdays ->occ_no ;
			$ocid  = $datasixdays ->occ_id ;
			$octo  = $datasixdays ->occ_send_to ;
			$ocsub = $datasixdays ->occ_sub ;
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
			$mimail_overdue = rtrim($haha, ',');
			
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('app.notif@gmf-aeroasia.co.id','IOR overdue response after 5 days');		
			$this->email->bcc(array('danangyogi11@gmail.com'));
			$this->email->to($mimail_overdue);
			$this->email->subject('IOR overdue response after 5 days');

			$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>REMINDER #1 <br>
										Please perform the follow-up of this Internal Occurrence Report No."'.$ocno.' - '.$ocsub.'" which sent to your unit before the report overdue. 
										<br>
										Please immediately respond this occurrence report because if no response within 5 days then IOR system will issue NCR (Ref. QP 218-01).
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
			$dataOcc 		= array( 'occ_id'	=> $ocid,
								     'occ_no'	=> $ocno,
								     'to_unit'	=> $targunit,
								     'days'		=> '11days',
								    );
		    $isfineOcc = $this->occurrence_model->Insert('reminder_log', $dataOcc);
		}
	}
	public function REMINDER_6DAYS_IOR_OPEN_NO_RESPONSE_2(){
		$schtask	= 'NOTIF_ON_OPEN_OVERDUE_LAST';
		$schtime 	= date("Y-m-d H:i:s");
		$schlog 	= array( 'sched_runing'	=> $schtask,
							 'sched_at'		=>  $schtime,
							);
		$schlogstats 	= $this->occurrence_model->Insert('scheduler_log', $schlog);
		$config = Array('protocol'  => 'smtp',
						'smtp_host' => 'mail.gmf-aeroasia.co.id',
						'smtp_port' => 25,
						'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
						'smtp_pass' => 'app.notif',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1',
						'wordwrap'  => TRUE );
		$date = date("d-m-Y");
		$sixdays = $this->db->query("SELECT occ_id,occ_no,occ_estfinish_date,occ_send_to,occ_sub,
											DATEDIFF(CURDATE(),occ_estfinish_date) AS OVERDUEDAYS
								   	FROM tbl_occ
								   	WHERE (occ_status = '1' AND occ_confirm_stats = '1' AND permission = '1')
								   	AND (DATEDIFF(CURDATE(),occ_estfinish_date)  >=  '10')
								   ")->result();
		foreach ($sixdays as $datasixdays ) {
			$ocno  = $datasixdays ->occ_no ;
			$ocid  = $datasixdays ->occ_id ;
			$octo  = $datasixdays ->occ_send_to ;
			$ocsub = $datasixdays ->occ_sub ;
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
			$mimail_overdue = rtrim($haha, ',');
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('app.notif@gmf-aeroasia.co.id','IOR overdue response after 5 days & will issued NCR');		
			$this->email->bcc(array('danangyogi11@gmail.com'));
			$this->email->to($mimail_overdue);
			$this->email->subject('IOR overdue response after 5 days & will issued NCR');
			$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>REMINDER #2 <br>
										Please perform the follow-up of this Internal Occurrence Report No."'.$ocno.' - '.$ocsub.'" which sent to your unit before the report overdue. 
										<br>
										 Please immediately respond this occurrence report .<br>
										 Because if no response then <i style="color : orange">Tomorrow</i> IOR system will issue NCR (Ref. QP 218-01).
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
			$dataOcc 		= array( 'occ_id'	=> $ocid,
								     'occ_no'	=> $ocno,
								     'to_unit'	=> $targunit,
								     'days'		=> '11days',
								    );
		    $isfineOcc = $this->occurrence_model->Insert('reminder_log', $dataOcc);
		}
	}
	public function REMINDER_6DAYS_IOR_OPEN_PROGRES(){
		$schtask	= 'NOTIF_ON_PROGRESS_OVERDUE';
		$schtime 	= date("Y-m-d H:i:s");
		$schlog 	= array( 'sched_runing'	=> $schtask,
							 'sched_at'		=>  $schtime,
							);
		$schlogstats 	= $this->occurrence_model->Insert('scheduler_log', $schlog);
		$config = Array('protocol'  => 'smtp',
						'smtp_host' => 'mail.gmf-aeroasia.co.id',
						'smtp_port' => 25,
						'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
						'smtp_pass' => 'app.notif',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1',
						'wordwrap'  => TRUE );
		$date = date("d-m-Y");
		$sixdays = $this->db->query("SELECT occ_id,occ_no,occ_estfinish_date,occ_send_to,occ_sub,
											DATEDIFF(CURDATE(),occ_estfinish_date) AS OVERDUEDAYS
								   	FROM tbl_occ
								   	WHERE (occ_status = '1' AND occ_confirm_stats = '2' AND permission = '1')
								   	AND (DATEDIFF(CURDATE(),occ_estfinish_date)  =  '5')
								   ")->result();
		foreach ($sixdays as $datasixdays ) {
			$ocno  = $datasixdays ->occ_no ;
			$ocid  = $datasixdays ->occ_id ;
			$octo  = $datasixdays ->occ_send_to ;
			$ocsub = $datasixdays ->occ_sub ;
			
			$targunit = substr($octo, 0, 3) ; 
			$datamail = $this->GET_MAIL_UNIT($targunit);
			$haha='';
			foreach ($datamail as $datatomail ) {
				$haha .= $datatomail->EMAIL.',' ;
			}
			$mimail_overdue = rtrim($haha, ',');
			
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('app.notif@gmf-aeroasia.co.id','IOR will Overdue Follow Up');		
			$this->email->bcc(array('danangyogi11@gmail.com'));
			$this->email->to($mimail_overdue);
			$this->email->subject('IOR will Overdue Follow Up');

			$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>REMINDER #1 <br>
										Please perform the proper follow-up immediately of Internal Occurrence Report No."'.$ocno.' - '.$ocsub.'" because tomorrow the report will be OVERDUE. Now, IOR still in progress and under monitoring, we want hear back from you soon.
										<br>
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

			$dataOcc 		= array( 'occ_id'	=> $ocid,
								     'occ_no'	=> $ocno,
								     'to_unit'	=> $targunit,
								     'days'		=> '1days Overdue on progress',
								    );
		    $isfineOcc = $this->occurrence_model->Insert('reminder_log', $dataOcc);
		}
	}
	public function REMINDER_IOR_HASBEEN_CLOSED_TO_NCR(){
		$schtask	= 'CLOSED_TO_NCR';
		$schtime 	= date("Y-m-d H:i:s");
		$schlog 	= array( 'sched_runing'	=> $schtask,
							 'sched_at'		=>  $schtime,
							);
		$schlogstats 	= $this->occurrence_model->Insert('scheduler_log', $schlog);
		$config = Array('protocol'  => 'smtp',
						'smtp_host' => 'mail.gmf-aeroasia.co.id',
						'smtp_port' => 25,
						'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
						'smtp_pass' => 'app.notif',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1',
						'wordwrap'  => TRUE );
		$date = date("d-m-Y");
		$sixdays = $this->db->query("SELECT occ_id,occ_date,occ_no,occ_estfinish_date,occ_send_to,occ_sub,
											DATEDIFF(CURDATE(),occ_estfinish_date) AS OVERDUEDAYS
								   	FROM tbl_occ
								   	WHERE (occ_date BETWEEN '2018-01-01' AND '2018-05-31') 
										AND (occ_status = '1' AND occ_confirm_stats = '1' AND permission = '1')
								   	AND (DATEDIFF(CURDATE(),occ_estfinish_date)  >=  '11')
								   	")->result();
		foreach ($sixdays as $datasixdays ) {
			$ocno  = $datasixdays ->occ_no ;
			$ocid  = $datasixdays ->occ_id ;
			$octo  = $datasixdays ->occ_send_to ;
			$ocsub = $datasixdays ->occ_sub ;
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
			$targunit = substr($last, 0, 3);
			$datamail = $this->GET_MAIL_UNIT($targunit);
			$haha='';
			foreach ($datamail as $datatomail ) {
				$haha .= $datatomail->EMAIL.',' ;
			}
			$mimail_overdue = rtrim($haha, ',');
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('app.notif@gmf-aeroasia.co.id','IOR closed due to issued NCR');		
			$this->email->bcc(array('danangyogi11@gmail.com,list-QSA@gmf-aeroasia.co.id'));
			$this->email->to($mimail_overdue);
			$this->email->subject('IOR closed due to issued NCR');
			$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
								"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
								</head>';
						$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
						$pesan .= ' <p>
									<strong>REMINDER #1 <br>
									Accordance to Internal Occurrence Report No."'.$ocno.' - '.$ocsub.'" that you have reported, <br>
									IOR is automatically closed and become Non Conformance Report (NCR) because responsible unit "'.$targunit.'" has not accomplish the follow up rectification. IOR is closed, thank you for joining our safety reporting.
										<br>
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

			$dataOcc 		= array( 'occ_id'	=> $ocid,
								     'occ_no'	=> $ocno,
								     'to_unit'	=> $targunit,
								     'days'		=> '1days Overdue on progress',
								    );
		    $isfineOcc = $this->occurrence_model->Insert('reminder_log', $dataOcc);
		}
	}

	public function ftp_attach_ku(){
			$this->load->library('ftp');
            $config['upload_path'] = 'uploads/';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            
            if($this->upload->do_upload('file')){
                //Get uploaded file information
                $upload_data = $this->upload->data();
                $fileName = $upload_data['orig_name'];
                //File path at local server
                $source = 'uploads/'.$fileName;
                //Load codeigniter FTP class
                $this->load->library('ftp');
                
                //FTP configuration prod
                $ftp_config['hostname'] = 'tq-stg.gmf-aeroasia.co.id';
                //$ftp_config['hostname'] = '192.168.40.107';
                $ftp_config['username'] = 'ior';
				$ftp_config['password'] = 'aeroasia';
				//dev
                // $ftp_config['hostname'] = '192.168.40.127';
                // $ftp_config['username'] = 'usergmf';
                // $ftp_config['password'] = 'aeroasia';
                $ftp_config['debug']    = TRUE;
                
                //Connect to the remote server
                $this->ftp->connect($ftp_config);
                //File upload path of remote server
                $header = date('dmy_his');
                $header = preg_replace('/\s/','',$header);
                $fileName =  $header.$fileName ;
                //prod
                $destination = '/Upload_IOR/'.$fileName;
                //dev
                //$destination = '/File_IOR_TEST/Uploads/'.$fileName;
                //Upload file to the remote server
                $this->ftp->upload($source, ".".$destination);
                //Close FTP connection
                $this->ftp->close();
                return array('status'=>'1', 'message'=>$fileName);
            }
    }

    public function upload_guest(){
		//create directory years
		$folderName = date('Y');
        $pathToUpload = $this->config->item('upload').$folderName;
        if (! file_exists($pathToUpload)) {
            $createDir  = mkdir($pathToUpload, 0777, true);
		}
		
    	$fileold = $_FILES['file']['name'];
    	$file = str_replace(' ', '_', $fileold);
    	// var_dump($file);die;
    	$header = date('dmy_his');
        $header = preg_replace('/\s/','',$header);
        $fileName =  $header.$file;
		//$config['upload_path'] 		= '/var/www/html/app_ior/upload_guest/'; //file lama yg guest disini
		$config['upload_path'] = $pathToUpload.'/';
		$config['allowed_types'] 	= '*';
		$config['file_name'] = $fileName;
        $this->load->library('upload', $config);
    	$ok = $this->upload->initialize($config);
    	$this->upload->do_upload('file');
		return array('status'=>'1', 'message'=>$fileName);
		
    }

	public function attach_ftp_guest(){
		
		$upload = $this->upload_guest();
		// var_dump($upload);
			if($upload['status'] == '1'){
			$file = $upload['message'];
			$file = preg_replace('/\s/','',$file);
		}

		echo "$file";
		// var_dump($upload);
	}	
}
/* End of file site.php */