<?php

get_header();

//$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

//$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
	
	<div class="container">
		<!-- SINGLE LISTING SECTION -->
		<div class="fw-container clearfix">
			
			<h1 class="entry-title main_title"><?php _e('Residential Listings for Sale'); ?></h1>
						
						<div class="grid testimonial-container">
						
							<div class="grid-sizer"></div>
							<div class="gutter-sizer"></div>
							
							<?php $loop = new WP_Query( array( 'post_type' => 'residential_for_sale', 'order' => 'ASC' ) );
									if ( $loop->have_posts() ) :
							        while ( $loop->have_posts() ) : $loop->the_post(); ?>
							
											<div class="grid-item index-post-box light-grey">
												<div class="grid-item-shadow">
													<div class="grid-inner">
														<i class="fa fa-plus"></i>
														<a class="taphover" href="<?php echo the_permalink(); ?>"></a>
														<?php if ( has_post_thumbnail() ) {
																	    the_post_thumbnail();
															} else { ?>
															<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blackbay_placeholder.png" alt="<?php the_title(); ?>" /> 
															<?php } ?>
													</div>
													<p><?php the_title(); ?></p>
												</div>
											</div>
							
											<?php endwhile;
									endif; 
							wp_reset_postdata(); ?>
						
						</div>
			
		</div>
		<!-- END SINGLE LISTING SECTION -->
		
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
