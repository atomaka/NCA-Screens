<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

	public function index() {
		$this->load->model('fileupload');
		$total_uploads = $this->fileupload->count_uploads();

		if($total_uploads == 0) {
			$this->template->load('template','/import/index');
		} else {
			$this->template->load('template','/import/onetime');
		}
	}

	public function process() {
		$old_uploads = '/home/ncaguild/nca-guild.com/screens/old_uploads/';
		$new_uploads = '/home/ncaguild/nca-guild.com/screens/uploads/';
		// load all file
		$uploads = scandir($old_uploads);

		$this->load->model('fileupload');

		$data['uploads'] = array();
		// foreach file
		foreach($uploads as $upload) {
			// if it is formatted correctly
			if(preg_match('/^([0-9]+)(\..*)/', $upload, $matches) != 0) continue;
			$extension = $matches[1];
			$old_id = $matches[0];
			$size = getimagesize($old_uploads . $upload);
			$width = $size[0];
			$height = $size[1];
			$file_size = filesize($old_uploads . $upload) / 1024;
			$hash = md5_file($old_uploads . $upload);
			$duplicate = $this->fileupload->check_duplicate($hash);

			if($file_size > 2048) {
				$data['uploads'][] = array(
					'old'		=> $upload,
					'error'		=> 'File size exceeds 2048kb',
				);
				continue;
			}
			if(preg_match('/(gif|jpg|jpeg|png|bmp)/',$upload) == 0) {
				$data['uploads'][] = array(
					'old'		=> $upload,
					'error'		=> 'File extension not supported',
				);
				continue;
			}
			if($duplicate) {
				$data['uploads'][] = array(
					'old'		=> $upload,
					'error'		=> 'File is a duplicate of id <b>'. $duplicate . '</b>',
				);
				continue;
			}

			// add a row to the database
			$file_name = $this->fileupload->add_upload($extension, 'unknown', $width, $height, $file_size, $hash);

			// copy in case we screwed up and can fix later
			copy($old_uploads . $upload, $new_uploads . $file_name . $extension);

			// create the new thumbmail	
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
			$this->image_lib->resize();

			$data['uploads'][]	= array(
				'old'			=> $upload,
				'new_id'		=> $new_id,
				'height'		=> $height,
				'width'			=> $width,
				'file_size'		=> $file_size,
				'hash'			=> $hash,
				'extension'		=> $extension,
			);
		}

		$this->load->vars($data);
		$this->template->load('template','/import/complete');
	}
	
}

?>