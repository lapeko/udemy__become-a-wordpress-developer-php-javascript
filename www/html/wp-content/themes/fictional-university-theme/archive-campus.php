<?php
	get_header();
	addBanner(array(
		'title' => 'Our Campuses',
		'subtitle' => 'We have several convenient located campuses.',
	));
?>
	<div class="container container--narrow page-section">
		<div class="acf-map">
			<?php while(have_posts()): the_post(); $location = get_field('map_location'); ?>
				<div class="marker" data-lat="<?php echo $location['lat'] ?>" data-lng="<?php echo $location['lng'] ?>">
                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                    </h3>
                    <p><?php echo $location['address'] ?></p>
                </div>
			<?php endwhile; echo paginate_links(); ?>
		</div>
	</div>
<?php get_footer(); ?>