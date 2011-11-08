<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
	public function index()	{
		$this->template->load('template','upload');
	}

	public function process() {
		header('Content-Type: application/json',true);

		$temp_name = md5(rand());

		$config = array(
			'file_name'					=> $temp_name,
			'max_size'					=> 2048,
			'upload_path'				=> './uploads/',
			'allowed_types'				=> 'gif|jpg|jpeg|png|bmp'
		);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('image')) {
			$message = array('type' => 'error', 'status' => $this->upload->display_errors());
		} else {
			$upload = $this->upload->data();

			$this->load->model('fileupload');
			$file_name = $this->fileupload->add_upload($upload['file_ext'], $upload['client_name']);
			rename($upload['full_path'], $upload['file_path'] . $file_name . $upload['file_ext']);

			$config = array(
				'image_library'			=> 'gd2',
				'source_image'			=> $upload['file_path'] . $file_name . $upload['file_ext'],
				'create_thumb'			=> true,
				'maintain_ratio'		=> true,
				'width'					=> 175,
				'height'				=> 175,
				'new_image'				=> './thumbs/' . $file_name . $upload['file_ext'],
				'thumb_marker'			=> '',
			);

			$this->load->library('image_lib',$config);
			$message = array('type'=>'success','status'=>'Uploaded successfully', 'file'=>base_url($file_name));
		}

		echo json_encode($message);
	}
}