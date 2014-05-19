function initialize() {
	var latitude = 38.371200,
		longitude = 21.42830,
		radius = 8000,
		center = new google.maps.LatLng(latitude,longitude),
		bounds = new google.maps.Circle({center: center, radius: radius}).getBounds(),
		mapCanvas = document.getElementById('map_canvas'),
		mapOptions = {
			 center: center,
			 zoom: 14,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			 //scrollwheel: false
		};
	var map = new google.maps.Map(mapCanvas, mapOptions);
	setMarkers(center, radius, map);
	google.maps.event.addListener(marker, 'click', toggleBounce);
}

function setMarkers	(center, radius, map) {
	var json = (function () { 
		var json = null; 
		 $.ajax({ 
			'async': false, 
			'global': false, 
			'url': "map_reports.json", 
			'dataType': "json", 
			'success': function (data) {json = data;}
		 });
		 return json;
     })();

	var circle = new google.maps.Circle({
		strokeColor: '#000000',
		strokeOpacity: 0.25,
		strokeWeight: 1.0,
		fillColor: '#ffffff',
		fillOpacity: 0.1,
		clickable: false,
		map: map,
		center: center,
		radius: radius
	});

	var bounds = circle.getBounds();

	//loop between each of the json elements
	for (var i = 0, length = json.length; i < length; i++) {
		var data = json[i],
			latLng = new google.maps.LatLng(data.lat, data.lng); 
		if(bounds.contains(latLng)) {
			// Creating a marker and putting it on the map
			var marker = new google.maps.Marker({
				position: latLng,
				map: map,
				title: data.content
			});
			infoBox(map, marker, data);
		}
	}
	circle.bindTo('center', marker, 'position');
}

function infoBox(map, marker, data) {
	var infoWindow = new google.maps.InfoWindow();
		// Attaching a click event to the current marker
		google.maps.event.addListener(marker, "click", function(e) {
				infoWindow.setContent(data.content);
				infoWindow.open(map, marker);
			});
	// Creating a closure to retain the correct data 
	// Note how I pass the current data in the loop into the closure (marker, data)
	(function(marker, data) {
		// Attaching a click event to the current marker
		google.maps.event.addListener(marker, "click", function(e) {
				infoWindow.setContent(data.content);
				infoWindow.open(map, marker);
			});
	})(marker, data);
}

function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}
    
google.maps.event.addDomListener(window, 'load', initialize);
