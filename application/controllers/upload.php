<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
	public function index()	{
		$this->template->load('template','upload');
	}

	public function process() {
		header('Content-Type: application/json',true);

		$config['file_name'] 		= 135;
		$config['max_size']			= 2048;
		$config['upload_path']		= './uploads/';
		// $config['allowed_types']	= 'gif|jpg|jpeg|png|bmp';
		$config['allowed_types']	= 'jpg';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('image')) {
			print_r($this->upload->data());
			$message = array('type' => 'error', 'status' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());
			$message = array('type'=>'success','status'=>'Uploaded successfully','file'=>'http://screens.p5dev.com/' . $data['file_name']);
		}

		echo json_encode($message);
	}
}