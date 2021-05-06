<style type="text/css">
.info_content a {
	display: inline-block;
	margin: 0;
	background: #000;
	color: #fff;
	padding: 10px 15px;
	margin-right: 15px;
	text-decoration: none;
}

.info_content h3 {
	margin-bottom: 0;
}

.info_content p {
	margin-top: 5px;
}
.info-content-copy {
	padding: 15px;
}

.featured-img-container {
	width: 100%;
	height: 180px;
	overflow: hidden;
}
.featured-img-container img {
	width: 100%;
	height: auto;
	max-width: 100%;
}

.info_content > a {
	padding: 0;
	margin: 0;
}

#phoneNumber {
	text-align: center;
	color: #fff;
	font-size: 20px;
}

.gm-style-pbc {
	background-color: rgba(255, 255, 255, 0.75)!important;
}
.gm-style .gm-style-iw-c {
	max-width: 300px!important;
	padding: 0;
}
.gm-style-iw-d {
	padding: 0!important;
	overflow: hidden!important;
}

.gm-ui-hover-effect, .gm-ui-hover-effect img {
	width: 30px!important;
	height: 30px!important;
	top: 0!important;
	right: 0!important;
}

.gm-ui-hover-effect img {
	padding: 5px!important;
	margin: 0!important;
}
.acf-map-container {
	height: 500px;
}
.acf-map {
    width: 100%;
    height: 100%;
    border: none;
}

/* Fixes potential theme css conflict. */
.acf-map img {
   max-width: inherit !important;
}
</style>

<script>
(function($) {

	function new_map( $el ) {

	// var
	var $markers = $el.find('.marker');


	// vars
	var args = {
		zoom		: 10,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};


	// create map
	var map = new google.maps.Map( $el[0], args);
	
	markerCluster( map.markers, map );


	// add a markers reference
	map.markers = [];


	// add markers
	$markers.each(function(){

    	add_marker( $(this), map );

	});


	// center map
	center_map( map );


	// return
	return map;

}
	
	var activeInfoWindow;
	function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// Create marker instance.
	var marker = new google.maps.Marker({
	    position : latLng,
	    map: map,
		icon: {
			url: window.location.protocol + '//' + window.location.host + '/wp-content/themes/blackbay/includes/img/black-pin.png'
		}
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// Create info window.
	        var infowindow = new google.maps.InfoWindow({
	            content: $marker.html()
	        });
	
	        // Show info window when marker is clicked.
		    google.maps.event.addListener(marker, 'click', function() {
		        map.panTo(this.getPosition());
				//map.panBy(0,-100);
				if (activeInfoWindow) { 
					activeInfoWindow.close();
				}
		        infowindow.open(map, marker);
		        activeInfoWindow = infowindow;
			});
	}

}
	
	
	function markerCluster( markers, map ) {
	    var markerCluster = new MarkerClusterer(map, markers, {
			imagePath: window.location.protocol + '//' + window.location.host + '/wp-content/themes/blackbay/includes/img/cluster-icon'
		});
	}
	
	function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		  map.setCenter( bounds.getCenter() );
	   	map.setZoom( 2 ); // Change the zoom value as required
		//map.fitBounds( bounds ); // This is the default setting which I have uncommented to stop the World Map being repeated

	}

}
	
	var map = null;

jQuery(document).ready(function($){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});


});

})(jQuery);
</script>

<?php 
$args = array( 
	'numberposts' => -1,
	'post_type' => 'residential',
	'meta_query'=> array(
		array(
            'key' => 'exclude_from_list',
            'value' => '1',
            'compare' => '!='
        )
	)
);

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : ?>
<div class="acf-map-container">
	<div class="acf-map" data-zoom="4">
		<?php while ( $loop->have_posts() ) : $loop->the_post();
		
		// Load sub field values.
	    $location = get_field('location_map', $post->ID);
	    $permalink = get_the_permalink($post->ID);
	    $featuredimg = get_the_post_thumbnail_url( $post->ID, 'listing-thumb'); ?>
		
		<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
			<div class="info_content">
				<?php if ( $featuredimg ) {
				echo '
				<a href="' . $permalink . '">
					<div class="featured-img-container">
						<img src="' . $featuredimg . '">
					</div>
				</a>';
				} ?>
				
				<div class="info-content-copy">
				
					<h3 style="margin-top: 0; font-size: 16px;"><?php the_title(); ?></h3>
					<a href="<?php echo $permalink ?>">View Details</a>
		        	
		        	<?php
					if( have_rows('cta_buttons', $post->ID) ):
					while( have_rows('cta_buttons', $post->ID) ): the_row();
					
					$weblink = get_sub_field('website_link', $post->ID);
					$phone = get_sub_field('phone_number', $post->ID);
					
					$currentlang = get_bloginfo('language');
					if ( $currentlang == 'en-CA' ) {
						if ( $weblink ) {
							echo '<a class="gm-website" href="' . $weblink . '" target="_blank">VISIT WEBSITE</a>';
						} 
						if ( $phone ) {
							echo '<a class="gm-phone" href="tel:+1' . $phone . '">CALL</a>';
						}
					} elseif ( $currentlang == 'fr-FR' ) {
						if ( $weblink ) {
							echo '<a class="gm-website" href="' . $weblink . '" target="_blank">Visitez le site web</a>';
						} 
						if ( $phone ) {
							echo '<a class="gm-phone" href="tel:+1' . $phone . '">Appel</a>';
						}
					}
					
					endwhile;
					endif; ?>
				
				</div>
				
		    </div>
	    </div>
		
		<?php endwhile; ?>
	</div>
</div>
<?php endif; wp_reset_postdata(); ?>