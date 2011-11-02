var previewHtml = 
'<div class="preview">' +
	'<span class="imagePreview">' + 
		'<img /><span class="imageSuccess"></span>' +
	'</span>' +
	'<div class="imageProgress"><div class="progressBar"></div></div>' +
'</div>';

$('#drop').filedrop({
	url: 			'upload.php',
	paramname: 		'file', 
	maxfiles: 		4,
	maxfilesize: 	1,

	beforeEach: 		function(file) {
		// alert('temp attempting upload')	;
	},
	uploadStarted: 		function(i, file, len) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
			alert(e.target.result);
			$('img',$(previewHtml)).attr('src', e.target.result);
		}

		reader.readAsDataURL(file);
		$(previewHtml).appendTo($('#drop'));

		$.data(file, $(previewHtml));l
	},
	progressUpdated: 	function(i, file, progress) {
		$.data(file).find('.progressBar').width(progress);
	}, 
	uploadFinished: function(i, file, response, time) {
		$.data(file).addClass('complete');
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