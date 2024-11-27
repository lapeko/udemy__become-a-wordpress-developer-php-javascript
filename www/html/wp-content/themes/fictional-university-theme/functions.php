<?php
	function load_fictional_university_theme_files() {
		wp_enqueue_style( 'google-roboto-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
		wp_enqueue_style( 'bootstrap-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style( 'index-styles', get_theme_file_uri( '/build/index.css' ));
		wp_enqueue_style( 'style-index-styles', get_theme_file_uri( '/build/style-index.css' ));
		wp_enqueue_script( 'js-scripts', get_theme_file_uri( '/build/index.js'), array('jquery'), '1.0', true );
	}

	function fictional_university_theme_features() {
		add_theme_support( 'title-tag' );
	}

	add_action('wp_enqueue_scripts', 'load_fictional_university_theme_files');
	add_action("after_setup_theme", 'fictional_university_theme_features');
?>