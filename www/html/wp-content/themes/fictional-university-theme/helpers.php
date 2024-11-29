<?php
	function isPageOrChildASlug($slug): bool {
		$post_id = get_the_ID();

		if (get_post_field('post_name', $post_id) === $slug)
			return true;

		$parent_id = wp_get_post_parent_id($post_id);
		if ($parent_id && get_post_field('post_name', $parent_id) === $slug)
			return true;

		$blog_page_id = get_option('page_for_posts');
		if (is_home() && $blog_page_id && get_post_field('post_name', $blog_page_id) === $slug)
			return true;

		return is_post_type_archive($slug);
	}


	function applyCurrentMenuItemClass($slug) {
		echo isPageOrChildASlug($slug) ? ' class="current-menu-item"':  '';
	}