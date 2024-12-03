<?php
	function registerEventPos() {
		register_post_type( 'event', array(
			'capability_type' => 'event',
			'add_meta_cap' => true,
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

	function registerProgramPost() {
		register_post_type( 'program', array(
			'rewrite' => array('slug' => 'programs'),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-awards',
			'show_in_rest' => true,
			'supports' => array('title'),
			'labels' => array(
				'name' => 'Programs',
				'add_new_item' => 'Add New Program',
				'edit_item' => 'Edit Program',
				'all_items' => 'All Programs',
				'singular_name' => 'Program',
			),
		));
	}

	function registerProfessorPost() {
		register_post_type( 'professor', array(
			'public' => true,
			'menu_icon' => 'dashicons-welcome-learn-more',
			'show_in_rest' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'labels' => array(
				'name' => 'Professors',
				'add_new_item' => 'Add New Professor',
				'edit_item' => 'Edit Professor',
				'all_items' => 'All Professors',
				'singular_name' => 'Professor',
			),
		));
	}

	function registerCampusPost() {
		register_post_type( 'campus', array(
			'capability_type' => 'campus',
			'add_meta_cap' => true,
			'rewrite' => array('slug' => 'campuses'),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-location-alt',
			'show_in_rest' => true,
			'supports' => array('title', 'editor'),
			'labels' => array(
				'name' => 'Campuses',
				'add_new_item' => 'Add New Campus',
				'edit_item' => 'Edit Campus',
				'all_items' => 'All Campuses',
				'singular_name' => 'Campus',
			),
		));
	}

	function registerNotePost() {
		register_post_type( 'note', array(
			'public' => false,
			'show_ui' => true,
			'menu_icon' => 'dashicons-welcome-write-blog',
			'show_in_rest' => true,
			'supports' => array('title', 'editor'),
			'labels' => array(
				'name' => 'Notes',
				'add_new_item' => 'Add New Note',
				'edit_item' => 'Edit Note',
				'all_items' => 'All Notes',
				'singular_name' => 'Note',
			),
		));
	}

	function register_post_types() {
		registerEventPos();
		registerProgramPost();
		registerProfessorPost();
		registerCampusPost();
		registerNotePost();
	}

	add_action('init', 'register_post_types');