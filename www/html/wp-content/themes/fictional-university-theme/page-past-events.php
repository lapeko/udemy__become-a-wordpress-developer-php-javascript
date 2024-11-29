<?php get_header(); ?>

	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg'); ?>)"></div>
		<div class="page-banner__content container t-center c-white">
			<h1 class="headline headline--large">Past events</h1>
		</div>
	</div>

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
		?>
				<div class="event-summary">
					<a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
						<?php $eventDate = new DateTime(get_field('event_date')) ?>
						<span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
						<span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
					</a>
					<div class="event-summary__content">
						<h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
						<p><?php echo wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
					</div>
				</div>
		<?php
			endwhile;
      wp_reset_postdata();
			echo paginate_links();
		?>
	</div>

<?php get_footer(); ?>