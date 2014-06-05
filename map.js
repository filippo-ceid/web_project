var mapCenter = new google.maps.LatLng(38.371237, 21.431653); //Google map Coordinates
var map;
var markers = [];

$(function() {
    drop_reports();
});

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
		
		drop_reports();
}


function drop_reports()
{
		removeMarkers();
		//Load Markers from the XML File, Check (map_process.php)
		$.ajax({
			url: "map_db.php",
			data: "",
			success:function(data){
			$(data).find("report").each(function () {
				var photos = [];
				var photostr = "photo_name_";
				var pin_icon = "";
				var album = "uploads/";
				var pin_url = "icons/";
				var category = $(this).attr('category');
				var description = '<p>'+ $(this).attr('description') +'</p>';
				var date = $(this).attr('datetime');
				var user = $(this).attr('user');
				var firstname = $(this).attr('firstname');
				var lastname = $(this).attr('lastname');
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
				
				if (firstname != "" && firstname != ""){
					var user = 'Απο το χρήστη: '+$(this).attr('firstname')+' '+$(this).attr('lastname');
				}
				else {
					var user = "";
				}
				
				if(pin_icon != ""){
					create_report(point, category, description, date, photos, user, pin_url);
				}
				else {
					create_report(point, category, description, date, photos, user, "icons/pin_red.png");
				}
			});
			setTimeout(drop_reports, 60000);
		}
	});
					
}

//############### Create Report Function ##############
function create_report(MapPos, MapTitle, MapDesc, MapDate, MapPhotos, MapUser, iconPath)
{	
	//marker
	var marker = new google.maps.Marker({
		position: MapPos,
		map: map,
		icon: iconPath
	});
	markers.push(marker);
	
	var photos = ['', '', '', '']; 
	
	for (var j=0;j<MapPhotos.length;j++){
		Img = '<a class="photo" href="';
		Img = Img.concat(MapPhotos[j]);
		Img = Img.concat('" title="');
		Img = Img.concat(MapDate);
		Img = Img.concat('" onclick="image()"><img width=auto height="150" src="');
		Img = Img.concat(MapPhotos[j]);
		photos[j] = Img.concat('"></a>');
	}
	
	//Content structure of info Window for the Reports
	var contentString = $('<div class="report-info-win">'+
	'<div class="report-inner-win"><span class="info-content">'+
	'<div class="report-heading">'+MapTitle+'</div>'+MapDate+
	MapDesc+MapUser+
	'</span><br>'+photos[0]+photos[1]+photos[2]+photos[3]+'</div></div>');
	
	//Create an infoWindow
	var infowindow = new google.maps.InfoWindow();
	//set the content of infoWindow
	infowindow.setContent(contentString[0]);
		
	//add click listner to report marker		 
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker); // click on marker opens info window 
	});
}

function removeMarkers()
{
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(null);
	}
    markers.length=0;
}
