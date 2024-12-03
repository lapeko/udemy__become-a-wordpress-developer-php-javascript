<?php
	function university_search_route() {
		register_rest_route('university/v1', 'search', array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'university_search_results',
		));
	}

	function university_search_results($data): array {
		$items = new WP_Query(array(
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

		while ($items->have_posts()) {
			$items->the_post();
			$postType = get_post_type();

			switch ($postType) {
				case 'post':
				case 'page': $response = fillPostInfo($response, 'generalInfo'); break;
				case 'professor': $response = fillPostInfo($response, 'professors'); break;
				case 'program': $response = fillPostInfo($response, 'programs'); break;
				case 'event': $response = fillPostInfo($response, 'events'); break;
				case 'campus': $response = fillPostInfo($response, 'campuses'); break;
			}
		}

		return $response;
	}

	function fillPostInfo($array, $key) {
		$item = array(
			'title'     => get_the_title(),
			'permalink' => get_the_permalink(),
		);

		switch ($key) {
			case 'generalInfo': $item['author'] = get_the_author(); break;
			case 'professors':
				$item['thumbnail'] = get_the_post_thumbnail_url(0, 'professorLandscape'); break;
			case 'events':
				$eventDate = new DateTime(get_field('event_date'));
				$item['month'] = $eventDate->format('M');
				$item['day'] = $eventDate->format('d');
				$item['content'] = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18);
				break;
			case 'programs':
				$relatedData = getProfessorRelatedData(get_the_ID());
				$array['professors'] = array_merge($array['professors'], $relatedData['professors']);
				$array['events'] = array_merge($array['events'], $relatedData['events']);
				$array['campuses'] = array_merge($array['campuses'], $relatedData['campuses']);
				break;
		}

		$array[$key][] = $item;
		$array['professors'] = array_unique($array['professors'], SORT_REGULAR);
		$array['events'] = array_unique($array['events'], SORT_REGULAR);
		$array['campuses'] = array_unique($array['campuses'], SORT_REGULAR);

		return $array;
	}

	function getProfessorRelatedData($programId): array {
		$wholeCampuses = get_field('related_campuses');
		$professorsQuery = new WP_Query(array(
			'post_type' => array('professor', 'event'),
			'relation' => 'OR',
			'meta_query' => array(
				array(
					'key' => 'related_programs',
					'compare' => 'LIKE',
					'value' => $programId,
				)
			),
		));

		$professors = array();
		$events = array();

		while ($professorsQuery->have_posts()): $professorsQuery->the_post();
			if (get_post_type() === 'professor') {
				$professors[] = array(
					'title'     => get_the_title(),
					'permalink' => get_the_permalink(),
					'thumbnail' => get_the_post_thumbnail_url( 0, 'professorLandscape' ),
				);
			}
			if (get_post_type() === 'event') {
				$eventDate = new DateTime( get_field( 'event_date' ) );
				$events[]  = array(
					'title'     => get_the_title(),
					'permalink' => get_the_permalink(),
					'month'     => $eventDate->format( 'M' ),
					'day'       => $eventDate->format( 'd' ),
					'content'   => has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 18 ),
				);
			}
		endwhile;

		$campuses = array();

		foreach ($wholeCampuses as $campus) {
			$campuses[] = array(
				'title' => get_the_title($campus),
				'permalink' => get_the_permalink($campus),
			);
		}

		return array(
			'professors' => $professors,
			'events' => $events,
			'campuses' => $campuses,
		);
	}