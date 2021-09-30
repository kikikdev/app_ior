<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fileupload extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
	
		$this->load->view('templates/upload_tpl');
	}
	public function json(){
		$options = [
			'script_url' => site_url('upload/json'),
			'upload_dir' => APPPATH . '../uploads/files/',
			'upload_url' => site_url('uploads/files/')
		];
		$this->load->library('UploadHandler', $options);
	}
	public function form_upload(){
		$this->load->view('templates/upload_temp');
	}
	public function uploadftp(){
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
                
                //FTP configuration
                //ftp://ior:aeroasia@tq-stg.gmf-aeroasia.co.id/Upload_IOR/
                //prod
                 $ftp_config['hostname'] = 'tq-stg.gmf-aeroasia.co.id';
                // $ftp_config['hostname'] = '192.168.40.107';
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
                //prod
                $destination = '/Upload_IOR/'.$fileName;
                //dev
                //$destination = '/File_IOR_TEST/Uploads/'.$fileName;
                //Upload file to the remote server
                $this->ftp->upload($source, ".".$destination);
                //Close FTP connection
                $this->ftp->close();
                return array('status'=>'1', 'message'=>$this->upload->data());
            }
    }
	public function cobaupload(){
		$this->load->library('ftp');
		$upload = $this->uploadftp();

			if($upload['status'] == '1'){
			$file = $upload['message']['file_name'];
		}

		echo "$file";
	}
	public function ftp_attach(){
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
	public function attach_ftp(){
		$this->load->library('ftp');
		$upload = $this->ftp_attach();

			if($upload['status'] == '1'){
			$file = $upload['message'];
			$file = preg_replace('/\s/','',$file);
		}

		echo "$file";
	}
}