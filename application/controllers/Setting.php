<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('setting_model');
	} 
	public function index(){	
		$this->load->view('templates/setting_tpl');
	}
	public function get_det_cat($id){
		$detail = $this->setting_model->Get_det_category($id);
		echo json_encode($detail);
	}
	public function add_category(){
		$cat_name	= $this->input->POST('cat_name'); 
		echo json_encode($cat_name);
	}
	public function getcat() {
		$data = array();
					$no = 1 ;
                   	$detail = $this->setting_model->Get_set_category();
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $row[] 	= $no++ .'.'; 
			                    $row[] 	= $detaildata->cat_name;
			                    $row[] 	= '<div class="form-group">
                                            <div class="col-md-12">              
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-default" onclick="e_category('.$detaildata->cat_id.')">Edit</button>
                                                    <button class="btn btn-default">Delete</button>
                                                </div>      
                                            </div>
                                        </div>';
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}
	public function getsubcat() {
		$data = array();
					$no = 1 ;
                   	$detail = $this->setting_model->Get_set_subcategory();
                   		foreach ($detail as $detaildata){ 
			                    $row = array();
			                    $row[] 	= $no++ .'.'; 
			                    $row[] 	= $detaildata->cat_sub_desc;
			                    $row[] 	= $detaildata->cat_name;
			                    $row[] 	= '<div class="form-group">
                                            <div class="col-md-12">              
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-default">Edit</button>
                                                    <button class="btn btn-default">Delete</button>
                                                </div>      
                                            </div>
                                        </div>';
			                    $data[] = $row;
                		}
               $output = array("data" => $data,);
                echo json_encode($output);
	}


}

