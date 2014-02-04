$(function(){
	var dropbox = $('#dropbox'),
		message = $('.message', dropbox),
		button  = $('#file-input');
	
	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'image',
		
		maxfiles: 5,
    	maxfilesize: 2,
		url: '/upload/process/',
		
		uploadFinished:function(i,file,response){
			if(response.type == 'error') {
				alert('There was an error: ' + response.status);
				$.data(file).addClass('error');
				$.data(file).find('.linkBox').remove();
				$.data(file).find('.directLinkBox').remove();

				return false;
			} else {
				$.data(file).addClass('done');
				$.data(file).find('.linkBox').val(response.file);	
				$.data(file).find('.directLinkBox').val(response.direct);
				$.data(file).find('input').click(function() {
					this.focus();
					this.select();
				});
			}
			// response is the JSON object that post_file.php returns
		},
		
    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					showMessage('Your browser does not support HTML5 file uploads!');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select 5 at most! (configurable)');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 2mb (configurable).');
					break;
				default:
					break;
			}
		},
		
		// Called before each upload is started
		beforeEach: function(file){
			if(!file.type.match(/^image\//)){
				alert('Only images are allowed!');
				
				// Returning false will cause the
				// file to be rejected
				return false;
			}
		},
		
		uploadStarted:function(i, file, len){
			createImage(file);
		},
		
		progressUpdated: function(i, file, progress) {
			$.data(file).find('.progress').width(progress + "%");
		}
    	 
	});
	
	var template = '<div class="preview">' +
						'<span class="imageHolder">' +
							'<img />' +
							'<span class="uploaded"></span>' +
						'</span>' +
						'<div class="progressHolder">' +
							'<div class="progress"></div>' +
						'</div>' +
						'<div class="linkHolder">' +
							'<input type="text" class="linkBox" />' +
						'</div>' +
						'<div class="direct linkHolder">' +
							'<input type="text" class="directLinkBox" />' +
						'</div>' +
					'</div>'; 
	
	
	function createImage(file){

		var preview = $(template), 
		image = $('img', preview);
			
		var reader = new FileReader();
		
		image.width = 100;
		image.height = 100;
		
		reader.onload = function(e){
			
			// e.target.result holds the DataURL which
			// can be used as a source of the image:
			
			image.attr('src',e.target.result);
		};
		
		// Reading the file as a DataURL. When finished,
		// this will trigger the onload function above:
		reader.readAsDataURL(file);
		
		message.hide();
		preview.appendTo(dropbox);
		
		// Associating a preview container
		// with the file, using jQuery's $.data():
		
		$.data(file,preview);
	}

	function showMessage(msg){
		message.html(msg);
	}

	// Button upload support
	button.change(function(){
		var fileList = this.files;

		if (fileList.length > 0) {
			// Send this as if it were dropped
			var e = $.Event("drop", {
				dataTransfer: {
					files: fileList,
				},
			});
			dropbox.trigger(e);
		}
	});

    // Clipboard paste support
    $(document).bind("paste", function(e) {
        if (e.originalEvent && e.originalEvent.clipboardData && e.originalEvent.clipboardData.items) {
            var items = e.originalEvent.clipboardData.items;
            for (var i = 0; i < items.length; i++) {
                var file = items[i];
                if (file.type == "image/png") {
                    // Send this as if it were dropped
                    file = file.getAsFile();
                    file.name = "paste_" + Math.random().toString(16).slice(2) + ".png";
                    var e = $.Event("drop", {
                        dataTransfer: {
                            files: [file],
                        },
                    });
                    dropbox.trigger(e);
                    return;
                }
            }
        }
    });
});
