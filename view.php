<?php
$conf = json_decode(file_get_contents('database.conf'));

$id = isset($_GET['image']) ? $_GET['image'] : '';

if($id == '' ) {
	// redirect to gallery; do with .htaccess?
	$message = 'id not set';
} else {
	if(!is_numeric($id) || $id <= 0) {
		$message = 'This image does not exist: bad id format (' . $id . ')';
	} else {
		$db = mysqli_init();
		$db->real_connect($conf->hostname, $conf->username, $conf->password, $conf->database);

		$query = "SELECT extension, created, original FROM screens WHERE id = $id";
		$result = $db->query($query);

		if($result->num_rows == 0) {
			$message = 'This image does not exist: not in database';
		} else {
			// load tags

			$image = $result->fetch_object();
			$imageOutput = '<img src="uploads/' . $id . '.' . $image->extension . '" class="image" />';
			$message = 'Uploaded on: ' . $image->created;
			$message .= '<br/>Original name: ' . $image->original;
			$message .= '<br/>View Raw: <a href="uploads/' . $id . '.' . $image->extension . '">'. $id . '.' . $image->extension . '</a>';
		}
	}
}

?><!DOCTYPE html>
<head>
	<head>
		<title>No Chicks Allowed: Image Repository</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" media="all" href="css/html5reset-1.6.1.css" />
		<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />

		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>

    <body>
		<header>
			<h1>title or navigation or something</h1>
		</header>
<?if (isset($imageOutput)) { ?>
		<div id="imageContainer">
<?php echo $imageOutput; ?>
		</div>
<?php } ?>
		<div id="message">
<?php echo $message; ?>
		</div>

		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
   </body>
</html>