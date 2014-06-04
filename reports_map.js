var mapCenter = new google.maps.LatLng(38.371237, 21.431653); //Google map Coordinates
var map;
var browserSupportFlag =  new Boolean();
	
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
	map = new google.maps.Map(document.getElementById("reports_map_canvas"), googleMapOptions);

	// Try W3C Geolocation (Preferred)
	if(navigator.geolocation) {
		browserSupportFlag = true;
		navigator.geolocation.getCurrentPosition(function(position) {
			initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(initialLocation);
			GetCategories(function (category) {
				var EditOpt = '';
				var EditForm = '<p><div class="report-edit">'+
				'<form action="ajax-save.php" method="POST" name="SaveReport" id="SaveReport">'+
				'<label for="pCateg"><span>Κατηγορία: </span><select name="pCateg" class="save-categ"><option value="default">-Επέλεξε-</option>';
				for (var j=0;j<category.length;j++){
					EditOpt = '<option value="';
					EditOpt = EditOpt.concat(category[j]);
					EditOpt = EditOpt.concat('">');
					EditOpt = EditOpt.concat(category[j]);
					EditOpt = EditOpt.concat('</option>');
					EditForm = EditForm.concat(EditOpt);
				}
				var EditEnd = '</select></label>'+
				'<br><label for="pDesc"><span>Περιγραφή: </span><textarea name="pDesc" class="save-desc" placeholder="Εισάγετε Περιγραφή" maxlength="250" cols="40" rows="5"></textarea></label>'+
				'</form>'+
				'</div></p><button name="save-report" class="save-report">Αποθήκευση Αναφοράς</button>';
				EditForm = EditForm.concat(EditEnd);

				//Drop a new Report with our Edit Form
				create_report(initialLocation, 'Νέα Αναφορά', EditForm, '', '', true, true, true, "icons/pin_red.png");
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
			var category = $(this).attr('category');
			var description = '<p>'+ $(this).attr('description') +'</p>';
			var date = $(this).attr('datetime');
			var point = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
			var num_of_photos = $(this).attr('num_of_photos');
			var pin_icon = $(this).attr('pin_icon');
			pin_url = pin_url.concat(pin_icon);
			pin_url = pin_url.concat(".png");
			for (var i=0; i<num_of_photos; i++){
				photo_name_str = photostr.concat(i);
				photo_name = album.concat($(this).attr(photo_name_str));
				photos.push(photo_name);
			}
			if(pin_icon != ""){
				create_report(point, category, description, date, photos, false, false, false, pin_url);
			}
			else {
				create_report(point, category, description, date, photos, false, false, false, "icons/pin_red.png");
			}
		});
	});	
	//Right Click to Drop a New Report
	google.maps.event.addListener(map, 'rightclick', function(event) {
		GetCategories(function (category) {
			//Edit form to be displayed with new categories
			var EditOpt = '';
			var EditForm = '<p><div class="report-edit">'+
			'<form action="ajax-save.php" method="POST" name="SaveReport" id="SaveReport">'+
			'<label for="pCateg"><span>Κατηγορία: </span><select name="pCateg" class="save-categ"><option value="default">-Επέλεξε-</option>';
			for (var j=0;j<category.length;j++){
				EditOpt = '<option value="';
				EditOpt = EditOpt.concat(category[j]);
				EditOpt = EditOpt.concat('">');
				EditOpt = EditOpt.concat(category[j]);
				EditOpt = EditOpt.concat('</option>');
				EditForm = EditForm.concat(EditOpt);
			}
			var EditEnd = '</select></label>'+
			'<br><label for="pDesc"><span>Περιγραφή: </span><textarea name="pDesc" class="save-desc" placeholder="Εισάγετε Περιγραφή" maxlength="250" cols="40" rows="5"></textarea></label>'+
			'</form>'+
			'</div></p><button name="save-report" class="save-report">Αποθήκευση Αναφοράς</button>';
			EditForm = EditForm.concat(EditEnd);

			//Drop a new Report with our Edit Form
			create_report(event.latLng, 'Νέα Αναφορά', EditForm, '', '', true, true, true, "icons/pin_red.png");
		});
	});
										
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
function create_report(MapPos, MapTitle, MapDesc, MapDate, MapPhotos, InfoOpenDefault, DragAble, Removable, iconPath)
{	  	  		  	
	//marker
	var marker = new google.maps.Marker({
		position: MapPos,
		map: map,
		draggable:DragAble,
		animation: google.maps.Animation.DROP,
		icon: iconPath
	});
	
	var photos = ['', '', '', '']; 
	
	for (var j=0;j<MapPhotos.length;j++){
		Img = '<img src="';
		Img = Img.concat(MapPhotos[j]);
		photos[j] = Img.concat('">');
	}
	
	//Content structure of info Window for the Reports
	var contentString = $('<div class="report-info-win">'+
	'<div class="report-inner-win"><span class="info-content">'+
	'<div class="report-heading">'+MapTitle+'</div>'+MapDate+
	MapDesc+
	'</span>'+photos[0]+photos[1]+photos[2]+photos[3]+'<button name="remove-report" class="remove-report" title="Remove Report">Διαγραφή Αναφοράς</button>'+
	'</div></div>');
	
	
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
				save_report(marker, mCateg, mDesc); //call save report function
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
function save_report(Marker, mCateg, mDesc)
{
	//Save new report using jQuery Ajax
	var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
	var myData = {save : 'true', category : mCateg, description : mDesc, latlang : mLatLang}; //post variables	
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
