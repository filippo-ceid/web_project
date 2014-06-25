// Put event listeners into place
window.addEventListener("DOMContentLoaded", function() {
	// Grab elements, create settings, etc.
	var canvas = document.getElementById("canvas"),
	context = canvas.getContext("2d"),
	video = document.getElementById("video"),
	videoObj = { "video": true },
	errBack = function(error) {
		console.log("Video capture error: ", error.code); 
	};

	// Put video listeners into place
	if(navigator.getUserMedia) { // Standard
		navigator.getUserMedia(videoObj, function(stream) {
			video.src = stream;
			video.play();
		}, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
		navigator.webkitGetUserMedia(videoObj, function(stream){
			video.src = window.webkitURL.createObjectURL(stream);
			video.play();
		}, errBack);
	} else if(navigator.mozGetUserMedia) { // WebKit-prefixed
		navigator.mozGetUserMedia(videoObj, function(stream){
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}, errBack);
	}

	// Trigger photo take
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0,  300, 300 * video.height / video.width);
	});
}, false);

function PreviewImage(i) {
	var oFReader = new FileReader();
	imgId = 'uploadImage';
	imgId = imgId.concat(i);
	prevId = 'uploadPreview';
	prevId = prevId.concat(i);
	oFReader.readAsDataURL(document.getElementById(imgId).files[0]);
	oFReader.onload = function (oFREvent) {document.getElementById(prevId).src = oFREvent.target.result;};
};
