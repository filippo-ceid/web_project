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
	map = new google.maps.Map(document.getElementById("reports_map_canvas"), googleMapOptions);

	//Load Markers from the XML File, Check (map_process.php)
	$.get("map_process_admin.php", function (data) {
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
			var users_email = 'Απο το χρήστη: '+$(this).attr('user_email');
			pin_url = pin_url.concat(pin_icon);
			pin_url = pin_url.concat(".png");
			for (var i=0; i<num_of_photos; i++){
				photo_name_str = photostr.concat(i);
				photo_name = album.concat($(this).attr(photo_name_str));
				photos.push(photo_name);
			}
			
			
			
			if(pin_icon != ""){
				create_report(point, category, description, date, photos, users_email, false, false, false, pin_url);
			}
			else {
				create_report(point, category, description, date, photos, users_email, false, false, false, "icons/pin_red.png");
			}
		});
	});	
										
}

	
//############### Create Report Function ##############
function create_report(MapPos, MapTitle, MapDesc, MapDate, MapPhotos, MapUser, InfoOpenDefault, DragAble, Removable, iconPath)
{	  	  		  	
	//marker
	var marker = new google.maps.Marker({
		position: MapPos,
		map: map,
		draggable:DragAble,
		animation: google.maps.Animation.DROP,
		icon: iconPath
	});
	
	markers.push(marker);
	
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
		'<table width="300"><tr><td>Κατηγορία: '+MapTitle+'</div></td></tr><tr><td>Ημερομηνία Καταχώρησης: <br>'+MapDate+
		'<br>Περιγραφή: <br>'+MapDesc+'</table>'+
		'<table></td></tr><tr><td>'+photos[0]+'</td><td>'+photos[1]+'</td></tr><tr><td>'+photos[2]+'</td><td>'+photos[3]+'</td></tr></table>'+
		'<table></td></tr><tr><td>'+MapUser+'</td></tr>'+
		'<tr><td><form action="ajax-save.php" method="POST" name="SaveStatus" id="SaveStatus">'+
		'Κατάσταση: <select name="mStatus" class="save-status"><option value="default"></option>'+
		'<option value="Κλειστή">Κλειστή</option><option value="Ανοιχτή">Ανοιχτή</option></select></td></tr>'+
		'<tr><td>Σχόλιο: <br><textarea name="pComm" class="save-comm" placeholder="Εισάγετε Σχόλιο" maxlength="250" cols="48" rows="5"></textarea>'+
		'</form></td></tr>'+
		'<tr><td><button name="save-status" class="save-status">Αποθήκευση Κατάστασης</button><button name="remove-report" class="remove-report" title="Remove Report">Διαγραφή Αναφοράς</button></td></tr></table>'+
		'</div>');
		
		
	
	//Create an infoWindow
	var infowindow = new google.maps.InfoWindow();
	//set the content of infoWindow
	infowindow.setContent(contentString[0]);

	//Find remove button in infoWindow
	var removeBtn 	= contentString.find('button.remove-report')[0];
	var saveBtn 	= contentString.find('button.save-status')[0];

	//add click listner to remove report button
	google.maps.event.addDomListener(removeBtn, "click", function(event) {
		remove_report(marker);
	});
		
	if(typeof saveBtn !== 'undefined') //continue only when save button is present
	{
		//add click listner to save report button
		google.maps.event.addDomListener(saveBtn, "click", function(event) {
			var mStatus = contentString.find('select.save-status')[0].value; //category of report
			var mComm  = contentString.find('textarea.save-comm')[0].value; //description input field value		
			if(mStatus =='default')
			{
				alert("Παρακαλώ επιλέξτε κατάσταση!");
			}
			else{
				save_status(marker, mStatus, mComm);
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
			url: "map_process_admin.php",
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
function save_status(Marker, mStatus, mComm)
{
	var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
	var myData = {save : 'true', status : mStatus, comment : mComm, latlang : mLatLang}; //post variables	
	$.ajax({
		type: "POST",
		url: "map_process_admin.php",
		data: myData,
		success:function(data){
		},
        error:function (xhr, ajaxOptions, thrownError){
			alert(thrownError); //throw any errors
		}
	});
	$(document).ajaxStop(function(){
		window.location.assign("reports_page.php");
	});
}

function myclick(page_num, i) {
  var report_num = (page_num-1)*20 + i;
  google.maps.event.trigger(markers[report_num], "click");
}
