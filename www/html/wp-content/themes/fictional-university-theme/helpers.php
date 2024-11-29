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