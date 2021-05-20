<?php

function dynamic_field_values ( $tag, $unused ) {

    if ( $tag['name'] != 'properties' )
        return $tag;

    $args = array (
        'numberposts' => -1,
        'post_type' => array (
        	'residential',
        	'commercial'
        ),
        'order' => 'ASC',
        'meta_query' => array(
        	array(
				'key' => 'include_listing_in_drop_down',
			   'value' => '1'
			)
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