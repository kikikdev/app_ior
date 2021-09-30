<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Occurrence extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('occurrence_model');
	} 
	public function index(){
		echo "Opps you cannot here :P !";
	}

	public function getjsresponse(){
		echo json_encode('Are you see the truth?');
	}
	public function getkaryawan($nopeg){
		$detail = $this->occurrence_model->Get_detail_karyawan($nopeg);
		echo json_encode($detail);
	}

	function get_occ_by_unit() {
		$byself = $this->session->userdata('occ_users_1103')->role; 
		if ($byself == 1) {
			$todetail = $this->occurrence_model->Getoccunit();
		}
		else{
			$todetail = $this->occurrence_model->Getoccunit_out();
		}	
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $sign 	 = substr($detaildata->occ_no, -2);
			                    $tempocc = rtrim($detaildata->occ_no, 'NV');
			                    $row[] 	= $tempocc.'<span style="color: orange;">'.$sign.'</span>' ;
			                    $row[] 	= '<a href="#" onclick="v_occ_detaiI('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by_name;
			                    if ($detaildata->occ_send_to == 'N/A') {
			                    	$row[] = '<label class="badge badge-unknown">Unknown</label>' ;
			                    }
			                    else{
			                    $row[] 	= $detaildata->occ_send_to;
			                    }
			                    if ($detaildata->occ_follow_last_by == 'N/A') {
			                    		$row[] 	= '<label class="badge badge-unknown">Unknown</label>';
			                    }
			                    else{
			                    	$row[] 	= $detaildata->occ_follow_last_by;	
			                    }
			                    $row[] 	= $detaildata->created_date;
			                    if ($permission == 1 ) { $row[] = '<label class="badge badge-warning">Verified</label>' ; } 
			                    else { 
			                    	if ($detaildata->countdown >= 0) {
			                    		$row[] = '<label class="badge badge-danger">Need Verification</label>' ; 
			                    	}
			                    	else{
			                    	$row[] = '<label class="badge badge-needver">Need Verification</label>' ; 
			                    	}
			                    } 
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_by_unit_in() {
		$todetail = $this->occurrence_model->Getoccunit_verified();
		
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_occ_detail('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by_name;
			                    if ($detaildata->occ_send_to == 'N/A') {
			                    	$row[] = '<label class="badge badge-danger">Unknown UIC</label>' ;
			                    }
			                    else{
			                    $row[] 	= $detaildata->occ_send_to;
			                    }
			                    $row[] 	= $detaildata->occ_follow_last_by;	
			                    $row[] 	= $detaildata->created_date;
			                    if ($permission == 1 ) { $row[] = '<label class="badge badge-warning">Verified</label>' ; } else { $row[] = '<label class="badge badge-needver">Need Verification</label>' ; } 
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_by_unit_verified() {	
		$todetail = $this->occurrence_model->Getoccunit_verified();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $occ_stats = $detaildata->occ_status;
			                    $confirmed_stats = $detaildata->occ_confirm_stats;
			                    $lu = $detaildata->occ_follow_last_by;
			                    $overdue = $detaildata->duedate;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_occ__detail('.$detaildata->occ_id.')">'.substr($detaildata->occ_sub,0,25).'...</a>';
			                    $row[] 	= $detaildata->occ_date;
								if ($detaildata->created_hide == 1){
									$row[] 	= '(H) '.$detaildata->created_by_name;
								}
								else{
									$row[] 	= $detaildata->created_by_name;
								}
			                    
			                    $row[] 	= $detaildata->occ_send_to;
			                    if ($detaildata->occ_follow_last_by == 'N/A') {
			                    		$row[] 	= '<label class="badge badge-unknown">Unknown</label>';
			                    }
			                    else{
			                    	$row[] 	= $detaildata->occ_follow_last_by;	
			                    }
			                    $row[] 	= $detaildata->created_date;

			                    if ($permission == 1 AND $overdue >= 0 AND $confirmed_stats != 0 AND $occ_stats != 0 AND $confirmed_stats != 3 AND $occ_stats != 3) {
			                    	$row[] = '<label class="badge badge-danger">OVERDUE</label>';
			                    }else{
				                    if ($permission == 1 AND $confirmed_stats == 1 AND $occ_stats == 1 AND $lu == '-' ) { 	
				                    		$row[] = '<label class="badge badge-warning">Open</label>
				                    				  <label class="badge badge-danger">No Follow</label>' ; 
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 1 AND $occ_stats == 1 AND $lu != '-' ) { 	
				                    		$row[] = '<label class="badge badge-warning">Open</label>' ; 
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 2) { 	
				                    		$row[] = '<label class="badge badge-succes">Progress</label>';
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 1) { 	
				                    		$row[] = '<label class="badge badge-succes">Waiting Close</label>';
				                    		}
				                   	else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 3) {
				                    		$row[] = '<label class="label label-success label-form">Closed</label>';
				                    		} 
				                    else if ($permission == 1 AND $confirmed_stats == 4 AND $occ_stats == 4) {
				                    		$row[] = '<label class="badge badge-ohr">OHR</label>';
				                    		} 
	            					else if ($permission == 1 AND $confirmed_stats == 0 AND $occ_stats == 0) {
	            						if ($detaildata->occ_probability == 1) {
	            							$row[] = '<label class="badge badge-ncrclosed">Closed</label>' ; 
	            						}
	            						else if ($detaildata->occ_probability == 0) {
	            							$row[] = '<label class="badge badge-ncreleased">NCR Release</label>' ; 
	            						}
	            						else{
	            							$row[] = '<label class="badge badge-danger">NCR</label>' ; 	
	            						}
	            							
	            					}
	            				} 
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_by_unit_verified_waiting_close() {	
		$todetail = $this->occurrence_model->Getoccunit_verified_waiting_close();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $occ_stats = $detaildata->occ_status;
			                    $confirmed_stats = $detaildata->occ_confirm_stats;
			                    $lu = $detaildata->occ_follow_last_by;
			                    $overdue = $detaildata->duedate;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" id="'.$detaildata->occ_id.'" wts="'.$detaildata->WAITINGSTATS.'" onclick="v_occ__detail('.$detaildata->occ_id.')">'.substr($detaildata->occ_sub,0,25).'...</a>';
			                    $row[] 	= $detaildata->occ_date;
								if ($detaildata->created_hide == 1){
									$row[] 	= '(H) '.$detaildata->created_by_name;
								}
								else{
									$row[] 	= $detaildata->created_by_name;
								}
			                    
			                    $row[] 	= $detaildata->occ_send_to;
			                    if ($detaildata->occ_follow_last_by == 'N/A') {
			                    		$row[] 	= '<label class="badge badge-unknown">Unknown</label>';
			                    }
			                    else{
			                    	$row[] 	= $detaildata->occ_follow_last_by;	
			                    }
			                    $row[] 	= $detaildata->created_date;

			                    if ($permission == 1 AND $overdue >= 0 AND $confirmed_stats != 0 AND $occ_stats != 0 AND $confirmed_stats != 3 AND $occ_stats != 3) {
			                    	$row[] = '<label class="badge badge-danger">OVERDUE</label>';
			                    }else{
				                    if ($permission == 1 AND $confirmed_stats == 1 AND $occ_stats == 1 AND $lu == '-' ) { 	
				                    		$row[] = '<label class="badge badge-warning">Open</label>
				                    				  <label class="badge badge-danger">No Follow</label>' ; 
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 1 AND $occ_stats == 1 AND $lu != '-' ) { 	
				                    		$row[] = '<label class="badge badge-warning">Open</label>' ; 
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 2) { 	
				                    		$row[] = '<label class="badge badge-succes">Progress</label>';
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 1) { 	
				                    		if ($detaildata->WAITINGSTATS >= '6') {
				                    			$row[] = '<label class="badge badge-danger">Waiting Close</label>';
				                    		}
				                    		else{
				                    			$row[] = '<label class="badge badge-succes">Waiting Close</label>';
				                    		}
				                    		}
				                   	else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 3) {
				                    		$row[] = '<label class="label label-success label-form">Closed</label>';
				                    		} 
				                     
	            					else if ($permission == 1 AND $confirmed_stats == 0 AND $occ_stats == 0) {
	            							$row[] = '<label class="badge badge-danger">NCR</label>' ; 
	            					}
	            				} 
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_by_unit_verified_by_year($id) {	
		$id = substr($id, 0 , 4) ;
		if ($id == '0000') {
			$id = '0000' ;
		}
		else{
			$id = substr($id, 0 , 4) ; 
		}
		$todetail = $this->occurrence_model->Getoccunit_verified_by_year($id);
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $occ_stats = $detaildata->occ_status;
			                    $confirmed_stats = $detaildata->occ_confirm_stats;
			                    $lu = $detaildata->occ_follow_last_by;
			                    $overdue = $detaildata->duedate;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_occ__detail('.$detaildata->occ_id.')">'.substr($detaildata->occ_sub,0,25).'...</a>';
			                    $row[] 	= $detaildata->occ_date;
								if ($detaildata->created_hide == 1){
									$row[] 	= '(H) '.$detaildata->created_by_name;
								}
								else{
									$row[] 	= $detaildata->created_by_name;
								}
			                    
			                    $row[] 	= $detaildata->occ_send_to;
			                    if ($detaildata->occ_follow_last_by == 'N/A') {
			                    		$row[] 	= '<label class="badge badge-unknown">Unknown</label>';
			                    }
			                    else{
			                    	$row[] 	= $detaildata->occ_follow_last_by;	
			                    }
			                    $row[] 	= $detaildata->created_date;

			                    if ($permission == 1 AND $overdue >= 0 AND $confirmed_stats != 0 AND $occ_stats != 0 AND $confirmed_stats != 3 AND $occ_stats != 3) {
			                    	$row[] = '<label class="badge badge-danger">OVERDUE</label>';
			                    }else{
				                    if ($permission == 1 AND $confirmed_stats == 1 AND $occ_stats == 1 AND $lu == '-' ) { 	
				                    		$row[] = '<label class="badge badge-warning">Open</label>
				                    				  <label class="badge badge-danger">No Follow</label>' ; 
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 1 AND $occ_stats == 1 AND $lu != '-' ) { 	
				                    		$row[] = '<label class="badge badge-warning">Open</label>' ; 
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 2) { 	
				                    		$row[] = '<label class="badge badge-succes">Progress</label>';
				                    		}
				                    else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 1) { 	
				                    		$row[] = '<label class="badge badge-succes">Waiting Close</label>';
				                    		}
				                   	else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 3) {
				                    		$row[] = '<label class="label label-success label-form">Closed</label>';
				                    		} 
				                     
	            					else if ($permission == 1 AND $confirmed_stats == 0 AND $occ_stats == 0) {
	            							$row[] = '<label class="badge badge-danger">NCR</label>' ; 
	            					}
	            				} 
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_by_self() {
		$todetail = $this->occurrence_model->Getoccunit_out();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $occ_stats = $detaildata->occ_status;
			                    $confirmed_stats = $detaildata->occ_confirm_stats;
			                    if ($permission == 1){
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    }else{
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="#">Wait verification for print</a></li>
                                                </ul>
			                    			</div>';		
			                    }
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= $detaildata->occ_sub;
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by_name;
			                    $row[] 	= $detaildata->occ_send_to;
			                    $row[] 	= $detaildata->occ_follow_last_by;
			                    $row[] 	= $detaildata->created_date;
			                    if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 1 ) { 	
			                    		$row[] = '<label class="badge badge-succes">Waiting Close</label>';
			                    		}
			                    else if ($permission == 1 AND $confirmed_stats == 2 AND $occ_stats == 1 ) { 	
			                    		$row[] = '<label class="badge badge-succes">Progress</label>';
			                    		}
			                    else if ($permission == 1 AND $confirmed_stats == 1 ) { 	
			                    		$row[] = '<label class="badge badge-warning">Open</label>';
			                    		}
			                   	else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 3) { 	
			                    		$row[] = '<label class="label label-success label-form">Closed</label>';
			                    		} 
			                    else if ($permission == 1 AND $confirmed_stats == 4 AND $occ_stats == 4) { 	
			                    		$row[] = '<label class="badge badge-ohr">OHR</label>';
			                    		}
			                    else if ($permission == 1 AND $confirmed_stats == 0 AND $occ_stats == 0) { 	
			                    		$row[] = '<label class="badge badge-danger">NCR</label>';
			                    		}
            					else{ $row[] = '<label class="badge badge-danger">Waiting Verification</label>' ; 
            					} 
			                    
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_for_self() {
		$todetail = $this->occurrence_model->Getoccunit_in();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $occ_stats = $detaildata->occ_status;
			                    $confirmed_stats = $detaildata->occ_confirm_stats;
			                    $overdue = $detaildata->duedate;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$detaildata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_occ_detail('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    if ($detaildata->created_hide == 1) {
			                    	$row[] 	= '-';	
			                    }
			                    else{
			                    	
			                    	$row[] 	= $detaildata->created_by_name;
			                    }
			                    
			                    $row[] 	= '<a onmouseover="qtip('.$detaildata->occ_id.')" class="cont_unit'.$detaildata->occ_id.'" href="'.site_url('occurrence/get_occ_for_self_for_next_unit/').'/'.$detaildata->occ_id.'">'.$detaildata->occ_send_to.'</a>' ;
			                    $row[] 	= $detaildata->occ_follow_last_by;
			                    $row[] 	= $detaildata->created_date;
			                    if ($permission == 1 AND $overdue >= 0 AND $confirmed_stats != 0 AND $occ_stats != 0 AND $confirmed_stats != 2  AND $confirmed_stats != 3 ) {
			                    	$row[] = '<label class="badge badge-danger">OVERDUE</label>';
			                    }else{
			                    if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 1 ) { 	
			                    		$row[] = '<label class="badge badge-succes">Waiting Close</label>';
			                    		}
			                    else if($permission == 1 AND $confirmed_stats == 2 AND $occ_stats == 1 AND $overdue >= 0){
			                    		$row[] = '<label class="badge badge-danger">Overdue</label>'; //FADIL ADD
			                    		}
			                    else if ($permission == 1 AND $confirmed_stats == 2 AND $occ_stats == 1 ) { 	
			                    		$row[] = '<label class="badge badge-succes">Progress</label>';
			                    		}
			                    else if ($permission == 1 AND $confirmed_stats == 1 ) { 	
			                    		$row[] = '<label class="badge badge-warning">Open</label>';
			                    		}
			                   	else if ($permission == 1 AND $confirmed_stats == 3 AND $occ_stats == 3) { 	
			                    		$row[] = '<label class="label label-success label-form">Closed</label>';
			                    		} 
			                    else if ($permission == 1 AND $confirmed_stats == 0 AND $occ_stats == 0) { 	
			                    		$row[] = '<label class="badge badge-danger">NCR</label>';
			                    		} 
			                    else if ($permission == 1 AND $confirmed_stats == 2) { 	
			                    		$row[] = '<label class="label label-success label-form">Progress</label>';
			                    		} 
            					else { $row[] = '<label class="badge badge-needver">Need Verification</label>' ; 
            					}
            				}
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_for_self_for_next_unit($id) {	
		$data['idinfo'] = $id ;
		$data['followinfo'] = $this->occurrence_model->Get_occ_follow($id);
		$this->load->view('templates/next_unit_info.php',$data);
	}
	function get_det_nocc($id){
		$detail = $this->occurrence_model->Get_detail_nocc($id);
		echo json_encode($detail);
	}
	function get_det_ohr($id){
		$detail = $this->occurrence_model->Get_detail_ohr($id);
		echo json_encode($detail);
	}
	function get_det_occ($id){
		$detail = $this->occurrence_model->Get_detail_occ($id);
		echo json_encode($detail);
	}
	function get_non_occ() {
		$todetail = $this->occurrence_model->Getocc_NON();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/reason_nonocc').'/'.$detaildata->occ_id.'" target="_blank">See Reason</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_nocc_detail('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by_name;
			                    $row[] 	= $detaildata->occ_send_to;
			                    $row[] 	= '-';
			                    $row[] 	= $detaildata->created_date;
			                    $row[] = '<label class="badge badge-danger">Not OCC</label>' ; 
			                    $data[] = $row;
			                } 
			                    
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_non_area() {
		$todetail = $this->occurrence_model->Getocc_OHR();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/reason_nonocc').'/'.$detaildata->occ_id.'" target="_blank">See Reason</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_ohr_detail('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by_name;
			                    $row[] 	= $detaildata->occ_send_to;
			                    $row[] 	= '-';
			                    $row[] 	= $detaildata->created_date;
			                    $row[] = '<label class="badge badge-ohr">OHR</label>' ; 
			                    $data[] = $row;
			                } 
			                    
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_file($id){
		$aa = $this->uri->segment(3); 
		$bb = $this->uri->segment(4); 
		$cc = $this->uri->segment(5); 
		$dd = $this->uri->segment(6); 
		if ($dd != null) {
			$idf = "$aa/$bb/$cc/$dd" ;
		}
		else{
			$idf = "$aa/$bb/$cc";	
		}
		$filedetail = $this->occurrence_model->Get_occ_file($idf);
		$data = array();
					$no = 1 ;
                   		foreach ($filedetail as $detaildata){ 
                   				$no++ ;
			                    $row = array();
			                    $nf= $detaildata->file_name ;
			                    // $row[] 	= '<a href="ftp://usergmf:aeroasia@ftp-01.gmf-aeroasia.co.id/File_KMP_TEST/TestUpload/'.$nf.'" target="_new">'.$detaildata->file_name;
			                    $row[] 	= '<a href="#" onclick="preview('.$no.')" id="preview_fn'.$no.'">'.$detaildata->file_name.'</a>';
			                    if($detaildata->file_type == 'pdf'){
			                    	$row[] 	= '<span class="label label-primary">'.$detaildata->file_type.'</span>';
			                    }
			                    else if ($detaildata->file_type == 'jpg') {
			                    	$row[] 	= '<span class="label label-success">'.$detaildata->file_type.'</span>';
			                    }
			                    else{
			                    	$row[] 	= '<span class="label label-danger">'.$detaildata->file_type.'</span>';	
			                    }
			                    
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_file_fo($id){
		$filedetail = $this->occurrence_model->Get_occ_file_fo($id);
		$data = array();
					$no = 1 ;
                   		foreach ($filedetail as $detaildata){ 
                   				$no++ ;
			                    $row = array();
			                    $nf= $detaildata->file_name ;
			                    $row[] 	= '<a href="#" onclick="preview_fo('.$no.')" id="preview_fnfo'.$no.'">'.$detaildata->file_name.'</a>';
			                    if($detaildata->file_type == 'pdf'){
			                    	$row[] 	= '<span class="label label-primary">'.$detaildata->file_type.'</span>';
			                    }
			                    else if ($detaildata->file_type == 'jpg') {
			                    	$row[] 	= '<span class="label label-success">'.$detaildata->file_type.'</span>';
			                    }
			                    else{
			                    	$row[] 	= '<span class="label label-danger">'.$detaildata->file_type.'</span>';	
			                    }
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_file_ohr($id){
		$filedetail = $this->occurrence_model->Get_occ_file_ohr($id);
		$data = array();
					$no = 1 ;
                   		foreach ($filedetail as $detaildata){ 
                   				$no++ ;
			                    $row = array();
			                    $nf= $detaildata->file_name ;
			                    $row[] 	= '<a href="#" onclick="preview_fo('.$no.')" id="preview_fnfo'.$no.'">'.$detaildata->file_name.'</a>';
			                    if($detaildata->file_type == 'pdf'){
			                    	$row[] 	= '<span class="label label-primary">'.$detaildata->file_type.'</span>';
			                    }
			                    else if ($detaildata->file_type == 'jpg') {
			                    	$row[] 	= '<span class="label label-success">'.$detaildata->file_type.'</span>';
			                    }
			                    else{
			                    	$row[] 	= '<span class="label label-danger">'.$detaildata->file_type.'</span>';	
			                    }
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_probability() {
		$todetail = $this->occurrence_model->Getprobability();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $probability){ 
			                    $row = array();
			                    $row[] 	= $probability->probability_a_definition;
			                    $row[] 	= $probability->probability_meaning;
			                    $row[] 	= $probability->probability_value;
			                    $row[] 	= '<div class="form-group">
				                                <div class="col-md-12">                                    
			                                        <label class="check"><input type="radio" class="iradio" name="probradio" id="probradio" value="'.$probability->probability_value.'" required/></label>
			                                    </div>
                                        	</div>';
			                    $data[] = $row;
                		}
		$output = array("data" => $data,);
        echo json_encode($output);
	}
	function get_severity() {
		$todetail = $this->occurrence_model->Getseverity();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $severity){ 
                   			$no++;
			                    $row = array();
			                    $row[] 	= $severity->severity_q_definition;
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_people.'</div>';
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_environment.'</div>';
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_security.'</div>';
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_assets_operational.'</div>';
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_compliance.'</div>';
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_it_system.'</div>';
			                    $row[] 	= '<div class="severity-bod panel-toggled-severity'.$no.' pr" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')">'.$severity->severity_reputational.'</div>';

			                    $row[] 	= '<div class="form-group">
				                                <div class="col-md-12">                                    
			                                        <label class="check"><input type="radio" class="iradio" name="severadio" name="severadio" value="'.$severity->severity_value.'" required/></label>
			                                    </div>
                                        	</div>';
			                    // $row[] 	= '<div class="form-group">
				                   //              <div class="col-md-12">                                    
			                    //                     <label class="check" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')"><input type="radio" onmouseover="showing('.$no.')" onmouseleave="hidding('.$no.')" class="iradio" name="severadio" name="severadio" value="'.$severity->severity_value.'" required/></label>
			                    //                 </div>
                       //                  	</div>';
			                    $data[] = $row;
                		}
		$output = array("data" => $data,);
        echo json_encode($output);
	}
	function get_det_follow($id){
		$detail = $this->occurrence_model->Get_detail_follow($id);
		echo json_encode($detail);
	}
	function get_occ_follow($id) {
		$bylast = $this->session->userdata('occ_users_1103')->unit;
		$byadmin = $this->session->userdata('occ_users_1103')->role;	
			$detail = $this->occurrence_model->Get_occ_follow($id);
			$data = array();
	                   		foreach ($detail as $detaildata){ 
				                    $row = array();
				                    $row[] 	= '<a href="#" onclick="Get_detail_follow('.$detaildata->follow_id.')">'.substr($detaildata->follow_desc ,0,150).'<br>
				                    <span class="text-warning">Read More </span></a> <br> Attachment : <a href="ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/'.$detaildata->attachment.'" target="_blank">' .$detaildata->attachment.'</a> <br>';
				                    $row[] 	= $detaildata->follow_by.'<br>'.$detaildata->follow_by_name.'<br>'.'('.$detaildata->follow_by_unit.')';
				                    $row[] 	= $detaildata->follow_next;
				                    $row[] 	= $detaildata->follow_est_finish;
				                    $row[] 	= $detaildata->follow_date;
				                    $row[] 	= '<a href="#" onclick="del_follow('.$detaildata->follow_id.')"><i class="fa fa-times"></i></a>';
				                    $data[] = $row;
				                    }  
	               $output = array("data" => $data,);
	               echo json_encode($output);			
	}
	function Get_non_occ_follow($id) {
		$bylast = $this->session->userdata('occ_users_1103')->unit;
		$byadmin = $this->session->userdata('occ_users_1103')->role;	
			$detail = $this->occurrence_model->Get_non_occ_follow($id);
			$data = array();
	                   		foreach ($detail as $detaildata){ 
				                    $row = array();
				                    $row[] 	= $detaildata->non_occ_reason;
				                    $row[] 	= $detaildata->occ_follow_last_by;
				                    $row[] 	= '';
				                    $row[] 	= '';
				                    $row[] 	= '';
				                    $data[] = $row;
				                    }  
	               $output = array("data" => $data,);
	               echo json_encode($output);			
	}
	function Get_OHR_occ_follow($id,$id2,$id3,$id4) {
		$bylast = $this->session->userdata('occ_users_1103')->unit;
		$byadmin = $this->session->userdata('occ_users_1103')->role;	
			$detail = $this->occurrence_model->Get_OHR_occ_follow($id,$id2,$id3,$id4);
			$data = array();
	                   		foreach ($detail as $detaildata){ 
				                    $row = array();
				                    $row[] 	= $detaildata->follow_desc.'... <br> Attachment : <a href="ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/'.$detaildata->attachment.'" target="_blank">' .$detaildata->attachment.'</a> <br> To : '.$detaildata->follow_next ;
				                    $row[] 	= $detaildata->follow_by_name;
				                    $row[] 	= '';
				                    $row[] 	= '';
				                    $row[] 	= $detaildata->follow_date;
				                    $data[] = $row;
				                    }  
	               $output = array("data" => $data,);
	               echo json_encode($output);			
	}
	function save_new(){
		$header = date("m/Y");
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
		$occ_no 		=   $GetMaxID;
		$occ_sub		=	$this->input->POST('subject');	
		$occ_detail		=	$this->input->POST('occ_detail');
		$hahaha  =  nl2br($occ_detail);
		$ocd = str_replace("'"," ",$hahaha);
		$occ_risk_index	=	$this->input->POST('occ_risk_idx');
		$occ_probability=	'-';
		$occ_severity	=	'-';
		$occ_reff		=	$this->input->POST('occ_reference');
		$occ_ambiguity	=	$this->input->POST('ambiguity');
		$occ_date		= 	$this->input->POST('occ_date') . date(" H:i:s");
		$created_date	=	date("Y-m-d H:i:s");
		$occ_category 	=	$this->input->POST('category');
		$occ_sub_category 	= $this->input->POST('sub_category');
		$sub_category_spec	= $this->input->POST('sub_category_stats');
		$occ_level_type		= $this->input->POST('level_type');
		$occ_level_sub		= $this->input->POST('sub_lvl_typ');
		$occ_level_sub_child= $this->input->POST('sub_apu_sub');
		$occ_status			= "1";
		$occ_send_to 		= $this->input->POST('send_to');
		$occ_by 			= $this->session->userdata('occ_users_1103')->username;
		$occ_by_name 		= $this->session->userdata('occ_users_1103')->name;
		$occ_by_unit 		= $this->session->userdata('occ_users_1103')->unit;
		$occ_permission 	=  "0";
		$occ_hide_reporter  = $this->input->POST('hide_reporter'); 
		$occ_est_finish		= $this->input->POST('occ_est_finish');
									$beginday= date("Y-m-d");
                                    $lastday = date('Y-m-d', strtotime($beginday. ' + 3 weekdays'));
		$occ_response_date  = $lastday ;
		$occ_file_name		= $this->input->POST('file_name'); 
		if ($this->session->userdata('occ_users_1103')->role == 1 ) {
			$occ_rep_by 	=  $this->input->POST('reported_by');
			$occ_rep_by_name 	=  $this->input->POST('reported_by_name');
			$occ_rep_by_unit 	=  $this->input->POST('reported_by_unit');
			if ($occ_rep_by == '' ||  $occ_rep_by == null) {
				$dataOcc 		= array( 'occ_no'			=> $occ_no,
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
							      'InsertBy'		=> $occ_by.'/'.$occ_by_name.'/'.$occ_by_unit,
							);
			}
			else{
				$dataOcc 		= array( 'occ_no'			=> $occ_no,
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
							      'created_by'		=> $occ_rep_by,
							      'created_by_name'	=> $occ_rep_by_name,
							      'created_by_unit'	=> $occ_rep_by_unit,
							      'permission'		=> $occ_permission,
							      'created_hide'	=> $occ_hide_reporter,
							      'occ_confirm_stats'	=> '1',
							      'InsertBy'		=> $occ_by.'/'.$occ_by_name.'/'.$occ_by_unit,
							);
			}
		}
		else{
			$occ_rep_by =  $this->session->userdata('occ_users_1103')->name; 
			$dataOcc 		= array( 'occ_no'			=> $occ_no,
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
						      'InsertBy'		=> $occ_by.'/'.$occ_by_name.'/'.$occ_by_unit,
							);
		}
			foreach ($occ_file_name as $keys => $value) {
			$dataOccFile = array (	
									'file_name'		=> preg_replace('!\s+!', '_',  $occ_file_name[$keys]),
									'file_type'		=> substr($occ_file_name[$keys], -3),
						 			'occ_id'		=> $occ_no,
									);
				$isfineFile = $this->occurrence_model->Insert('tbl_occ_file', $dataOccFile);
				}
		        		$isfineOcc = $this->occurrence_model->Insert('tbl_occ', $dataOcc);
				if ($isfineOcc AND $isfineFile){
						echo json_encode(array("status" => TRUE ,
												"target" => $occ_no ));
		        }
	}
	function save_follow_on(){
		$id 	= $this->occurrence_model->GetMaxfollowID();
	                foreach ($id as $plist){ 
							$GetMaxIDF = $plist->MaxIDFoll;
							$GetMaxIDF = $GetMaxIDF + '1';
					}	
		$addfollby		= 	$this->session->userdata('occ_users_1103')->username; 
		$addfollbyname		= 	$this->session->userdata('occ_users_1103')->name; 
		$addfollbyunit		= 	$this->session->userdata('occ_users_1103')->unit; 
		$addfollto		=	$this->input->POST('addfollto');
		//FADIL
		$emailsendto = $this->occurrence_model->emailsend($addfollto);
		$emailtemplate['occurrence'] = $this->occurrence_model->Get_detail_occ($addfollto);
		$emailtemplate['occurrence_follow'] = $this->occurrence_model->Get_occ_follow($addfollto);
		$pesan = $this->load->view('email/emailfollow',$emailtemplate,TRUE);
		//ENDFADIL
		$addfoll_send_to	=	$this->input->POST('addfoll_send_to');
		$addfolldesc		=	$this->input->POST('addfolldesc');
		$beginday= date("Y-m-d H:i:s") ;
		$lastday = date('Y-m-d H:i:s', strtotime($beginday. ' + 9 weekdays')); 
		// $addfollestimated	=	$lastday;
		// var_dump($lastday);
		// die();
		$addfollestimated	=	$this->input->POST('ffollestimated');
		$addfolldate		=	date("Y-m-d H:i:s");
		$file_name_fo	= $this->input->POST('file_name_fo');
		foreach ($file_name_fo as $keys => $value) {
			$dataOccFileFo = array ('file_name'		=> preg_replace('!\s+!', '_',  $file_name_fo[$keys]),
									'file_type'		=> substr($file_name_fo[$keys], -3),
						 			'occ_id'		=> $addfollto,
						 			'follow_occ_file_id'	=> $GetMaxIDF,
									);
				$isfineFilefo = $this->occurrence_model->Insert('tbl_occ_file_fo', $dataOccFileFo);
				}
					$dataFollow = array('occ_id'		=> $addfollto,
										'follow_occ_file_id'=> $GetMaxIDF,
						      			'follow_desc'		=> $addfolldesc,
						      			'follow_by'			=> $addfollby,
						      			'follow_by_name'	=> $addfollbyname,
						      			'follow_by_unit'	=> $addfollbyunit,
						      			'follow_next'		=> $addfoll_send_to,
						      			'follow_est_finish'	=> $addfollestimated,
						      			'follow_date'		=> $addfolldate,
						      			'follow_last_by'	=> $addfoll_send_to, 
										);
					//add fadil
					$sendtounit = $this->occurrence_model->sendtounit($addfoll_send_to);
					$sendtounitemail = '';
					foreach ($sendtounit as $sendtounit) {
						$sendtounitemail .= $sendtounit['EMAIL'].',';
					}
					//echo $sendtounitemail;die;
						$config = Array("protocol"  => "smtp",
							"smtp_host" => "mail.gmf-aeroasia.co.id",
							"smtp_port" => 25,
							"smtp_user" => "app.notif@gmf-aeroasia.co.id",
							"smtp_pass" => "app.notif",
							"mailtype"  => "html",
							"charset"   => "iso-8859-1",
							"wordwrap"  => TRUE );
						$this->load->library("email", $config);
						//$this->email->initialize($config);
						$this->email->set_newline("\r\n");
						$this->email->from("app.notif@gmf-aeroasia.co.id","IOR Accepted/ Notification");            
						//$this->email->cc('list-tqy@gmf-aeroasia.co.id');
						$this->email->cc("fadhilatur7@gmail.com");
						if ($sendtounitemail) {
							$this->email->to($sendtounitemail);
						}else{
							$this->email->to($emailsendto["created_by"]);
						}
						$this->email->subject("IOR Accepted/ Notification");
						$this->email->message($pesan); 
						$this->email->send();
					//end fadil
		if ($addfoll_send_to == '-') {
			$result = $this->db->query("UPDATE tbl_occ SET occ_follow_last_by = '$addfoll_send_to' WHERE occ_id ='$addfollto'" );
		}
		else{
			$result = $this->db->query("UPDATE tbl_occ SET occ_follow_last_by = '$addfoll_send_to', occ_estfinish_date = '$lastday' 
										WHERE occ_id ='$addfollto'");
		}
		
					$result2 = $this->db->query(" UPDATE tbl_occ_follow SET follow_last_by = null WHERE occ_id ='$addfollto'");
					$isfineFoll = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);

				if ($isfineFoll AND $isfineFilefo AND $result AND $result2){
								echo json_encode(array("status" => TRUE));
		        }
	}
	function occ_verified(){
		$id     		= $this->input->post('id_verifying');
		$id_v_file     		= $this->input->post('id_v_file');
		$role 		 = $this->session->userdata('occ_users_1103')->role; 
		$ver_by_name = $this->session->userdata('occ_users_1103')->name;
		$ver_by   = $this->session->userdata('occ_users_1103')->username;
		$ver_by_unit = $this->session->userdata('occ_users_1103')->unit;
		$ver = $ver_by.'/'.$ver_by_name.'/'.$ver_by_unit ;
		$created_date	=	date("Y-m-d H:i:s");
		$beginday	=	date("Y-m-d");
		$estupdate = date('Y-m-d', strtotime($beginday. ' + 10 weekdays'));
		if ($role == 1) {
		$header = date("m/Y");
		$idMAX 	= $this->occurrence_model->GetMaxID();
	                foreach ($idMAX as $plist){ 
							$GetMaxID = $plist->MaxID; 
							$GetMaxID = str_pad($GetMaxID + 1, 3, 0, STR_PAD_LEFT);
							$GetMaxID = substr($GetMaxID, 0,3);
							$GetMaxID = $GetMaxID.'/'.$header;
					}
		 if ($GetMaxID == null || $GetMaxID == '') {
		 		$GetMaxID = '001/'.$header;
		 }
		$occ_no 		=   $GetMaxID;
			$result = $this->db->query("UPDATE tbl_occ SET  permission = '1',
															occ_no = '$GetMaxID',
															hazard = '$ver',
															occ_estfinish_date = '$estupdate',
															created_date = '$created_date'
										WHERE occ_id ='$id'");
			$emailsendto = $this->occurrence_model->emailsend($id);
			//$sendemail['getdata'] = $this->occurrence_model->emailsend($id);
			$sendtounit = $this->occurrence_model->sendtounit($emailsendto['occ_send_to']);
			$sendtounitemail = '';
			foreach ($sendtounit as $sendtounit) {
				$sendtounitemail .= $sendtounit['EMAIL'].',';
			}
			//echo $sendtounitemail;die;
			
			//$pesan = $this->load->view('email/accepted_email',$sendemail,TRUE); //template old
			//newtemplate fadil
			$emailtemplate['occurrence'] = $this->occurrence_model->Get_detail_occ($id);
			$emailtemplate['occurrence_follow'] = $this->occurrence_model->Get_occ_follow($id);
			$pesan = $this->load->view('email/emailfollow',$emailtemplate,TRUE);
			//end template
			$result2 = $this->db->query("UPDATE tbl_occ_file SET occ_id = '$GetMaxID' WHERE occ_id ='$id_v_file'");
			if ($result) {
				$config = Array("protocol"  => "smtp",
                        "smtp_host" => "mail.gmf-aeroasia.co.id",
                        "smtp_port" => 25,
                        "smtp_user" => "app.notif@gmf-aeroasia.co.id",
                        "smtp_pass" => "app.notif",
                        "mailtype"  => "html",
                        "charset"   => "iso-8859-1",
                        "wordwrap"  => TRUE );
				$this->load->library("email", $config);
				//$this->email->initialize($config);
				$this->email->set_newline("\r\n");
				$this->email->from("app.notif@gmf-aeroasia.co.id","IOR Accepted/ Notification");            
				//$this->email->cc('list-tqy@gmf-aeroasia.co.id');
				$this->email->cc("fadhilatur7@gmail.com");
				if ($sendtounitemail) {
					$this->email->to($sendtounitemail);
				}else{
					$this->email->to($emailsendto["created_by"]);
				}
				$this->email->subject("IOR Accepted/ Notification");
				$this->email->message($pesan); 
				$this->email->send();
				// if (!$this->email->send())
				// {    
				// 	echo $this->email->print_debugger();
				// } 
				echo json_encode(1);
			}else{
				echo json_encode(2);
			}
		}
		else {
			echo json_encode(array("status" => "failed! YOU TRYIN VERIFIED BY NO AUTHENTIFICATION!! YOUR COMPUTER ID HAS BEEN DETECTED FOR NEXT AUDIT"));
		}		
	}
	function occ_no_verified(){
		$id     		= $this->input->post('id_verifying');
		$id_v_file     		= $this->input->post('id_v_file');
		$n_occ_reason 	= $this->input->post('n_occ_reason'); 
		$reasonby		= $this->session->userdata('occ_users_1103')->name; 
		$reasonby 		= "".$reasonby."";
		$header = date("m/Y");
		$date = date("d-m-Y");
		$idNI 	= $this->occurrence_model->GetMaxIDDraft();
	                foreach ($idNI as $plist){ 
							$GetMaxID = $plist->MaxID; 
							$GetMaxID = str_pad($GetMaxID + 1, 3, 0, STR_PAD_LEFT);
							$GetMaxID = substr($GetMaxID, 0,3);
							$GetMaxID = $GetMaxID.'/'.$header.'/NH' ;
					}
		 if ($GetMaxID == null || $GetMaxID == '') {
		 		$GetMaxID = '001/'.$header.'NH' ;
		 }
		$occ_no 		=   $GetMaxID;
		$occ 	= $this->occurrence_model->Get_occ_for_move($id);
		                foreach ($occ as $occ_mov){ 
								$occ_sub		=	$occ_mov->occ_sub;	
								$occ_detail		=	$occ_mov->occ_detail;
								$occ_risk_index	=	$occ_mov->occ_risk_index;
								$occ_probability=	'-';
								$occ_severity	=	'-';
								$occ_reff		=	$occ_mov->occ_reff;
								$occ_ambiguity	=	$occ_mov->occ_ambiguity;
								$occ_date		= 	$occ_mov->occ_date;
								$occ_estfinish_date		= 	$occ_mov->occ_estfinish_date;
								$created_date	=	$occ_mov->created_date;
								$occ_category 	=	$occ_mov->occ_category;
								$occ_sub_category  = $occ_mov->occ_sub_category;
								$sub_category_spec = $occ_mov->occ_sub_spec;
								$occ_status		= 	"1";
								$occ_send_to 	= 	$occ_mov->occ_send_to;
								$occ_by 		= 	$occ_mov->created_by;
								$occ_by_name 	=	$occ_mov->created_by_name;
								$occ_permission = 	"0" ;
								$occ_hide_reporter = $occ_mov->created_hide;
						}
				$dataOccMov = array( 'occ_no'		=> $occ_no,
							      'occ_sub'			=> $occ_sub,
							      'occ_detail'		=> $occ_detail,
							      'occ_risk_index'  => $occ_risk_index,
								  'occ_probability' => $occ_probability,
								  'occ_severity'	=> $occ_severity,
							      'occ_reff'		=> $occ_reff,
							      'occ_ambiguity' 	=> $occ_ambiguity,
							      'occ_date'		=> $occ_date,
							      'occ_estfinish_date' => $occ_estfinish_date,
							      'occ_category'	=> $occ_category,
							      'occ_sub_category'=> $occ_sub_category,
							      'occ_sub_spec'	=> $sub_category_spec,
							      'occ_status'		=> $occ_status,
							      'occ_send_to'		=> $occ_send_to,
							      'created_date'	=> $created_date,
							      'created_by'		=> $occ_by,
							      'created_by_name'	=> $occ_by_name,
							      'permission'		=> $occ_permission,
							      'created_hide'	=> $occ_hide_reporter,
							      'occ_confirm_stats'	=> '3',
							      'occ_follow_last_by' => $reasonby, 
							      'non_occ_reason'	=> $n_occ_reason,

								);
				$isfineMove = $this->occurrence_model->Insert('tbl_occ_reject', $dataOccMov);
				$result2 = $this->db->query("UPDATE tbl_occ_file SET occ_id = '$occ_no' WHERE occ_id ='$id_v_file'");

				$config = Array('protocol'  => 'smtp',
						'smtp_host' => 'mail.gmf-aeroasia.co.id',
						'smtp_port' => 25,
						'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
						'smtp_pass' => 'app.notif',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1',
						'wordwrap'  => TRUE );
			$mp 		 = $this->occurrence_model->GET_MAIL_PERSONEL($occ_by);
			$mimail = '';
	                	foreach ($mp as $mpd){ 
								$mimail .= $mpd->EMAIL; 
						}
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('app.notif@gmf-aeroasia.co.id','IOR Not accepted Notification');		
			$this->email->bcc(array('fadhilatur7@gmail.com'));
			$this->email->to($mimail.','.$occ_by);
			$this->email->subject('IOR Not accepted Notification');

			$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
					"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
					</head>';
			$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";

			$pesan .= ' <p><p><strong>We already verify and evaluate your report validity with the subject &quot;
							"'.$occ_sub.'" , the report is not include in Internal Occurrence Report</strong>
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
					    NEW IOR Application - 2017 (TQY) <br>
					    PT Garuda Maintenance Facility Aero Asia <br>
					    Safety Inspection Unit, Room 1.13, 1st Floor, Hangar 2, Soekarno Hatta Int`l Airport.<br>
					    P : +62 21 550 8190 <br>
					    E : list-TQY@gmf-aeroasia.co.id </p>
						</p>
					   <br>';
			$pesan .= " <img src='http://intranet.gmf-aeroasia.co.id/app_icasset/assets/images/tqy-sgn.jpg'> ";
			$this->email->message($pesan); 
			$this->email->send();
				if ($isfineMove) {
					$result = $this->db->query("DELETE FROM tbl_occ WHERE occ_id = '$id'");
					echo "$occ_no";
				}else{
					
				}
	}
	function occ_no_area(){
		$id     		= $this->input->post('id_verifying');
		$id_v_file     		= $this->input->post('id_v_file');
		$n_occ_reason 	= $this->input->post('n_occ_reason'); 
		$reasonby		= $this->session->userdata('occ_users_1103')->name; 
		$reasonby 		= "".$reasonby."";
		$header = date("m/Y");
		$idNI 	= $this->occurrence_model->GetMaxIDOHR();
	                foreach ($idNI as $plist){ 
							$GetMaxID = $plist->MaxID; 
							$GetMaxID = str_pad($GetMaxID + 1, 3, 0, STR_PAD_LEFT);
							$GetMaxID = substr($GetMaxID, 0,3);
							$GetMaxID = $GetMaxID.'/'.$header.'/OHR' ;
					}
		if ($GetMaxID == null || $GetMaxID == '') {
		 		$GetMaxID = '001/'.$header.')OHR' ;
		}
		$c_file = $this->input->post('ohrfile');
		if (empty($c_file)) {
			$c_file = "" ;
		}
		$occ_no 		=   $GetMaxID;
		$occ 	= $this->occurrence_model->Get_occ_for_move($id);
		                foreach ($occ as $occ_mov){ 
								$occ_sub		=	$occ_mov->occ_sub;	
								$occ_detail		=	$occ_mov->occ_detail;
								$occ_risk_index	=	$occ_mov->occ_risk_index;
								$occ_probability=	'-';
								$occ_severity	=	'-';
								$occ_reff		=	$occ_mov->occ_reff;
								$occ_ambiguity	=	$occ_mov->occ_ambiguity;
								$occ_date		= 	$occ_mov->occ_date;
								$occ_estfinish_date		= 	$occ_mov->occ_estfinish_date;
								$created_date	=	$occ_mov->created_date;
								$occ_category 	=	$occ_mov->occ_category;
								$occ_sub_category  = $occ_mov->occ_sub_category;
								$sub_category_spec = $occ_mov->occ_sub_spec;
								$occ_status		= 	"1";
								$occ_send_to 	= 	$occ_mov->occ_send_to;
								$occ_by 		= 	$occ_mov->created_by;
								$occ_by_name 	=	$occ_mov->created_by_name;
								$occ_permission = 	"0" ;
								$occ_hide_reporter = $occ_mov->created_hide;
						}
				$dataOccMov = array( 'occ_no'		=> $occ_no,
							      'occ_sub'			=> $occ_sub,
							      'occ_detail'		=> $occ_detail,
							      'occ_risk_index'  => $occ_risk_index,
								  'occ_probability' => $occ_probability,
								  'occ_severity'	=> $occ_severity,
							      'occ_reff'		=> $occ_reff,
							      'occ_ambiguity' 	=> $occ_ambiguity,
							      'occ_date'		=> $occ_date,
							      'occ_estfinish_date' => $occ_estfinish_date,
							      'occ_category'	=> $occ_category,
							      'occ_sub_category'=> $occ_sub_category,
							      'occ_sub_spec'	=> $sub_category_spec,
							      'occ_status'		=> '4',
							      'occ_send_to'		=> $occ_send_to,
							      'created_date'	=> $created_date,
							      'created_by'		=> $occ_by,
							      'created_by_name'	=> $occ_by_name,
							      'permission'		=> '1',
							      'created_hide'	=> $occ_hide_reporter,
							      'occ_confirm_stats'  => '4',
							      'occ_follow_last_by' => $reasonby, 
							      'non_occ_reason'	=> $n_occ_reason,
							      'non_occ_file'	=> $c_file,
								);
				$date	=	date("Y-m-d H:i:s");
				$dataFo_OHR = array('occ_id'	 	 => $occ_no,
									'follow_by'		 => $reasonby,
									'follow_by_name' => $reasonby,
									'follow_desc'	 => $n_occ_reason,
									'attachment' 	 => $c_file,
									'follow_date' 	 => $date,
									) ;
				$isfineMove = $this->occurrence_model->Insert('tbl_occ_ohr', $dataOccMov);
				$isfineMoveFoll = $this->occurrence_model->Insert('tbl_occ_follow_ohr', $dataFo_OHR);
				$result2 = $this->db->query("UPDATE tbl_occ_file SET occ_id = '$occ_no' WHERE occ_id ='$id_v_file'");
				if ($isfineMove) {
					$result = $this->db->query("DELETE FROM tbl_occ WHERE occ_id = '$id'");
					echo "$occ_no";
				}else{
					
				}
	}
	function send_notif(){
		echo "Sorry , the server for notification is offline :(" ;	
		//////
		//////
	}
	function get_estimated($id){  
		$beginday= $id ;
		$lastday = date('Y-m-d', strtotime($beginday. ' + 10 weekdays')); 
		echo json_encode($lastday);
	}
	function op_ior(){
		$ic     = $this->input->post('at');
		$opr     = $this->input->post('p_reason');
		$op_ed = $this->input->post('p_est_date');
		$p_file = $this->input->post('p_file');
		$p_wrongresp = $this->input->post('p_wrongresp');
		$op_follby		= 	$this->session->userdata('occ_users_1103')->username; 
		$op_follbyname		= 	$this->session->userdata('occ_users_1103')->name; 
		$op_follbylast		= 	$this->session->userdata('occ_users_1103')->unit;
		$op_date		=	date("Y-m-d H:i:s"); 
		$addfollto		=	$this->input->POST('addfollto');
		$id 	= $this->occurrence_model->GetMaxfollowID();
	                foreach ($id as $plist){ 
						$GetMaxIDF = $plist->MaxIDFoll;
						$GetMaxIDF = $GetMaxIDF + '1';
					}

		if ($p_wrongresp == '1') {
			$op_ed 		= $op_ed ;
			$follbylast = $this->session->userdata('occ_users_1103')->unit ;
			$conf_stats = '2' ;
			if (!empty($p_file)) {
				
					$dataOccFileFo = array ('file_name'			=>  preg_replace('!\s+!', '_', $p_file),
											'file_type'			=> substr($p_file, -3),
				 							'occ_id'			=> $ic,
				 							'follow_occ_file_id'=> $GetMaxIDF,
							);
					$isfineFilefo = $this->occurrence_model->Insert('tbl_occ_file_fo', $dataOccFileFo);
			}
		}

		else if ($p_wrongresp == '0') {
				$op_ed 		  = '0';
				$follbylast   = 'N/A' ;
				$conf_stats   = '1';
		}
		
		$idcstats 		 = $this->occurrence_model->Check_Closestats($ic);
	                foreach ($idcstats as $clstats){ 
							$is_stats = $clstats->occ_confirm_stats; 
							$is_stats_by = $clstats->created_by;
							$is_sub = $clstats->occ_sub;
							$is_occ_no = $clstats->occ_no;
							$is_occ_by_mail = $clstats->created_by;
							$occ_est_finish = $clstats->occ_estfinish_date;

					}
		if ($op_ed == null OR $op_ed == '') {
			$addoc_estfinish = date('Y-m-d', strtotime($op_date. ' + 10 weekdays'));	
		}
		else{
			$addoc_estfinish = date('Y-m-d', strtotime($occ_est_finish. ' + '.$op_ed.' weekdays'));	
		}
		$dataFollow = array('occ_id'			=> $ic,
			      			'follow_desc'		=> $opr,
			      			'follow_occ_file_id'=> $GetMaxIDF,
			      			'follow_by'			=> $op_follby,
			      			'follow_by_name'	=> $op_follbyname,
			      			'follow_by_unit'	=> $op_follbylast,
			      			'follow_next'		=> null,
			      			'follow_est_finish'	=> $addoc_estfinish,
			      			'follow_date'		=> $op_date, 
			      			'follow_last_by'	=> $op_follbylast,);
		$result_op 		 = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
		$result_ops = $this->db->query(" UPDATE tbl_occ 
										 SET occ_confirm_stats = '$conf_stats',occ_estfinish_date = '$addoc_estfinish',
										 	occ_follow_last_by = '$follbylast'
										 WHERE occ_id ='$ic'");
		$date = date("d-m-Y");
		$config = Array('protocol'  => 'smtp',
						'smtp_host' => 'mail.gmf-aeroasia.co.id',
						'smtp_port' => 25,
						'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
						'smtp_pass' => 'app.notif',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1',
						'wordwrap'  => TRUE );

			$ocno 		= $is_occ_no ;
			$ocsub 		= $is_sub ;
			$ocby 		= $is_stats_by ;
			$ocfdate 	= $occ_est_finish ;

			$mp 		 = $this->occurrence_model->GET_MAIL_PERSONEL($ocby);
	                	foreach ($mp as $mpd){ 
								$mimail = $mpd->EMAIL; 
						}
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('app.notif@gmf-aeroasia.co.id','IOR On Progress Notification');		
			$this->email->bcc(array('danangyogi11@gmail.com'));
			$this->email->to($mimail.','.$is_occ_by_mail);
			$this->email->subject('IOR On Progress Notification');

			$pesan = '<!DOCTYPE html PUBLIC "-W3CDTD XHTML 1.0 StrictEN"
					"http:www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset = utf-8"/>
					</head>';
			$pesan .= "<p><h3>Internal Occurrence Report System Notification</h3>";
			$pesan .= ' <p><strong>Accordance to Internal Occurrence 
							Report No. "'.$ocno.'" &ndash; "'.$ocsub.'; 
							that you have reported, <br>Now responsible unit is doing follow up action to rectify the problem. 
							So please be patient and keep monitor the IOR until the next "'.$ocfdate.'" .</strong>
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
					    NEW IOR Application - 2017 (TQY) <br>
					    PT Garuda Maintenance Facility Aero Asia <br>
					    Safety Inspection Unit, Room 1.13, 1st Floor, Hangar 2, Soekarno Hatta Int`l Airport.<br>
					    P : +62 21 550 8190 <br>
					    E : list-TQY@gmf-aeroasia.co.id </p>
						</p>
					   <br>';
			$pesan .= " <img src='http://intranet.gmf-aeroasia.co.id/app_icasset/assets/images/tqy-sgn.jpg'> ";
			$this->email->message($pesan); 
			$this->email->send();
		if ($result_op AND $result_ops AND $follbylast  == 'N/A') {
			echo json_encode(0);
		}	
		else if ($result_op AND $result_ops) {
			echo json_encode(1);
		}
	}
	function c_ior(){
		$ic     = $this->input->post('at');
		$opr    = $this->input->post('c_reason');		
		$risk   = $this->input->post('c_risk');
		$c_file = $this->input->post('file_name_fo');
		$id 	= $this->occurrence_model->GetMaxfollowID();
	                foreach ($id as $plist){ 
							$GetMaxIDF = $plist->MaxIDFoll;
							$GetMaxIDF = $GetMaxIDF + '1';
					}
				if (!empty($c_file)) {
					foreach ($c_file as $keys => $value) {
					$dataOccFileFo = array ('file_name'			=>  preg_replace('!\s+!', '_', $c_file[$keys]),
											'file_type'			=> substr($c_file[$keys], -3),
				 							'occ_id'			=> $ic,
				 							'follow_occ_file_id'=> $GetMaxIDF,
							);
					$isfineFilefo = $this->occurrence_model->Insert('tbl_occ_file_fo', $dataOccFileFo);
					}
				}
		$cb 	= $this->session->userdata('occ_users_1103')->username; 
		$cbname	= 	$this->session->userdata('occ_users_1103')->name; 
		$cbunit = 	$this->session->userdata('occ_users_1103')->unit;
		$cblvl 	 = 	$this->session->userdata('occ_users_1103')->role;
		$op_date		=	date("Y-m-d H:i:s"); 
		$dataFollow = array('occ_id'			=> $ic,
			      			'follow_desc'		=> $opr,
			      			'follow_occ_file_id'=> $GetMaxIDF,
			      			'follow_by'			=> $cb,
			      			'follow_by_name'	=> $cbname,
			      			'follow_by_unit'	=> $cbunit,
			      			'follow_next'		=> '-',
			      			'follow_est_finish'	=> '-',
			      			'follow_date'		=> $op_date, 
			      			'follow_last_by'	=> $cbunit,);
		$id 		 = $this->occurrence_model->Check_Closestats($ic,$cb);
	                foreach ($id as $clstats){ 
	                		$is_occ_stats = $clstats->occ_status; 
							$is_stats = $clstats->occ_confirm_stats; 
							$is_stats_by = $clstats->created_by;
							$follow_last_by = $clstats->occ_follow_last_by; 
					}
		if ($is_stats == 3 AND $cblvl == 1) {
				$result_cp = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
				$result = $this->db->query("UPDATE tbl_occ SET occ_final_index = '$risk', occ_status = '3', occ_confirm_stats = '3' WHERE occ_id ='$ic'");
				if ($result AND $result_cp) {
					$this->occurrence_model->notif_are_closed($is_stats_by,$ic);
					echo json_encode(1);
				}
			}
		else{
				if ($is_stats_by == $cb AND $is_stats == 1 AND $is_occ_stats == 1) {
					echo json_encode(3);	
				}
				else if ($is_stats_by == $cb AND $is_stats == 2 AND $is_occ_stats == 1 ) {
					$result_cp = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
					$result = $this->db->query("UPDATE tbl_occ SET occ_risk_index = '$risk',occ_confirm_stats = '3', occ_follow_last_by = '$cbunit' WHERE occ_id ='$ic'");
					if ($result AND $result_cp) {
					$this->occurrence_model->notif_must_be_close($is_stats_by,$ic);
					$this->occurrence_model->notif_must_be_close_user($is_stats_by,$ic);
					echo json_encode(2);
					}
				}
				else if ($is_stats_by == $cb AND $is_stats == 3 AND $follow_last_by != $cbunit) {
					$result_cp = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
					$result = $this->db->query("UPDATE tbl_occ SET occ_risk_index = '$risk',occ_status = '3', occ_confirm_stats = '3' WHERE occ_id ='$ic'");
					if ($result AND $result_cp) {
					$this->occurrence_model->notif_are_closed($is_stats_by,$ic);
					echo json_encode(1);
					}
				}
				else if ($is_stats_by == $cb AND $is_stats == 3 AND $follow_last_by == $cbunit) {
					echo json_encode(5);
				}
				else if($is_stats_by != $cb){
					$result_cp = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
					$result = $this->db->query("UPDATE tbl_occ SET occ_risk_index = '$risk',occ_confirm_stats = '3' WHERE occ_id ='$ic'");
					if ($result AND $result_cp) {
					$this->occurrence_model->notif_must_be_close($is_stats_by,$ic);
					$this->occurrence_model->notif_must_be_close_user($is_stats_by,$ic);
					echo json_encode(2);
					}
				}
			}
	}
	function cc_ior(){
		$ic     = $this->input->post('at');
		$opr     = $this->input->post('cc_reason');
		$cb 	= $this->session->userdata('occ_users_1103')->username; 
		$cbname		 = 	$this->session->userdata('occ_users_1103')->name; 
		$cbunit 	 = 	$this->session->userdata('occ_users_1103')->unit;
		$op_date		=	date("Y-m-d H:i:s"); 
		$dataFollow = array('occ_id'			=> $ic,
			      			'follow_desc'		=> $opr,
			      			'follow_by'			=> $cb,
			      			'follow_by_name'	=> $cbname,
			      			'follow_by_unit'	=> $cbunit,
			      			'follow_next'		=> '-',
			      			'follow_est_finish'	=> '-',
			      			'follow_date'		=> $op_date, 
			      			'follow_last_by'	=> $cbunit,);
		$id 		 = $this->occurrence_model->Check_Closestats($ic,$cb);
	                foreach ($id as $clstats){ 
							$is_stats = $clstats->occ_confirm_stats; 
							$is_stats_by = $clstats->created_by; 
					}
		if ($is_stats_by == $cb) {
			$result_cp = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
			$result = $this->db->query("UPDATE tbl_occ SET occ_status = '1', occ_confirm_stats = '2' WHERE occ_id ='$ic'");
			if ($result AND $result_cp) {
				$this->occurrence_model->notif_not_close($is_stats_by,$ic);
			echo json_encode(1);
			}
		}

		else if($is_stats_by != $cb){
			$result_cp = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
			$result = $this->db->query("UPDATE tbl_occ SET occ_status = '1', occ_confirm_stats = '2' WHERE occ_id ='$ic'");
				$this->occurrence_model->notif_not_close($is_stats_by,$ic);
			echo json_encode(1);
			}	
	}
	public function print_ior($id){
		$this->load->library('pdf_portlet');
		$pdf = $this->pdf_portlet->load();
		$data['occurrence'] = $this->occurrence_model->Get_detail_occ($id);
		$data['occurrence_follow'] = $this->occurrence_model->Get_occ_follow($id);

		 foreach($data['occurrence'] as $occ){ 
		 	$occ_no = $occ->occ_no ; 
		 }
		$html = $this->load->view('pdf/per_data.php',$data, true);
		$pdf->SetTitle('OCCURRENCE '.$occ_no.'.pdf');
		// $pdf->SetAutoPageBreak(true);
		$pdf->SetHTMLHeader('</div><div align="center"><span style="text-align: center; font-weight: bold; font-size:13px;">OCCURRENCE REPORT</span> </div><div align="center"><span style="text-align: center; font-weight: bold;  font-size:13px;">Form GMF /Q-226 R9</span> </div><div class="marg" align="center"><img src="./assets/img/pdf/gmfpdf_header.png" alt="-" width="150" height="40" />');
		$pdf->SetHTMLFooter('Form GMF / Q-226 R9');
		
		// echo $html; die;
		$pdf->WriteHTML($html);		
		error_reporting(0);
		// print_r($pdf);
		// die;
		$pdf->Output();
		// $pdf->Output('OCCURRENCE '.$occ_no.'.pdf', 'D');
	}
	function occ_update($id){
		$e_occ_send_to		= $this->input->POST('e_send_to'); 
		$e_occ_sub			= $this->input->POST('e_subject'); 
		$e_occ_reff			= $this->input->POST('e_occ_reference'); 
		$e_occ_ambiguity	= $this->input->POST('e_ambiguity'); 
		$e_occ_category		= $this->input->POST('e_category');
		$e_occ_sub_category	= $this->input->POST('e_sub_category');
		$e_sub_category_stats = $this->input->POST('e_sub_category_stats'); 
		$e_occ_date			= $this->input->POST('e_occ_date'); 
		$e_occ_detail		= $this->input->POST('e_occ_detail'); 
		$occ_risk_idx 		= $this->input->POST('e_occ_risk_idx'); 
		$hahaha  =  nl2br($e_occ_detail);
		$doc = str_replace("'"," ",$hahaha);
		$e_occ_sub = str_replace("'","`",$e_occ_sub);
		$id = str_replace("'"," ",$id);
		$result = $this->db->query("UPDATE tbl_occ 
									SET  occ_send_to 		= '$e_occ_send_to',
										 occ_sub 			= '$e_occ_sub',
										 occ_reff 			= '$e_occ_reff', 
										 occ_ambiguity 		= '$e_occ_ambiguity',
										 occ_date 			= '$e_occ_date',
										 occ_detail 		= '$doc',
										 occ_category 		= '$e_occ_category',
										 occ_sub_category 	= '$e_occ_sub_category',
										 occ_sub_spec 	 	= '$e_sub_category_stats',
										 occ_risk_index 	= '$occ_risk_idx'
									WHERE occ_id ='$id'");
			if ($result) {
			echo json_encode(110);
			}
	}
	function revision_ior(){
		$id		= $this->input->POST('revparam'); 
		$reopen = $this->input->POST('reopen'); 
		$reopen_date = $this->input->POST('reopen_date'); 
		// $move_unit	 = $this->input->POST('move_to');
			//newtemplate fadil
			$emailtemplate['occurrence'] = $this->occurrence_model->Get_detail_occ($this->input->POST('revparam'));
			$emailtemplate['occurrence_follow'] = $this->occurrence_model->Get_occ_follow($this->input->POST('revparam'));
			$pesan = $this->load->view('email/emailfollow',$emailtemplate,TRUE);
	
			$emailsendto = $this->occurrence_model->emailsend($id);
				//$sendemail['getdata'] = $this->occurrence_model->emailsend($id);
				$sendtounit = $this->occurrence_model->sendtounit($emailsendto['occ_send_to']);
				$sendtounitemail = '';
				foreach ($sendtounit as $sendtounit) {
					$sendtounitemail .= $sendtounit['EMAIL'].',';
				}

				//echo $sendtounitemail ."-".$sendtounitemail;die;
			//end template
				$config = Array("protocol"  => "smtp",
							"smtp_host" => "mail.gmf-aeroasia.co.id",
							"smtp_port" => 25,
							"smtp_user" => "app.notif@gmf-aeroasia.co.id",
							"smtp_pass" => "app.notif",
							"mailtype"  => "html",
							"charset"   => "iso-8859-1",
							"wordwrap"  => TRUE );
					$this->load->library("email", $config);
					//$this->email->initialize($config);
					$this->email->set_newline("\r\n");
					$this->email->from("app.notif@gmf-aeroasia.co.id","IOR Closed/ Notification");            
					//$this->email->cc('list-tqy@gmf-aeroasia.co.id');
					$this->email->cc("fadhilatur7@gmail.com");
					// if ($sendtounitemail) {
					// 	$this->email->to($sendtounitemail);
					// }else{
					// 	$this->email->to($emailsendto["created_by"]);
					// }
					$this->email->to($sendtounitemail.$emailsendto["created_by"]);
					$this->email->subject("IOR Closed/ Notification");
					$this->email->message($pesan); 
					$this->email->send();
					// if (!$this->email->send())
					// {    
					// 	echo $this->email->print_debugger();
					// } 
		
		if ($reopen == 1 || $reopen == '1' ) {
			$result = $this->db->query("UPDATE tbl_occ 
									SET  occ_status 		= '1',
										 occ_confirm_stats 	= '1',
										 occ_estfinish_date = '$reopen_date'
									WHERE occ_id = '$id'");
		}
		else if ($reopen == 3 || $reopen == '3' ) {
			$result = $this->db->query("UPDATE tbl_occ 
									SET  occ_status 		= '3',
										 occ_confirm_stats 	= '3'
									WHERE occ_id = '$id'");
		}
		else{
			$result = $this->db->query("UPDATE tbl_occ 
									SET  occ_status 		= '1',
										 occ_confirm_stats 	= '1'
									WHERE occ_id ='$id'");
		}
		if ($result){
		
			echo json_encode(array("status" => TRUE ));
		}
	}
	function deleting_follow_on(){
		$id     = $this->input->post('fid');
		$result = $this->db->query("DELETE FROM tbl_occ_follow WHERE follow_id = '$id'");
		if ($result) {
			echo json_encode(array("status" => TRUE));
		}
	}
	function add_att_ohr(){
		$attby = $this->session->userdata('occ_users_1103')->username ;
		$attbyname = $this->session->userdata('occ_users_1103')->name ;
		$attbyname = str_replace("'","`",$attbyname);
		$id 	 			= $this->input->post('ocid');
		$ohrfile 			= $this->input->post('ohrfile');
		$attachdtionescrip  = $this->input->post('attachdtionescrip');
		$attachto  = $this->input->post('attachto');
		$numberior =  $this->occurrence_model->GetNumber($id);
		$ocno	   = $numberior[0]->occ_no ;
		$date	=	date("Y-m-d H:i:s");
		$dataFo_OHR = array (
								'occ_id'		 => $ocno,
								'follow_desc'	 => $attachdtionescrip,
				 				'attachment'	 => $ohrfile,
				 				'follow_by' 	 => $attby,
				 				'follow_by_name' => $attbyname,
				 				'follow_date'    => $date,
				 				'follow_next'    => $attachto,
								);
		$isdataFo_OHR = $this->occurrence_model->Insert('tbl_occ_follow_ohr', $dataFo_OHR);
		$result  = $this->db->query("UPDATE tbl_occ_ohr SET non_occ_file = '$ohrfile'  WHERE occ_id = '$id'");
		if ($result) {
			echo json_encode(array("status" => TRUE));
		}	
	}

	function c_ncr(){
		$attby = $this->session->userdata('occ_users_1103')->username ;
		$attbyname = $this->session->userdata('occ_users_1103')->name ;
		$attbyname = str_replace("'"," ",$attbyname);
		$at = $this->input->post('at');
		$pin = $this->input->post('pin');
		$c_reason = $this->input->post('c_reason');
		$file_name_nc = $this->input->post('file_name_ncr');
		$date	=	date("Y-m-d H:i:s");
		foreach ($file_name_nc as $keys => $value) {
			$attach = $file_name_nc[$keys];
		}
		$dataFollow = array('occ_id'			=> $at,
			      			'follow_desc'		=> $c_reason,
			      			'follow_by'			=> $attby,
			      			'follow_by_name'	=> $attbyname,
			      			'follow_by_unit'	=> '-',
			      			'follow_next'		=> '-',
			      			'follow_est_finish'	=> '-',
			      			'follow_date'		=> $date, 
			      			'attachment'		=> $attach,);
		$result_op 		 = $this->occurrence_model->Insert('tbl_occ_follow', $dataFollow);
		if ($pin == 0) {
			$result  = $this->db->query("UPDATE tbl_occ SET occ_probability = '0'  WHERE occ_id = '$at'");
		}
		else {
			$result  = $this->db->query("UPDATE tbl_occ SET occ_probability = '1'  WHERE occ_id = '$at'");	
		}

		if ($result) {
			echo json_encode(5);
		}	
	}

	public function ftp_attach_ku(){

			$query = $this->db->query("SELECT tbl_occ.occ_no, tbl_occ_file.file_name FROM tbl_occ JOIN tbl_occ_file ON tbl_occ.occ_no = tbl_occ_file.occ_id WHERE created_by_unit = 'UNKNOWN' AND occ_follow_last_by = 'N/A' AND file_name != ''")->result_array();
			// var_dump($query);die;

				
                

                foreach ($query as $querydata) {
                 if(file_exists('/var/www/html/app_ior/upload_guest/'.$querydata['file_name'])){
                $this->load->library('ftp');
                //FTP configuration
                $ftp_config['hostname'] = 'tq-stg.gmf-aeroasia.co.id';
                // $ftp_config['hostname'] = '192.168.40.107';
                $ftp_config['username'] = 'ior';
                $ftp_config['password'] = 'aeroasia';
                // $ftp_config['hostname'] = '192.168.40.127';
                // $ftp_config['username'] = 'usergmf';
                // $ftp_config['password'] = 'aeroasia';
                $ftp_config['debug']    = TRUE;
                //Connect to the remote server
                $this->ftp->connect($ftp_config);
                $source = '/var/www/html/app_ior/upload_guest/'.$querydata['file_name'];
                // var_dump($source);die;
                $destination = '/Upload_IOR/'.$fileName;
                //$destination = '/File_IOR_TEST/Uploads/'.$querydata['file_name'];
                //Upload file to the remote server
                 $this->ftp->upload($source, ".".$destination);
                //Close FTP connection
                $this->ftp->close();
                	}
                }


                return array('status'=>'1', 'message'=>'ok');
    }
    


	public function attact_to_ftp(){
		$upload = $this->ftp_attach_ku();
		// var_dump($upload);die;
			if($upload['status'] == '1'){
			$file = $upload['message'];
			$file = preg_replace('/\s/','',$file);
		}

		echo "$file";
	}

	function emailtest()
	{
		$config = Array('protocol'  => 'smtp',
                        'smtp_host' => 'mail.gmf-aeroasia.co.id',
                        'smtp_port' => 25,
                        'smtp_user' => 'app.notif@gmf-aeroasia.co.id',
                        'smtp_pass' => 'app.notif',
                        'mailtype'  => 'html',
                        'charset'   => 'iso-8859-1',
                        'wordwrap'  => TRUE );
				$this->load->library('email', $config);
				$this->email->set_newline('\r\n');
				$this->email->from('app.notif@gmf-aeroasia.co.id','IOR Accepted/ Notification');             
				//$this->email->cc('list-tqy@gmf-aeroasia.co.id');
				$this->email->to('fadilatur38@gmail.com');
				$this->email->subject('IOR Accepted/ Notification');
				$this->email->message('testing fadil'); 
				$this->email->send();
				if (!$this->email->send())
				{    
					echo $this->email->print_debugger();
				} 
	}
	
}