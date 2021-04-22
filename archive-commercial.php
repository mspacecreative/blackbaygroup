<?php get_header(); ?>

<div id="main-content">
	<div class="container">
		<!-- SINGLE LISTING SECTION -->
		<div class="fw-container clearfix">
			<h1 class="entry-title main_title"><?php _e('Commercial units'); ?></h1>
			
			<?php
			$loop = new WP_Query( 
				array( 
					'post_type' => 'commercial', 
					'order' => 'DESC' 
				) 
			);
			if ( $loop->have_posts() ) :
			
			$layout = get_field('layout');
			
			if ( $layout === 'masonry' ): ?>
			
			<div class="grid testimonial-container">
				<div class="grid-sizer"></div>
				
				<div class="gutter-sizer"></div>
				
				<?php while ( $loop->have_posts() ) : $loop->the_post();
				$featuredimg = get_the_post_thumbnail_url( $post->ID, 'listing-thumb'); ?>
				
				<div class="grid-item index-post-box light-grey">
					<div class="grid-item-shadow">
						<div class="grid-inner"><i class="fa fa-plus"></i>
							<a class="taphover" href="<?php echo the_permalink(); ?>"></a>
							<?php if ( $featuredimg ):
								echo '<img src="' . $featuredimg . '">';
							else : ?>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blackbay_placeholder.png" alt="<?php the_title(); ?>" /> 
							<?php endif; ?>
						</div>
						
						<p><?php the_title(); ?></p>
					</div>
				</div>
				
				<?php endwhile;
				
			elseif ( $layout === 'flex' ): ?>
			
			<div class="row listing-grid">
				<?php while ( $loop->have_posts() ) : $loop->the_post();
				$featuredimg = get_the_post_thumbnail_url( $post->ID, 'listing-thumb'); ?>
				<div class="col col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<a class="taphover" href="<?php echo the_permalink(); ?>">
						<?php if ( $featuredimg ):
							echo '<img src="' . $featuredimg . '">';
						else : ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blackbay_placeholder.png" alt="<?php the_title(); ?>" /> 
						<?php endif; ?>
						<p><?php the_title(); ?></p>
					</a>
				</div>
				<?php endwhile; ?>
			</div>
			
			<?php else: ?>
			
			<div class="row listing-grid">
				<?php while ( $loop->have_posts() ) : $loop->the_post();
				$featuredimg = get_the_post_thumbnail_url( $post->ID, 'listing-thumb'); ?>
				<div class="col col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<a class="taphover" href="<?php echo the_permalink(); ?>">
						<?php if ( $featuredimg ):
							echo '<img src="' . $featuredimg . '">';
						else : ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/blackbay_placeholder.png" alt="<?php the_title(); ?>" /> 
						<?php endif; ?>
						<p><?php the_title(); ?></p>
					</a>
				</div>
				<?php endwhile; ?>
			</div>
				
			<?php endif; ?>
			
			</div>
			<?php endif; wp_reset_postdata(); ?>
		</div>
		<!-- END SINGLE LISTING SECTION -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
