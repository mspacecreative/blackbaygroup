<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since ??
 */
do_action( 'et_after_main_content' );

if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
				<?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						get_template_part( 'includes/social_icons', 'footer' );
					}

					echo esc_html_e('&copy; '); echo date('Y '); echo bloginfo('name'); echo esc_html_e('. All rights reserved.');
				?>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMjm_0er-ybuWcVoPXYLSr82mn6bvNqCY"></script>
	<script type="text/javascript">
	(function($) {
	
	/*
	*  new_map
	*
	*  This function will render a Google Map onto the selected jQuery element
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	$el (jQuery element)
	*  @return	n/a
	*/
	
	function new_map( $el ) {
		
		// var
		var $markers = $el.find('.marker');
		
		
		// vars
		var args = {
			zoom		: 16,
			center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP
		};
		
		
		// create map	        	
		var map = new google.maps.Map( $el[0], args);
		
		
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
	
	/*
	*  add_marker
	*
	*  This function will add a marker to the selected Google Map
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	$marker (jQuery element)
	*  @param	map (Google Map object)
	*  @return	n/a
	*/
	
	function add_marker( $marker, map ) {
	
		// var
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
		
		function pinSymbol(color) {
		    return {
		        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
		        fillColor: color,
		        fillOpacity: 1,
		        strokeColor: '#fff',
		        strokeWeight: 1,
		        scale: 1,
		   };
		}
	
		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			icon: pinSymbol("#000000"), 
		});
	
		// add to array
		map.markers.push( marker );
	
		// if marker contains HTML, add it to an infoWindow
		if( $marker.html() )
		{
			// create info window
			var infowindow = new google.maps.InfoWindow({
				content		: $marker.html()
			});
	
			// show info window when marker is clicked
			google.maps.event.addListener(marker, 'click', function() {
	
				infowindow.open( map, marker );
	
			});
		}
	
	}
	
	/*
	*  center_map
	*
	*  This function will center the map, showing all markers attached to this map
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	map (Google Map object)
	*  @return	n/a
	*/
	
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
			map.fitBounds( bounds );
		}
	
	}
	
	/*
	*  document ready
	*
	*  This function will render each map when the document is ready (page has loaded)
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	// global var
	var map = null;
	
	$(document).ready(function(){
	
		$('.acf-map').each(function(){
	
			// create map
			map = new_map( $(this) );
	
		});
	
	});
	
	})(jQuery);
	</script>
	
</body>
</html>
