<?php
	require "helpers.php";

	function load_site_theme_files() {
		wp_enqueue_style( 'google-roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
		wp_enqueue_style( 'bootstrap-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style( 'index-styles', get_theme_file_uri( '/build/index.css' ));
		wp_enqueue_style( 'style-index-styles', get_theme_file_uri( '/build/style-index.css' ));
		wp_enqueue_script( 'js-scripts', get_theme_file_uri( '/build/index.js'), array('jquery'), '1.0', true );
	}

	function site_theme_features() {
		add_theme_support( 'title-tag' );
		register_nav_menus( array(
			'mainHeaderNavMenu' => 'Main Navigation Menu',
			'footerNavMenuOne' => 'Footer Navigation Menu One',
			'footerNavMenuTwo' => 'Footer Navigation Menu Two',
		));
	}

	function intercept_post_requests($query) {
		interceptEventsQuery($query);
		interceptProgramsQuery($query);
	}

	add_action('wp_enqueue_scripts', 'load_site_theme_files');
	add_action("after_setup_theme", 'site_theme_features');
	add_action('pre_get_posts', 'intercept_post_requests');
