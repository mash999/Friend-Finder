
$(document).ready(function(){
	// UPLOAD STATUS MEDIA CONTROL
	// IF VIDEO IS SELECTED, IMAGE FIELD GETS CLEARED
	// IF IMAGE IS SELECTED, VIDEO FIELD GETS CLEARED
	$('.upload-media').on('change',function(){
		var $this = $(this);
		$this.siblings('.upload-media').val('');
		$('#media-type').val($this.data('accepts'));
	});


	// IF IMAGE IS SELECTED AS THE STATUS MEDIA, CHECK FOR IMAGE VALIDATIONS
	// IMAGE VALIDATION INCLUDES -> WHETHER THE FILE IS ACTUALLY AN IMAGE, THE SIZE OF THE FILE < 5MB, MAXIMUM NUMBER OF IMAGES = 5
	$('#upload-images').on('change',function(){
		var $this = $(this);
		var limitExceeded = fileTooBig = notAnImage = selectedFiles = "";
		var total = $this[0].files.length;
		console.log($this[0].files);
		if(total > 10) limitExceeded = "You can not upload more than 10 images in a single post";
		for(var i=0; i<total; i++){
			var fileName = $this[0].files[i].name.replace(/C:\\fakepath\\/i, '');
			var baseName = fileName.substr(0,fileName.lastIndexOf('.'));
			var extension = fileName.substr(fileName.lastIndexOf('.') + 1);
			if(baseName.length > 40) var displayName = baseName.substr(0,37) + ' ... .' + extension;
			else var displayName = fileName;
			selectedFiles += "<li data-name='" + fileName + "'>" + displayName + " &nbsp; <i class='fa fa-times'></i></li>";
			if(allowedImageExtension(extension)){
				if($this[0].files[i].size > 5000000){
					fileTooBig += "\nThe size of the file " + fileName + " is too big";
				}
			}
			else{
				notAnImage += "\nThe extension of the file " + fileName + " is not acceptable as an image";
			}
		}
		if(limitExceeded != "" || fileTooBig != "" || notAnImage != ""){
			$this.val('');
			$('#media-type').val('');
			var message = "Please fix the following errors and try again : ";
			if(limitExceeded != "") message += "\n\n" + limitExceeded;
			if(fileTooBig != "") message += "\n\nMaximum image size : 5MB" + fileTooBig;
			if(notAnImage != "") message += "\n" + notAnImage;
			alert(message);
		}
		else{
			$this.siblings('#upload-videos').val('');
			$this.siblings('#media-type').val('1');
			$('#selected-files').empty().append(selectedFiles);
			$('.cancelled-file-list').remove();
			activateRemoveOpt();
		}
	});


	// IF VIDEO IS SELECTED AS THE STATUS MEDIA, CHECK FOR VIDEO VALIDATIONS
	// VIDEO VALIDATION INCLUDES -> WHETHER THE FILE IS ACTUALLY AN VIDEO, THE SIZE OF THE FILE < 5MB, MAXIMUM NUMBER OF IMAGES = 5
	$('#upload-videos').on('change',function(){
		var $this = $(this);
		var limitExceeded = fileTooBig = notAVideo = selectedFiles = "";
		var total = $this[0].files.length;
	
		if(total > 2) limitExceeded = "You can not upload more than 2 videos in a single post";
		for(var i=0; i<total; i++){
			var fileName = $this[0].files[i].name.replace(/C:\\fakepath\\/i, '');
			var baseName = fileName.substr(0,fileName.lastIndexOf('.'));
			var extension = fileName.substr(fileName.lastIndexOf('.') + 1);
			if(baseName.length > 40) var displayName = baseName.substr(0,37) + ' ... .' + extension;
			else var displayName = fileName;
			selectedFiles += "<li data-name='" + fileName + "'>" + displayName + " &nbsp; <i class='fa fa-times'></i></li>";
			if(allowedVideoExtension(extension)){
				if($this[0].files[i].size > 40000000){
					fileTooBig += "\nThe size of the file " + fileName + " is too big";
				}
			}
			else{
				notAVideo += "\nThe extension of the file " + fileName + " is not supported.";
			}
		}
		if(limitExceeded != "" || fileTooBig != "" || notAVideo != ""){
			$this.val('');
			$('#media-type').val('');
			var message = "Please fix the following errors and try again : ";
			if(limitExceeded != "") message += "\n\n" + limitExceeded;
			if(fileTooBig != "") message += "\n\nMaximum video size : 40MB" + fileTooBig;
			if(notAVideo != "") message += "\n\nSupported video format : mp4, webm and ogg" + notAVideo;
			alert(message);
		}
		else{
			$this.siblings('#upload-images').val('');
			$this.siblings('#media-type').val('2');
			$('#selected-files').empty().append(selectedFiles);
			$('.cancelled-file-list').remove();
			activateRemoveOpt();
		}
	});




	// SHOW ALL COMMENTS OF A POST WHEN VIEW ALL COMMENTS LINK IS CLICKED
	$('.show-all-comments').on('click',function(e){
		e.preventDefault();
		$(this).hide().closest('.post-detail').find('.post-comment.hidden').removeClass('hidden');
	});
});




function allowedImageExtension(extension){
	var found = false;
	var allowedExtension = ['jpe','jpg','jpeg','gif','png','bmp','ico','svg','svgz','tif','tiff','ai','drw','pct','psp','xcf','psd','raw'];
	for(var i=0; i<allowedExtension.length;i++){
		if(extension.toLowerCase() == allowedExtension[i]) {
			found = true;
			break;
		}
	}
	return found;
}




function allowedVideoExtension(extension){
	var found = false;
	var allowedExtension = ['mp4','ogg','webm'];
	for(var i=0; i<allowedExtension.length;i++){
		if(extension.toLowerCase() == allowedExtension[i]) {
			found = true;
			break;
		}
	}
	return found;
}




function activateRemoveOpt(){
	$('#selected-files .fa-times').on('click',function(){
		var fileName = $(this).parent('li').data('name');
		$(this).parent('li').remove();
		$('#new-post').append("<input type='hidden' class='cancelled-file-list' name='cancelled-file-list[]' value='" + fileName + "'/>");
	});
}