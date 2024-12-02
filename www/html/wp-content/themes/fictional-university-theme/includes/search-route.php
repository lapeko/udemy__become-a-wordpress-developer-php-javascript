<?php
	function university_search_route() {
		register_rest_route('university/v1', 'search', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'university_search_results',
		));
	}

	function university_search_results($data) {
		$professors = new WP_Query(array(
			'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
			's' => sanitize_text_field($data['term']),
			'posts_per_page' => $data['limit'] ?: 0,
			'paged' => $data['page'] ?: 1,
		));

		$response = array(
			'generalInfo' => array(),
			'professors' => array(),
			'programs' => array(),
			'events' => array(),
			'campuses' => array(),
		);

		while ($professors->have_posts()) {
			$professors->the_post();
			$postType = get_post_type();

			switch ($postType) {
				case 'post':
				case 'page':
						array_push($response['generalInfo'], fillPostInfo()); break;
				case 'professor':
						array_push($response['professors'], fillPostInfo()); break;
				case 'program':
					array_push($response['programs'], fillPostInfo()); break;
				case 'events':
					array_push($response['events'], fillPostInfo()); break;
				case 'campus':
					array_push($response['campuses'], fillPostInfo()); break;
			}
		}

		return $response;
	}

	function fillPostInfo() {
		return array(
			'title'     => get_the_title(),
			'permalink' => get_the_permalink(),
		);
	}