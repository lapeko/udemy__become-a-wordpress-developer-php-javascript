<?php
	require "helpers.php";

	function load_site_theme_files() {
		wp_enqueue_style( 'google-roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
		wp_enqueue_style( 'bootstrap-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style( 'index-styles', get_theme_file_uri( '/build/index.css' ));
		wp_enqueue_style( 'style-index-styles', get_theme_file_uri( '/build/style-index.css' ));
		wp_enqueue_script( 'google-maps-api-scripts', '//maps.googleapis.com/maps/api/js?key=' . getenv('GOOGLE_MAPS_API_KEY'), array('jquery'), '1.0', true );
		wp_enqueue_script( 'js-scripts', get_theme_file_uri( '/build/index.js'), array('jquery'), '1.0', true );
	}

	function site_theme_features() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_image_size('professorLandscape', 400, 260, true);
		add_image_size('professorPortrait', 480, 650, true);
		add_image_size('pageBanner', 1500, 350, true);
		register_nav_menus( array(
			'footerNavMenuOne' => 'Footer Navigation Menu One',
			'footerNavMenuTwo' => 'Footer Navigation Menu Two',
		));
	}

	function intercept_post_requests($query) {
		interceptEventsQuery($query);
		interceptProgramsQuery($query);
		interceptCampusesQuery($query);
	}

	function university_custom_rest($query) {
		register_rest_field('post', 'authorName', array(
			'get_callback' => function() {
				return get_the_author();
			},
		));
		register_rest_field('event', 'authorName', array(
			'get_callback' => function() {
				return get_the_author();
			},
		));
	}

	function university_map_key($api) {
		$api['key'] = getenv('GOOGLE_MAPS_API_KEY');
		return $api;
	}

	add_action('wp_enqueue_scripts', 'load_site_theme_files');
	add_action("after_setup_theme", 'site_theme_features');
	add_action('pre_get_posts', 'intercept_post_requests');
	add_action('rest_api_init', 'university_custom_rest');
	add_filter('acf/fields/google_map/api', 'university_map_key');
