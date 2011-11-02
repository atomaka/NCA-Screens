<!DOCTYPE html>
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
		<div id="drop">

		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script src="js/jquery.filedrop.js"></script>
		<script>
			$('#drop').filedrop({
				url: 			'upload.php',
				paramname: 		'file', 
				maxfiles: 		4,
				maxfilesize: 	1,

				uploadFinished: function(i, file, response, time) {
					
				},
				beforeEach: 	function(file) {
					alert('temp attempting upload')	;
				},

				error: 			function(type, file) {
					switch(type) {
						case 'BrowserNotSupported':
							alert('temp no html5 drag and drop');
							break;
						case 'TooManyFiles':
							alert('temp too many files (max:4)');
							break;
						case 'FileTooLarge':
							alert('temp' + file.name + ' too large (max:1mb');
							break;
						default:
							break;
					}
				},
			});
		</script>
   </body>
</html>