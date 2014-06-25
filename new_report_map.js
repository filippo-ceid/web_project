var mapCenter = new google.maps.LatLng(38.371237, 21.431653); //Google map Coordinates
var map;
var browserSupportFlag =  new Boolean();

var markers = [];

google.maps.event.addDomListener(window, 'load', map_initialize);

//############### Google Map Initialize ##############
function map_initialize()
{
	var category = [];
	var googleMapOptions = 
	{ 
		center: mapCenter, // map center
		zoom: 15, //zoom level, 0 = earth view to higher value
		maxZoom: 20,
		minZoom: 10,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.SMALL //zoom control size
		},
		scaleControl: true, // enable scale control
		mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
	};
	map = new google.maps.Map(document.getElementById("new_report_map_canvas"), googleMapOptions);

	// Try W3C Geolocation (Preferred)
	if(navigator.geolocation) {
		browserSupportFlag = true;
		navigator.geolocation.getCurrentPosition(function(position) {
			var initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(initialLocation);
			GetCategories(function (category) {
				var EditOpt = '';
				var EditForm = '<form action="ajax-save.php" method="POST" name="SaveReport" id="SaveReport">'+
					'Κατηγορία: <select name="pCateg" class="save-categ"><option value="default"></option>';
				for (var j=0;j<category.length;j++){
					EditOpt = '<option value="';
					EditOpt = EditOpt.concat(category[j]);
					EditOpt = EditOpt.concat('">');
					EditOpt = EditOpt.concat(category[j]);
					EditOpt = EditOpt.concat('</option>');
					EditForm = EditForm.concat(EditOpt);
				}
				var EditEnd = '</select><br>Περιγραφή: <br>'+
					'<textarea name="pDesc" class="save-desc" placeholder="Εισάγετε Περιγραφή" maxlength="250" cols="46" rows="5"></textarea>'+
					'</form>';
				EditForm = EditForm.concat(EditEnd);
			
				SaveSubm = '<button name="save-report" class="save-report">Αποθήκευση Αναφοράς</button>'

				//Drop a new Report with our Edit Form
				create_report(initialLocation, 'Νέα Αναφορά', EditForm, SaveSubm, '', '', '', '', true, true, true, "icons/pin_red.png");
			});
		}, function() {
			handleNoGeolocation(browserSupportFlag);
		});
	}
	// Browser doesn't support Geolocation
	else {
		browserSupportFlag = false;
		handleNoGeolocation(browserSupportFlag);
	}
	  
	function handleNoGeolocation(errorFlag) {
		if (errorFlag == true) {
			alert("Geolocation service failed.");
			initialLocation = mapCenter;
		} else {
			alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
			initialLocation = mapCenter;
		}
		map.setCenter(initialLocation);
	}


	//Load Markers from the XML File, Check (map_process.php)
	$.get("map_process.php", function (data) {
		$(data).find("report").each(function () {
			var photos = [];
			var photostr = "photo_name_";
			var pin_icon = "";
			var album = "uploads/";
			var pin_url = "icons/";
			var category = 'Κατηγορία: '+$(this).attr('category');
			var description = 'Περιγραφή: <p>'+ $(this).attr('description') +'</p>';
			var date = 'Ημερομηνία Καταχώρησης: <br>'+$(this).attr('datetime');
			var point = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
			var num_of_photos = $(this).attr('num_of_photos');
			var pin_icon = $(this).attr('pin_icon');
			var status = 'Κατάσταση: '+$(this).attr('report_status');
			var comment = $(this).attr('report_comment');
			pin_url = pin_url.concat(pin_icon);
			pin_url = pin_url.concat(".png");
			for (var i=0; i<num_of_photos; i++){
				photo_name_str = photostr.concat(i);
				photo_name = album.concat($(this).attr(photo_name_str));
				photos.push(photo_name);
			}
			
			if (comment != ""){
				comment = 'Σχόλιο Διαχειριστή: <br>'+comment;
			}
			
			if(pin_icon == ""){
				pin_icon = "icons/pin_red.png";
			}
			
			create_report(point, category, description, '', date, photos, status, comment,  false, false, false, pin_url);
			
		});
	});	
	
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		var initialLocation = new google.maps.LatLng(38.368074,21.429212);
		map.setCenter(initialLocation);
		GetCategories(function (category) {
			var EditOpt = '';
			var EditForm = '<form action="ajax-save.php" method="POST" name="SaveReport" id="SaveReport">'+
				'Κατηγορία: <select name="pCateg" class="save-categ"><option value="default"></option>';
			for (var j=0;j<category.length;j++){
				EditOpt = '<option value="';
				EditOpt = EditOpt.concat(category[j]);
				EditOpt = EditOpt.concat('">');
				EditOpt = EditOpt.concat(category[j]);
				EditOpt = EditOpt.concat('</option>');
				EditForm = EditForm.concat(EditOpt);
			}
			var EditEnd = '</select><br>Περιγραφή: <br>'+
				'<textarea name="pDesc" class="save-desc" placeholder="Εισάγετε Περιγραφή" maxlength="250" cols="46" rows="5"></textarea>'+
				'</form>';
			EditForm = EditForm.concat(EditEnd);
		
			SaveSubm = '<button name="save-report" class="save-report">Αποθήκευση Αναφοράς</button>'

			//Drop a new Report with our Edit Form
			create_report(initialLocation, 'Νέα Αναφορά', EditForm, SaveSubm, '', '', '', '', true, true, true, "icons/pin_red.png");
		});
	}
	else{
		//Right Click to Drop a New Report
		google.maps.event.addListener(map, 'rightclick', function(event) {
			GetCategories(function (category) {
				//Edit form to be displayed with new categories
				var EditOpt = '';
				var EditForm = '<form action="ajax-save.php" method="POST" name="SaveReport" id="SaveReport">'+
				'Κατηγορία: <select name="pCateg" class="save-categ"><option value="default"></option>';
				for (var j=0;j<category.length;j++){
					EditOpt = '<option value="';
					EditOpt = EditOpt.concat(category[j]);
					EditOpt = EditOpt.concat('">');
					EditOpt = EditOpt.concat(category[j]);
					EditOpt = EditOpt.concat('</option>');
					EditForm = EditForm.concat(EditOpt);
				}
				var EditEnd = '</select><br>Περιγραφή: <br>'+
				'<textarea name="pDesc" class="save-desc" placeholder="Εισάγετε Περιγραφή" maxlength="250" cols="46" rows="5"></textarea>'+
				'</form>';
				EditForm = EditForm.concat(EditEnd);
				
				SaveSubm = '<button name="save-report" class="save-report">Αποθήκευση Αναφοράς</button>'

				//Drop a new Report with our Edit Form
				create_report(event.latLng, 'Νέα Αναφορά', EditForm, SaveSubm, '', '', '', '', true, true, true, "icons/pin_red.png");
			});
		});
	}						
}


