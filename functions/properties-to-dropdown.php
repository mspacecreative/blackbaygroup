<?php

function dynamic_field_values ( $tag, $unused ) {

    if ( $tag['name'] != 'properties' )
        return $tag;

    $args = array (
        'numberposts' => -1,
        'post_type' => 'residential',
        'order' => 'ASC',
        'meta_query' => array(
        	array(
		        'key' => 'exclude_from_list',
		        'value' => true,
	    	),
	    	array(
		        'key' => 'exclude_listing_from_drop_down',
		        'compare' => 'NOT EXISTS',
	    	),
		),
    );

    $custom_posts = get_posts($args);

    if ( ! $custom_posts )
        return $tag;

    foreach ( $custom_posts as $custom_post ) {

        $tag['raw_values'][] = $custom_post->post_title;
        $tag['values'][] = $custom_post->post_title;
        $tag['labels'][] = $custom_post->post_title;

    }

    return $tag;

}

add_filter( 'wpcf7_form_tag', 'dynamic_field_values', 10, 2);