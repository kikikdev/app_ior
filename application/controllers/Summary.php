<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends MX_Controller {
	private $employe ; 
	public function __construct(){
		parent::__construct();
		$this->load->model('summary_model');
	}
	public function index(){	
		$this->load->view('templates/index_tpl');
	} 
	function get_summary(){
		$detail = $this->summary_model->Get_summary();
		echo json_encode($detail);
	}
	function get_summary_monthly(){
		$detail = $this->summary_model->Get_summary_monthly();
		//echo json_encode($detail[0]);
		foreach($this->summary_model->Get_summary_monthly() as $row){
			   $data[]=(float)$row['Jan'];
			   $data[]=(float)$row['Feb'];
			   $data[]=(float)$row['Mar'];
			   $data[]=(float)$row['Apr'];
			   $data[]=(float)$row['May'];
			   $data[]=(float)$row['Jun'];
			   $data[]=(float)$row['Jul'];
			   $data[]=(float)$row['Aug'];
			   $data[]=(float)$row['Sept'];
			   $data[]=(float)$row['Oct'];
			   $data[]=(float)$row['Nov'];
			   $data[]=(float)$row['Decc'];
			  }
			  echo json_encode($data);
	}
	function get_summary_monthly_status(){
		$status = $this->summary_model->Get_summary_monthly_status();
     		foreach ($status as $data){ 
	                    $row[] = array (
	                    		'name' => $data->status_desc,
	                    		'y'  => (int)$data->open, 	                    		
	                    		'drilldown' => "IOR Database",
	                    		);
	                }

						echo json_encode($row);
	}
	function get_summary_monthlyAll(){
		$detail = $this->summary_model->Get_summary_monthlyAll();
		foreach($detail as $row){
			   $data[]=(float)$row['Jan'];
			   $data[]=(float)$row['Feb'];
			   $data[]=(float)$row['Mar'];
			   $data[]=(float)$row['Apr'];
			   $data[]=(float)$row['May'];
			   $data[]=(float)$row['Jun'];
			   $data[]=(float)$row['Jul'];
			   $data[]=(float)$row['Aug'];
			   $data[]=(float)$row['Sept'];
			   $data[]=(float)$row['Oct'];
			   $data[]=(float)$row['Nov'];
			   $data[]=(float)$row['Decc'];
			  }
			  echo json_encode($data);
	}
	function getList_out_NeedV() {
		$todetail = $this->occurrence_model->GetList_out_NeedV();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $row[] 	= '<div class="btn-group btn-group-xs">
			                    			<a href="#" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
			                    					<i class="fa fa-wrench"></i>
			                    			</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li class="btn-warning"><a href="#">Print</a></li>
                                                </ul>
			                    			</div>';
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" onclick="v_occ_detail('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by;
			                    $row[] 	= $detaildata->occ_send_to;
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	function get_occ_for_self() {	
		$todetail = $this->summary_model->Getoccunit_in();
		$data = array();
					$no = 1 ;
                   		$detail = $todetail ;
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $row[] 	= $detaildata->occ_no;
			                    $row[] 	= '<a href="#" class="class="mail-text" onclick="v_occ_detail('.$detaildata->occ_id.')">'.$detaildata->occ_sub.'</a>';
			                    $row[] 	= $detaildata->occ_date;
			                    $row[] 	= $detaildata->created_by;
			                    $row[] 	= $detaildata->occ_send_to;
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	
}

