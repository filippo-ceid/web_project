var mes_marker = new google.maps.LatLng(38.371237, 21.431653);
var marker;

function initialize() {
	var latitude = 38.371200,
		longitude = 21.42830,
		radius = 8000,
		center = new google.maps.LatLng(latitude,longitude),
		bounds = new google.maps.Circle({center: center, radius: radius}).getBounds(),
		mapCanvas = document.getElementById('new_marker_map_canvas'),
		mapOptions = {
			 center: center,
			 zoom: 14,
			 mapTypeId: google.maps.MapTypeId.ROADMAP
			 //scrollwheel: false
		};
	var map = new google.maps.Map(mapCanvas, mapOptions);
	marker = new google.maps.Marker({
		map:map,
		draggable:true,
		animation: google.maps.Animation.DROP,
		position: mes_marker
  });
  google.maps.event.addListener(marker, 'click', toggleBounce);
}

function toggleBounce() {

  if (marker.getAnimation() != null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

google.maps.event.addDomListener(window, 'load', initialize);
