<?php

function dynamic_field_values ( $tag, $unused ) {

    global $post;
    
    if ( $tag['name'] != 'properties' )
        return $tag;
        
    $exclude = get_post_meta( $post->ID, 'exclude_listing_from_drop_down', true );

    $args = array (
	        'numberposts' => -1,
	        'post_type' => 'residential',
	        'order' => 'ASC',
	        'meta_key' => 'exclude_listing_from_drop_down',
	        'meta_value' => $exclude,
        	'post__not_in' => array($post->ID)
		)
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