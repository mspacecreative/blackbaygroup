<?php 
$args = array(
	'post_type' => 'residential',
	'posts_per_page' => -1,
	'post__not_in' => array ($post->ID),
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

<h2><?php echo esc_html_e('Other Properties'); ?></h2>
		
<div class="residential-carousel margin-top-2em listing-grid">
			
	<?php while ( $loop->have_posts() ) : $loop->the_post();
			
	// VARIABLES
	$featuredimg = get_the_post_thumbnail_url( get_the_ID(), 'listing-thumb' );
	$imgalt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
	$title = get_the_title(get_the_ID()); ?>
			
	<div class="col col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<a class="taphover" href="<?php echo the_permalink(); ?>">
			<?php if ( $featuredimg ): ?>
			<img src="<?php echo $featuredimg ?>" alt="<?php if ( $imgalt ): echo $imgalt; else: echo bloginfo('name'); endif; ?>">
			<?php else : ?>
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blackbay_placeholder.png" alt="<?php the_title(); ?>" /> 
			<?php endif; ?>
			<p><?php echo $title ?></p>
		</a>
	</div>
			
	<?php endwhile; ?>
</div>
		
<?php endif; wp_reset_query(); ?>