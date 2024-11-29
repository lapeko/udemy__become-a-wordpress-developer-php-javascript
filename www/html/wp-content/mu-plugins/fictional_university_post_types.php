<?php
	function site_post_types() {
		register_post_type( 'event', array(
			'rewrite' => array('slug' => 'events'),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-calendar',
			'show_in_rest' => true,
			'supports' => array('title', 'editor', 'excerpt'),
			'labels' => array(
				'name' => 'Events',
				'add_new_item' => 'Add New Event',
				'edit_item' => 'Edit Event',
				'all_items' => 'All Events',
				'singular_name' => 'Event',
			),
		));
	}

	add_action('init', 'site_post_types');