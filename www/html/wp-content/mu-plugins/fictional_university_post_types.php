<?php
	function registerEventPostType() {
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

	function registerProgramPostTypes() {
		register_post_type( 'program', array(
			'rewrite' => array('slug' => 'programs'),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-awards',
			'show_in_rest' => true,
			'supports' => array('title', 'editor'),
			'labels' => array(
				'name' => 'Programs',
				'add_new_item' => 'Add New Program',
				'edit_item' => 'Edit Program',
				'all_items' => 'All Programs',
				'singular_name' => 'Program',
			),
		));
	}

	function site_post_types() {
		registerEventPostType();
		registerProgramPostTypes();
	}

	add_action('init', 'site_post_types');