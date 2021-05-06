<?php

function googleMapAPIScript() {
	
	wp_register_script('blackbay_js_googlemaps_script', 'https://maps.googleapis.com/maps/api/js?&key=AIzaSyDaoJHIfiCoCLbOPVV_aK-uFXmta91ZBiU', array('jquery'), null);
	wp_enqueue_script('blackbay_js_googlemaps_script');
	
	wp_register_script('marker-cluster-script', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', array('jquery'), null, true);
	wp_enqueue_script('marker-cluster-script');
	
}
add_action('wp_enqueue_scripts', 'googleMapAPIScript');