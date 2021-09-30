<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('report_model');
	} 
	public function index(){
		echo "Opps you cannot here :P !";
	}
	
	public function download_biweekly(){
		$start 	= $this->input->POST('start');	
		$end 	= $this->input->POST('end');
		// echo $start;
		// echo $end;die;
		$data['occurrence'] = $occurrence = $this->report_model->Get_occurrence_list($start,$end);
		$data['start'] = $start ;
		$data['end'] = $end ;

		 $this->load->view('excell/per_data.php',$data);		 
		
	}
	public function download_yearly(){

		$start 	= $this->input->POST('start');
		var_dump($start); die();
		$data['occurrence'] = $occurrence = $this->report_model->Get_occurrence_list_yearly($start);
		$data['start'] = $start ;
		$data['end'] = $end ;
		$this->load->view('excell/per_data.php',$data);		
	}
	public function search(){
		$occ_no 		= $this->input->POST('s_numb');
		$occ_sub 		= $this->input->POST('s_occ_sub');
		$occ_cat 		= $this->input->POST('s_occ_cat');
		$o_date_s  		= $this->input->POST('o_date_s');
		$o_date_u 		= $this->input->POST('o_date_u');
		$i_date_s		= $this->input->POST('i_date_s');
		$i_date_u 		= $this->input->POST('i_date_u');
		$s_occ_to		= $this->input->POST('s_occ_to');
		$s_occ_by_unit	= $this->input->POST('s_occ_by_unit');
		$s_occ_status	= $this->input->POST('s_occ_status');
		$s_occ_risk		= $this->input->POST('s_occ_risk');
		$s_keyword		= $this->input->POST('s_keyword');
		$data = array();
					$no = 1 ;
                   		$result = $this->report_model->Get_occurrence_filtered($occ_no,$occ_sub,$occ_cat,$o_date_s,$o_date_u,$i_date_s,$i_date_u,$s_occ_to,$s_occ_by_unit,$s_occ_status,$s_occ_risk,$s_keyword);
                   		foreach ($result as $listdata){ 
                   			$bydetail = str_replace(";",":",$listdata->occ_detail);
			                    $row = array();
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="'.site_url('occurrence/print_ior').'/'.$listdata->occ_id.'" target="_blank">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $listdata->occ_no;
			                    $row[] 	= $listdata->cat_name;
			                    $row[] 	= $listdata->cat_sub_desc;
			                    $row[] 	= $listdata->occ_sub;
			                    $row[] 	= $listdata->occ_risk_index;
			                    $row[] 	= $listdata->occ_date;
			                    $row[] 	= substr($bydetail, 0, 40).'-...';
			                    $row[] 	= $listdata->occ_send_to;
			                    $row[] 	= $listdata->created_date;
			                    $row[] 	= $listdata->created_by_name;
			                    $row[] 	= $listdata->InsertBy;
			                    if ($listdata->occ_status >= 0 ) {
			                    	$row[] 	= 'OVERDUE';
			                    }
			                    if ($listdata->occ_status == 1 AND $listdata->occ_confirm_stats == 1 ) {
			                    	$row[] 	= 'OPEN';
			                    }
			                    if ($listdata->occ_status == 1 AND $listdata->occ_confirm_stats == 2 ) {
			                    	$row[] 	= 'PROGRES';
			                    }
			                    if ($listdata->occ_status == 1 AND $listdata->occ_confirm_stats == 3 ) {
			                    	$row[] 	= 'WAITING CLOSE';
			                    }
			                    if ($listdata->occ_status == 0 AND $listdata->occ_confirm_stats == 0 ) {
			                    	$row[] 	= 'NCR';
			                    }
			                    if ($listdata->occ_status == 3 AND $listdata->occ_confirm_stats == 3 ) {
			                    	$row[] 	= 'CLOSE';
			                    }
			                    $row[] 	= str_replace(',', "<br>", $listdata->follow_by_name) ;
			                    $row[] 	= str_replace(',', "<br>", $listdata->follow_date) ;
			                    $row[] 	= $listdata->follow_desc;
			                    $data[] = $row;
                		}
			$output = array("data" => $data,);
			echo json_encode($output);
		
	}
}