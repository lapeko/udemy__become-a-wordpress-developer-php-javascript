<?php get_header(); ?>
    <?php addBanner(array(
        'background' => '/images/library-hero.jpg',
        'title' => 'Past events',
    )); ?>

	<div class="container container--narrow page-section">
		<?php
			$today = date('Ymd');
			$past_events = new WP_Query(array(
				'paged' => get_query_var('paged', 1),
				'post_type' => 'event',
				'meta_key' => 'event_date',
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'event_date',
						'compare' => '<',
						'value' => $today,
						'type' => 'numeric',
					)
				)
			));
			while ($past_events->have_posts()): $past_events->the_post();
		        get_template_part('template-parts/content-event');
			endwhile;
            wp_reset_postdata();
			echo paginate_links();
		?>
	</div>

<?php get_footer(); ?>