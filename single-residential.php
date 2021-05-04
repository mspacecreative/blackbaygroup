<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
	
	<div class="bevel-overlay">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/top-right-wood-triangle.png" alt="BlackBay Group Inc." />
	</div>
	
	<?php
		if ( et_builder_is_product_tour_enabled() ):
			// load fullwidth page in Product Tour mode
			while ( have_posts() ): the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">
					<?php
						the_content();
					?>
					</div> <!-- .entry-content -->

				</article> <!-- .et_pb_post -->

		<?php endwhile;
		else:
	?>
	<div class="container">
		<!-- SINGLE LISTING SECTION -->
		<div class="fw-container clearfix">
			
			<!-- LEFT SIDE CONTENT SECTION -->
			<div class="left-content">
			
				<div class="title-desc-container">
					<h1 class="dark"><?php the_title(); ?></h1>
					
					<?php 
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
								
								the_content();
							
						} // end while
					} // end if
					?>
				</div>
				
				<!-- BUILDING FEATURES -->
				<h3 class="line-rule-right"><span>Building Features</span></h3>
				<!-- /BUILDING FEATURES -->
					
				<!-- BULLET BOX -->
				<div class="bullet-box">
					<ul class="features clearfix">
						<?php if( have_rows('building_features') ):
						
						 	while ( have_rows('building_features') ) : the_row(); ?>
						 	
						<li><?php the_sub_field('features_list'); ?></li>
						
						<?php endwhile; else : endif; ?>
					</ul>
				</div>
				<!-- END BULLET BOX -->
					
				<!-- UNIT INFO -->
				<?php if( have_rows('unit_features') ): ?>
				<div class="unit-info-box">
					<h3><?php _e('Monthly Unit Costs'); ?></h3>
					<ul>
						<?php while ( have_rows('unit_features') ) : the_row(); ?>
						 	
						<li><?php the_sub_field('unit_list'); ?></li>
						
						<?php endwhile; ?>
					</ul>
				</div>
				<?php endif; ?>
				<!-- /UNIT INFO -->
				
				<!-- CTA BUTTONS -->
				<?php if( get_field('more_info_button') ): ?>
				<div class="button light">
					<a href="<?php the_field('more_info_button'); ?>" target="_blank">More Information</a>
				</div>
				<?php endif; ?>
				<!-- END CTA BUTTONS -->
				
			</div>
			<!-- END LEFT SIDE CONTENT SECTION -->
			
			<!-- RIGHT SIDE CONTENT SECTION -->
			<div class="right-content">
				
				<!-- SLIDE SHOW-->
				<?php 
				
				$images = get_field('photo_gallery');
				$size = 'full';
				
				if( $images ): ?>
				
				<!-- SLIDE SHOW-->
				<div class="photo-gallery">
				
					<?php foreach( $images as $image ): ?>
					<div>
						<?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
					</div>
					<?php endforeach; ?>
					
				</div>
				<!-- END SLIDE SHOW-->
				
				<?php endif; ?>
				
				<!-- GOOGLE MAP -->
				<style type="text/css">
				.single .acf-map {
				    width: 100%;
				    height: 400px;
				    border: #ccc solid 1px;
				    margin: 20px 0;
				}
				
				.acf-map img {
				   max-width: inherit !important;
				}
				</style>
				<script type="text/javascript">
				(function( $ ) {
				
					function initMap( $el ) {
					
					    // Find marker elements within map.
					    var $markers = $el.find('.marker');
					
					    // Create gerenic map.
					    var mapArgs = {
					        zoom        : $el.data('zoom') || 16,
					        mapTypeId   : google.maps.MapTypeId.ROADMAP
					    };
					    var map = new google.maps.Map( $el[0], mapArgs );
					
					    // Add markers.
					    map.markers = [];
					    $markers.each(function(){
					        initMarker( $(this), map );
					    });
					
					    // Center map based on markers.
					    centerMap( map );
					
					    // Return map instance.
					    return map;
					}
					
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
								url: window.location.protocol + '//' + window.location.host + '/wp-content/themes/blackbay/includes/img/black-pin.png',
								size: new google.maps.Size(32, 32),
								origin: new google.maps.Point(0, 0),
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
					            infowindow.open( map, marker );
					        });
					    }
					}
					
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
				
				$location = get_field('location_map');
				
				if( !empty($location) ):
				?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
				</div>
				<?php endif; ?>
				<!-- END GOOGLE MAP -->
				
			</div>
			<!-- END RIGHT SIDE CONTENT SECTION -->
			
		</div>
		<!-- END SINGLE LISTING SECTION -->
		
		<div class="other-listings">
			<?php get_template_part('includes/loop-other-residential'); ?>
		</div>
		
	</div> <!-- .container -->
	<?php endif; ?>
</div> <!-- #main-content -->

<?php

get_footer();