function GetCategories(callback) {
	var category = [];
	var i=0;
	$.get("categories.php", function (data) {
		$(data).find("category").each(function () {
			category[i] = $(this).attr('category');
			i = i+1;
		});
		callback(category);
	});
}

	
//############### Create Report Function ##############
function create_report(MapPos, MapTitle, MapDesc, MapSaveSubm, MapDate, MapPhotos, MapStatus, MapComment, InfoOpenDefault, DragAble, Removable, iconPath)
{	  	  		  	
	//marker
	var marker = new google.maps.Marker({
		position: MapPos,
		map: map,
		draggable:DragAble,
		animation: google.maps.Animation.DROP,
		icon: iconPath
	});
	
	if (MapSaveSubm == ''){
		markers.push(marker);
	}
	var photos = ['', '', '', '']; 
	
	for (var j=0;j<MapPhotos.length;j++){
		Img = '<a class="photo" href="';
		Img = Img.concat(MapPhotos[j]);
		Img = Img.concat('" title="');
		Img = Img.concat(MapDate);
		Img = Img.concat('" onclick="image()"><img width=auto height="100" src="');
		Img = Img.concat(MapPhotos[j]);
		photos[j] = Img.concat('"></a>');
	}
	
	
	//Content structure of info Window for the Reports
	var contentString = $('<div class="report-info-win">'+
	'<table width="300"><tr><td><div class="report-heading">'+MapTitle+'</div></td></tr><tr><td>'+MapDate+'</td></tr>'+
	'<tr><td>'+MapStatus+'</td></tr><tr><td>'+MapDesc+'</td></tr><tr><td>'+MapComment+'</td></tr></table>'+
	'<table><tr><td>'+photos[0]+'</td><td>'+photos[1]+'</td></tr><tr><td>'+photos[2]+'</td><td>'+photos[3]+'</td></tr></table>'+
	'<table align="center"><tr><td>'+MapSaveSubm+'<button name="remove-report" class="remove-report" title="Remove Report">Διαγραφή Αναφοράς</button></td></tr></table></table>'+
	'</div>');
	
	
	//Create an infoWindow
	var infowindow = new google.maps.InfoWindow();
	//set the content of infoWindow
	infowindow.setContent(contentString[0]);

	//Find remove button in infoWindow
	var removeBtn 	= contentString.find('button.remove-report')[0];
	var saveBtn 	= contentString.find('button.save-report')[0];

	//add click listner to remove report button
	google.maps.event.addDomListener(removeBtn, "click", function(event) {
		remove_report(marker);
	});
		
	if(typeof saveBtn !== 'undefined') //continue only when save button is present
	{
		//add click listner to save report button
		google.maps.event.addDomListener(saveBtn, "click", function(event) {
			var mReplace = contentString.find('span.info-content'); //html to be replaced after success
			var mCateg = contentString.find('select.save-categ')[0].value; //category of report
			var mDesc  = contentString.find('textarea.save-desc')[0].value; //description input field value		
			if(mCateg =='default' && mDesc =='')
			{
				alert("Παρακαλώ εισάγετε κατηγορία και περιγραφή!");
			}
			else if(mCateg =='default'){
				alert("Παρακαλώ εισάγετε κατηγορία!");
			}
			else if(mDesc ==''){
				alert("Παρακαλώ εισάγετε περιγραφή!");	
			}else{
				save_report(marker, mCateg, mDesc, mReplace); //call save report function
				//infowindow.close(map,marker);
			}
		});
	}
		
	//add click listner to report marker		 
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker); // click on marker opens info window 
	});
		  
	if(InfoOpenDefault) //whether info window should be open by default
	{
		infowindow.open(map,marker);
	}
}
	
