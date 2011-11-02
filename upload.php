<?php 
/**
 * Upload - Handles uploading files
 *
 * Takes an upload request from jquery.filedrop and stores the incoming
 * files on the server for later viewing.
 *
 * @author Andrew Tomaka
 * @version 1
 **/

define('UPLOADS','uploads/');

if(array_key_exists('image', $_FILES)) {
	$file = $_FILES['image'];

	move_uploaded_file($file['tmp_name'], UPLOADS . $file['name']);
}

echo json_encode(array('status'=>'Uploaded successfully','file'=>'http://screens.p5dev.com/' . UPLOADS . $file['name']));
?>