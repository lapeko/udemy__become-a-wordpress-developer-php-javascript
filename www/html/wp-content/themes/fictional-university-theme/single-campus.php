<?php
	get_header();
	while (have_posts()): the_post();
		addBanner();
?>
	<div class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p>
				<a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("campus") ?>">
					<i class="fa fa-home" aria-hidden="true"></i>
					<span>All campuses</span>
				</a>
				<span class="metabox__main"><?php the_title(); ?></span>
			</p>
		</div>

		<div class="generic-content"><?php the_content(); ?></div>

		<?php
			$relatedPrograms = new WP_Query( array(
				'post_type' => 'program',
				'orderby' => 'title',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'related_campuses',
						'compare' => 'LIKE',
						'value' => '"' . get_the_ID() . '"',
					)
				)
			));
			if ($relatedPrograms->have_posts()) {
				echo '<hr class="section-break" />';
				echo '<h2 class="headline headline--medium">Programs Available At This Campus</h2>';
				echo '<ul class="min-list link-list">';
				while ($relatedPrograms->have_posts()) : $relatedPrograms->the_post();
		?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>
		<?php
				endwhile;
				echo '</ul>';
			}
			wp_reset_postdata();
		?>

		<?php $location = get_field('map_location'); ?>
		<div class="acf-map">
			<div class="marker" data-lat="<?php echo $location['lat'] ?>" data-lng="<?php echo $location['lng'] ?>">
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
				</h3>
				<p><?php echo $location['address'] ?></p>
			</div>
		</div>
	</div>
<?php
	endwhile;
	get_footer();
?>
