<?php
$conf = json_decode(file_get_contents('database.conf'));

$id = isset($_GET['image']) ? $_GET['image'] : '';

if($id == '' ) {
	// redirect to gallery; do with .htaccess?
	$content = 'id not set';
} else {
	if(!is_numeric($id) || $id <= 0) {
		$content = 'This image does not exist: bad id format (' . $id . ')';
	} else {
		$db = mysqli_init();
		$db->real_connect($conf->hostname, $conf->username, $conf->password, $conf->database);

		$query = "SELECT extension, created FROM screens WHERE id = $id";
		$result = $db->query($query);

		if($result->num_rows == 0) {
			$content = 'This image does not exist: not in database';
		} else {
			// load tags

			$image = $result->fetch_object();
			$content = '<img src="uploads/' . $id . '.' . $image->extension . '" />';
			$content .= '<br/>Created on: ' . $image->created;
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

		<div style="margin-top: 200px;">
<?php echo $content; ?>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
   </body>
</html>