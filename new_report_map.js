var mapCenter = new google.maps.LatLng(38.371237, 21.431653); //Google map Coordinates
var map;
var browserSupportFlag =  new Boolean();
	
google.maps.event.addDomListener(window, 'load', map_initialize);

//############### Google Map Initialize ##############
function map_initialize()
{
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
			initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(initialLocation);
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
			var category = $(this).attr('category');
			var description = '<p>'+ $(this).attr('description') +'</p>';
			var date = $(this).attr('datetime');
			var point = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
			if(category == 'Οδικά'){
				create_report(point, category, description, date, false, false, false, "icons/pin_grey.png");
			}
			else if(category == 'Ηλεκτρικά'){
				create_report(point, category, description, date, false, false, false, "icons/pin_yellow.png");
			}
			else if(category == 'Υδραυλικά'){
				create_report(point, category, description, date, false, false, false, "icons/pin_blue.png");
			}
			else if(category == 'Περιβαλλοντικά'){
				create_report(point, category, description, date, false, false, false, "icons/pin_green.png");
			}
			else {
				create_report(point, category, description, date, false, false, false, "icons/pin_red.png"); // na ftiaksoume sta ellinika to category
			}
		});
	});	
			
	//Right Click to Drop a New Report
	google.maps.event.addListener(map, 'rightclick', function(event) {
		//Edit form to be displayed with new report
		var EditForm = '<p><div class="report-edit">'+
		'<form action="ajax-save.php" method="POST" name="SaveReport" id="SaveReport">'+
		'<label for="pCateg"><span>Κατηγορία: </span><select name="pCateg" class="save-categ"><option value="default">-Επέλεξε-</option>'+
		'<option value="Οδικά">Οδικά</option><option value="Ηλεκτρικά">Ηλεκτρικά</option><option value="Υδραυλικά">Υδραυλικά</option><option value="Περιβαλλοντικά">Περιβαλλοντικά</option></select></label>'+
		'<br><label for="pDesc"><span>Περιγραφή: </span><textarea name="pDesc" class="save-desc" placeholder="Εισάγετε Περιγραφή" maxlength="250" cols="40" rows="5"></textarea></label>'+
		'</form>'+
		'</div></p><button name="save-report" class="save-report">Αποθήκευση Αναφοράς</button>';

		//Drop a new Report with our Edit Form
		create_report(event.latLng, 'Νέα Αναφορά', EditForm, '', true, true, true, "icons/pin_red.png");
	});
										
}


	
//############### Create Report Function ##############
function create_report(MapPos, MapTitle, MapDesc, MapDate, InfoOpenDefault, DragAble, Removable, iconPath)
{	  	  		  	
	//marker
	var marker = new google.maps.Marker({
		position: MapPos,
		map: map,
		draggable:DragAble,
		animation: google.maps.Animation.DROP,
		icon: iconPath
	});
		
	//Content structure of info Window for the Reports
	var contentString = $('<div class="report-info-win">'+
	'<div class="report-inner-win"><span class="info-content">'+
	'<div class="report-heading">'+MapTitle+'</div>'+MapDate+
	MapDesc+ 
	'</span><button name="remove-report" class="remove-report" title="Remove Report">Διαγραφή Αναφοράς</button>'+
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