//############### Remove Report Function ##############
function remove_report(Marker)
{		
	/* determine whether marker is draggable 
	new markers are draggable and saved markers are fixed */
	if(Marker.getDraggable()) 
	{
		Marker.setMap(null); //just remove new marker
	}
	else
	{
		//Remove saved report from DB and map using jQuery Ajax
		var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
		var myData = {del : 'true', latlang : mLatLang}; //post variables
		$.ajax({
			type: "POST",
			url: "map_process.php",
			data: myData,
			success:function(data){
				Marker.setMap(null); 
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError); //throw any errors
			}
		});
	}
}
	
//############### Save Report Function ##############
function save_report(Marker, mCateg, mDesc, replaceWin)
{
	//Save new report using jQuery Ajax
	var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
	var myData = {save : 'true', category : mCateg, description : mDesc, latlang : mLatLang}; //post variables
	console.log(replaceWin);		
	$.ajax({
		type: "POST",
		url: "map_process.php",
		data: myData,
		success:function(data){
		},
        error:function (xhr, ajaxOptions, thrownError){
			alert(thrownError); //throw any errors
		}
	});
	$(document).ajaxStop(function(){
		window.location.assign("uploadphotos.php");
	});
}

function myclick(i) {
  google.maps.event.trigger(markers[i], "click");
}
