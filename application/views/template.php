<!DOCTYPE html>
<head>
	<head>
		<title>No Chicks Allowed: Image Repository</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" media="all" href="/css/html5reset-1.6.1.css" />
		<link rel="stylesheet" type="text/css" media="all" href="/css/style.css" />

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>

		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>

    <body>
		<header>
			<div id="title"><h1><a href="http://www.nca-guild.com">No Chicks Allowed</a></h1></div>
			<div id="links">
				<a href="/upload" id="upload"><span class="underline">U</span>pload</a> |
				<a href="/gallery" id="gallery"><span class="underline">G</span>allery</a> |
				<a href="/latest" id="latest"><span class="underline">L</span>atest</a> |
				<a href="/random" id="random"><span class="underline">R</span>andom</a>
			</div>
		</header>

<?php echo $contents; ?>
		<script type="text/javascript">
			$(document).keydown(function(e) {
				var key = e.keyCode || e.which;

				switch(key) {
					case 82:
						document.location.href = $('#random').attr('href');
						break;
					case 71:
						document.location.href = $('#gallery').attr('href');
						break;
					case 76:
						document.location.href = $('#latest').attr('href');
						break;
					case 85:
						document.location.href = $('#upload').attr('href');
						break;
				}
			});
		</script>
		<script src="js/jquery.filedrop.js"></script>
		<script src="js/upload.js"></script>
   </body>
</html>