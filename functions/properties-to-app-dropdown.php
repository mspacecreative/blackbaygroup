<?php

function listings_to_app_dropdown ( $tag, $unused ) {

    if ( $tag['name'] != 'app-properties' )
        return $tag;

    $args = array (
        'numberposts' => -1,
        'post_type' => 'residential',
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

add_filter( 'wpcf7_form_tag', 'listings_to_app_dropdown', 10, 2);