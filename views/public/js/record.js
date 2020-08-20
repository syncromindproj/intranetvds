//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

var recordButton = $("#recordButton");

function startRecording(id) {
    $("#txt_idmultimedia").val(id);
	console.log("recordButton clicked");

	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/
    
    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia() 
	*/

    $("#recordButton_" + id).attr("disabled", "disabled");
    $("#stopButton_" + id).removeAttr("disabled");
    $("#pauseButton_" + id).removeAttr("disabled");
	
	/*
    	We're using the standard promise based getUserMedia() 
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device
		*/
		audioContext = new AudioContext();

		//update the format 
		//document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		/*  assign to gumStream for later use  */
		gumStream = stream;
		
		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/* 
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})

		//start the recording process
		rec.record()

		console.log("Recording started");

	}).catch(function(err) {
	  	//enable the record button if getUserMedia() fails
    	//recordButton.disabled = false;
    	//stopButton.disabled = true;
    	//pauseButton.disabled = true
	});
}

function pauseRecording(id){
	console.log("pauseButton clicked rec.recording=",rec.recording );
	if (rec.recording){
		//pause
		rec.stop();
        //pauseButton.innerHTML="Resume";
        $("#pauseButton_" + id).html("<i class='fa fa-pause'></i> Resumir");
	}else{
		//resume
		rec.record()
        //pauseButton.innerHTML="Pause";
        $("#pauseButton_" + id).html("<i class='fa fa-pause'></i> Pausa");

	}
}

function stopRecording(id) {
	console.log("stopButton clicked");

	//disable the stop button, enable the record too allow for new recordings
	$("#stopButton_" + id).attr("disabled", "disabled");
    $("#recordButton_" + id).removeAttr("disabled");
    $("#pausedButton_" + id).attr("disabled", "disabled");

	//reset button just in case the recording is stopped while paused
    $("#pauseButton_" + id).html("<i class='fa fa-pause'></i> Pausa");
	
	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);
}

