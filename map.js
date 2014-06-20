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
			var htmlList = "<ul>";
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
				var status = $(this).attr('status');
				var comment = $(this).attr('comment');
				
				htmlList = htmlList.concat("<li><p>Κατηγορία: "+category+'</p>');
				htmlList = htmlList.concat("<p>Ημερομηνία: "+date+"</p></li>");
				
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
				
				if (comment != ""){
					comment = 'Σχόλιο Διαχειριστή: <br>'+comment;
				}
				
				if(pin_icon != ""){
					create_report(point, category, description, date, photos, user, status, comment, pin_url);
				}
				else {
					create_report(point, category, description, date, photos, user, status, comment, "icons/pin_red.png");
				}
			});
			htmlList = htmlList.concat("</ul>");
			$('#list_of_reports').html(htmlList);
			var report_num = window.location.search.replace( "?", "" );
			google.maps.event.trigger(markers[report_num], "click");
			setTimeout(drop_reports, 60000);
		}
	});
					
}

//############### Create Report Function ##############
function create_report(MapPos, MapTitle, MapDesc, MapDate, MapPhotos, MapUser, MapStatus, MapComment, iconPath)
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
		Img = Img.concat('" onclick="image()"><img width=auto height="100" src="');
		Img = Img.concat(MapPhotos[j]);
		photos[j] = Img.concat('"></a>');
	}
	
	//Content structure of info Window for the Reports
	var contentString = $('<div class="report-info-win">'+
	'<table width="300"><tr><td><div class="report-heading">Κατηγορία: '+MapTitle+'</div></td></tr>'+
	'<tr><td>Ημερομηνία Καταχώρησης: '+MapDate+'</td></tr><tr><td>Κατάσταση: '+MapStatus+
	'<br>Περιγραφή: <br>'+MapDesc+'</td></tr></table>'+
	'<table><tr><td>'+photos[0]+'</td><td>'+photos[1]+'</td></tr><tr><td>'+photos[2]+'</td><td>'+photos[3]+'</td></tr></table>'+
	'<table width="300"><tr><td>'+MapUser+'</td></tr><tr><td>'+MapComment+'</td></tr></table>'+
	'</div>');
	
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
