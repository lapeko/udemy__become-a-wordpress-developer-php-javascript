<?php
	function university_search_route() {
		register_rest_route('university/v1', 'search', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'university_search_results',
		));
	}

	function university_search_results() {
		return 'Congratulations! You created a route.';
	}