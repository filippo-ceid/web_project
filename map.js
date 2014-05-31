var mapCenter = new google.maps.LatLng(38.371237, 21.431653); //Google map Coordinates
var map;
	
google.maps.event.addDomListener(window, 'load', map_initialize);

//############### Google Map Initialize ##############
function map_initialize()
{
	var googleMapOptions = 
	{ 
		center: mapCenter, // map center
		zoom: 15, //zoom level, 0 = earth view to higher value
		maxZoom: 20,
		minZoom: 13,
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.SMALL //zoom control size
		},
		scaleControl: true, // enable scale control
		mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
	};
		
 	map = new google.maps.Map(document.getElementById("map_canvas"), googleMapOptions);			
			
	//Load Markers from the XML File, Check (map_process.php)
	$.get("map_db.php", function (data) {
		$(data).find("report").each(function () {
			var category = $(this).attr('category');
			var description = '<p>'+ $(this).attr('description') +'</p>';
			var date = $(this).attr('datetime');
			var user = $(this).attr('user');
			var firstname = $(this).attr('firstname');
			var lastname = $(this).attr('lastname');
			var point = new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
			if (firstname != "" && firstname != ""){
				var user = 'Απο το χρήστη: '+$(this).attr('firstname')+' '+$(this).attr('lastname');
			}
			else {
				var user = "";
			}
			if(category == 'Οδικά'){
				create_report(point, category, description, date, user, "icons/pin_grey.png");
			}
			else if(category == 'Ηλεκτρικά'){
				create_report(point, category, description, date, user, "icons/pin_yellow.png");
			}
			else if(category == 'Υδραυλικά'){
				create_report(point, category, description, date, user, "icons/pin_blue.png");
			}
			else if(category == 'Περιβαλλοντικά'){
				create_report(point, category, description, date, user, "icons/pin_green.png");
			}
			else {
				create_report(point, category, description, date, user, "icons/pin_red.png"); // na ftiaksoume sta ellinika to category
			}
		});
	});							
}
	
//############### Create Report Function ##############
function create_report(MapPos, MapTitle, MapDesc, MapDate, MapUser, iconPath)
{	  	  		  	
	//marker
	var marker = new google.maps.Marker({
		position: MapPos,
		map: map,
		icon: iconPath
	});
		
	//Content structure of info Window for the Reports
	var contentString = $('<div class="report-info-win">'+
	'<div class="report-inner-win"><span class="info-content">'+
	'<div class="report-heading">'+MapTitle+'</div>'+MapDate+
	MapDesc+MapUser+
	'</div></div>');	
	
	//Create an infoWindow
	var infowindow = new google.maps.InfoWindow();
	//set the content of infoWindow
	infowindow.setContent(contentString[0]);
		
	//add click listner to report marker		 
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker); // click on marker opens info window 
	});
}

