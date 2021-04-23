<style type="text/css">
.info_content {
	
}

.info_content a {
	display: inline-block;
	margin: 15px 0 0;
	background: #3F5BA9;
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
	width: 40px!important;
	height: 40px!important;
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
(function( $ ) {

/**
 * initMap
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */
function initMap( $el ) {

    // Find marker elements within map.
    var $markers = $el.find('.marker');

    // Create gerenic map.
    var mapArgs = {
        zoom        : $el.data('zoom') || 4,
        mapTypeId   : google.maps.MapTypeId.ROADMAP,
    };
    var map = new google.maps.Map( $el[0], mapArgs );

    // Add markers.
    map.markers = [];
    $markers.each(function(){
        initMarker( $(this), map );
    });

    // Center map based on markers.
    centerMap( map );
	
	// add marker cluster
	markerCluster( map.markers, map )

    // Return map instance.
    return map;
}

/**
 * initMarker
 *
 * Creates a marker for the given jQuery element and map.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @param   object The map instance.
 * @return  object The marker instance.
 */
var activeInfoWindow;
function initMarker( $marker, map ) {

    // Get position from marker.
    var lat = $marker.data('lat');
    var lng = $marker.data('lng');
    var latLng = {
        lat: parseFloat( lat ),
        lng: parseFloat( lng )
    };

    // Create marker instance.
    var marker = new google.maps.Marker({
        position : latLng,
        map: map,
		icon: {
	      url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
	    }
    });

    // Append to reference for later use.
    map.markers.push( marker );

    // If marker contains HTML, add it to an infoWindow.
    if( $marker.html() ){

        // Create info window.
        var infowindow = new google.maps.InfoWindow({
            content: $marker.html()
        });

	    // Show info window when marker is clicked.
	    google.maps.event.addListener(marker, 'click', function() {
	        map.setCenter(marker.getPosition());
			map.panBy(0,-100);
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
		imagePath: window.location.protocol + '//' + window.location.host + '/wp-content/themes/blackbay/includes/img/m'
	});
}

/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   object The map instance.
 * @return  void
 */
function centerMap( map ) {

    // Create map boundaries from all map markers.
    var bounds = new google.maps.LatLngBounds();
    map.markers.forEach(function( marker ){
        bounds.extend({
            lat: marker.position.lat(),
            lng: marker.position.lng()
        });
    });

    // Case: Single marker.
    if( map.markers.length == 1 ){
        map.setCenter( bounds.getCenter() );

    // Case: Multiple markers.
    } else{
        map.fitBounds( bounds );
    }
	
	// Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(4);
        google.maps.event.removeListener(boundsListener);
    });
}

// Render maps on page load.
$(document).ready(function(){
    $('.acf-map').each(function(){
        var map = initMap( $(this) );
    });
});

})(jQuery);
</script>

<?php 
$loop = new WP_Query( array( 
	'post_type' => 'residential', 
	'posts_per_page' => -1 
	) 
);

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
				
					<h3 style="margin-top: 0;"><?php the_title(); ?></h3>
			        <?php if ( $location ) {
			        	echo '<p>' . $location['address'] . '</p>';
			        } else {
		        		echo '<p>' . the_content() . '</p>';
		        	}
		        	
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