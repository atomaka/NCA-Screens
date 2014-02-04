<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
	public function index()	{
		$this->template->load('template','upload');
	}

	public function process() {
		header('Content-Type: text/html',true); //application/json

		$temp_name = md5(rand());

		// cannot move partial config to config directory with this class?
		$config = array(
			'max_size'					=> 2048,
			'upload_path'				=> './uploads/',
			'allowed_types'				=> 'gif|jpg|jpeg|png|bmp'
		);
		// end stuff that should be removed.
		$config['file_name']			= $temp_name;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('image')) {
			$message = array('type' => 'error', 'status' => $this->upload->display_errors());
		} else {
			$upload = $this->upload->data();

			$hash 					= md5_file($upload['full_path']);
			$width 					= $upload['image_width'];
			$height 				= $upload['image_height'];
			$size 					= $upload['file_size'];

			$this->load->model('fileupload');
			$duplicate = $this->fileupload->check_duplicate($hash);
			
			if($duplicate) {
				unlink($upload['full_path']);

				$message = array(
					'type'			=> 'error', 
					'status'		=>'You are attempting to upload a duplicate of <a href="' . base_url($duplicate) . '" style="text-decoration:underline">image ' . $duplicate . '</a>.'
				);
			} else {
				$file_name = $this->fileupload->add_upload($upload['file_ext'], $upload['client_name'],$width,$height,$size,$hash);

				rename($upload['full_path'], $upload['file_path'] . $file_name . $upload['file_ext']);

				$config = array(
					'source_image'	=> $upload['file_path'] . $file_name . $upload['file_ext'],
					'new_image'		=> './thumbs/' . $file_name . $upload['file_ext'],
				);

				$this->load->library('image_lib');
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
			
				$message = array(
					'type'   => 'success',
					'status' => 'Uploaded successfully',
					'file'   => base_url($file_name),
					'direct' => base_url('uploads/' . $file_name . $upload['file_ext']),
				);
			}
		}

		echo json_encode($message);
	}
}
