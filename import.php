<?php 

$config 						= json_decode(file_get_contents('nca.conf'));
$db 							= mysqli_init();

$db->real_connect($conf->hostname,$conf->username,$conf->password,
		$conf->database);

$upload_dir						= '/home/ncaguild/nca-guild.com/screens/uploads/';
$uploads 						= scandir($upload_dir);

$imports						= array();

$failed = 0;
foreach($uploads as $upload) {
	$current = array(
		'old'					=> $upload,
	);
	if(preg_match('/^([0-9]+)(\..*)/', $upload, $matches) == 0) {
		$current['error']		= 'File is not in screens format';
		$imports[]				= $current;
		$failed++;
		continue;
	}

	$id 						= $matches[1];
	$extension					= $matches[2];
	$size						= getimagesize($upload_dir . $upload);
	$width						= $size[0];
	$height						= $size[1];
	$file_size					= filesize($upload_dir . $upload) / 1024;
	$hash						= md5_file($upload_dir . $upload);
	$duplicate					= check_duplicate($hash);

	if($file_size > 2048) {
		$current['error']		= 'File size exceeds 2048kb';
		$imports[]				= $current;
		$failed++;
		continue;
	}
	if(preg_match('/(gif|jpg|jpeg|png|bmp)/',$upload) == 0) {
		$current['error']		= 'File extension not supported';
		$imports[]				= $current;
		$failed++;
		continue;
	}
	if($duplicate) {
		$current['error']		= 'File is a duplicate: ' . $id;
		$imports[]				= $current;
		$failed++;
		continue;
	}

	$query = $db->prepare("INSERT INTO uploads (id,extension,original_name,width,height,size,hash) VALUES(?,?,?.?.?.?)");
	$query->bind_param('isssiids',$id, $extension, 'unknown', $width, $height, $size, $hash);
	$query->execute();
	$query->close();

	$current['height']			= $height;
	$current['width']			= $width;
	$current['file_size']		= $file_size;
	$current['hash']			= $hash;
	$current['extension']		= $extension;

	$imports[]					= $current;
}

function check_duplicate($hash) {
	// code incoming
	return false;
}
?>
<style type="text/css">
#uploadTable {
	border-collapse: collapse;
	border: 2px solid black;
	margin-left: auto;
	margin-right: auto;
}

#uploadTable th {
	font-weight: bold;
	border: 2px solid black;
	padding: 5px;
}

#uploadTable td {
	border: 2px solid black;
	padding: 1px;
}

.error {
	color: red;
}

.success {
	color: green;
}
</style>
Total Imports: <?php echo count($uploads); ?> (<?php echo $failed; ?> failed)<br/>
<div id="message">
	<table width="100%" id="uploadTable">
		<tr>
			<th>File Name</th>
			<th>Dimensions</th>
			<th>File Size</th>
			<th>Hash</th>
			<th>Extension</th>
		</tr>
<?php foreach($imports as $import) { ?>
		<tr>
			<td><?php echo $import['old']; ?></td>
	<?php if(array_key_exists('error',$import)) { ?>
			<td colspan="4">
				<?php echo $import['error']; ?>
			</td>
	<?php } else { ?>
			<td><?php echo $import['width']; ?>x<?php echo $import['height']; ?></td>
			<td><?php echo $import['file_size']; ?>kb</td>
			<td><?php echo $import['hash']; ?></td>
			<td><?php echo $import['extension']; ?></td>
	<?php } ?>
		</tr>
<?php } ?>
	</table>
</div>