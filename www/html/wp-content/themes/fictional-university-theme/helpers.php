<?php
	function interceptEventsQuery($query) {
		if (is_admin() || !$query->is_main_query() || !is_post_type_archive('event'))
			return;

		$today = date('Ymd');
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
			array(
				'key' => 'event_date',
				'compare' => '>=',
				'value' => $today,
				'type' => 'numeric',
			)
		));
	}

	function interceptProgramsQuery($query) {
		if (is_admin() || !$query->is_main_query() || !is_post_type_archive('program'))
			return;

		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
	}

	function addBanner($arr = NULL) {
		$background = $arr['background']
			? get_theme_file_uri($arr['background'])
			: get_field('page_banner_background_image')['sizes']['pageBanner'];
		$background = $background ?: get_theme_file_uri('images/ocean.jpg');
		$title = $arr['title'] ?: get_the_title();
		$subtitle = $arr['subtitle'] ?: get_field('page_banner_subtitle');
	?>
		<div class="page-banner">
			<div class="page-banner__bg-image" style="background-image: url(<?php echo $background ?>)"></div>
			<div class="page-banner__content container container--narrow">
				<div class="page-banner__content container t-center c-white">
					<h1 class="headline headline--large"><?php echo $title; ?></h1>
					<?php if ($subtitle) echo '<h2 class="headline headline--medium">' . $subtitle . '</h2>' ?>
				</div>
			</div>
		</div>
	<?php
	}
