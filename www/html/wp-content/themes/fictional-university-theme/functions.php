<?php
	function load_fictional_university_theme_files() {
		wp_enqueue_style( 'fictional-university-theme', get_stylesheet_uri());
	}

	add_action('wp_enqueue_scripts', 'load_fictional_university_theme_files');
?>