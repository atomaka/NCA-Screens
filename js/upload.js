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