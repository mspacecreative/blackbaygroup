<?php

// RESIDENTIAL LISTINGS
function residentialListings() {
    ob_start();
    get_template_part('includes/residential-listings-map');
    return ob_get_clean();
}
add_shortcode( 'residential_map', 'residentialListings' );