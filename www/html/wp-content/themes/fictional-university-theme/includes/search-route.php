<?php
	function university_search_route() {
		register_rest_route('university/v1', 'search', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'university_search_results',
		));
	}

	function university_search_results($data) {
		$professors = new WP_Query(array(
			'post_type' => 'professor',
			's' => sanitize_text_field($data['term']),
		));

		$response = array();

		while ($professors->have_posts()) {
			$professors->the_post();
			$response[] = array(
				'title'     => get_the_title(),
				'permalink' => get_the_permalink(),
			);
		}

		return $response;
	}