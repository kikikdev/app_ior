<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Oldoccurrence extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('old_occurrence_model');
	} 
	public function index(){
		echo "Opps you cannot here :P !";
	}

	function get_old_list($id) {
		$todetail = $this->old_occurrence_model->get_old_list($id);
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $permission = $detaildata->permission;
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_occ_detail('.$detaildata->occ_id.')">'.substr($detaildata->occ_sub, 0,25).'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->occ_date;
			                    if ($detaildata->occ_send_to == 'N/A') {
			                    	$row[] = '<label class="badge badge-danger">Unknown UIC</label>' ;
			                    }
			                    else{
			                    $row[] 	= $detaildata->occ_send_to;
			                    }
			                    $row[] 	= $detaildata->occ_follow_last_by;	
			                    $row[] 	= $detaildata->created_date;
			                    $row[] = '<label class="label label-success label-form">Closed</label>';
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
}