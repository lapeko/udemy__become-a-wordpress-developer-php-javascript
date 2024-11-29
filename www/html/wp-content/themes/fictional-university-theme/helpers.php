<?php
	function isPageOrChildASlug($slug): bool {
		if (is_page($slug)) return true;

		$blog_page_id = get_option('page_for_posts');
		if (is_home() && $slug === get_post_field('post_name', $blog_page_id)) return true;

		$parentId = wp_get_post_parent_id(0);
		if (!$parentId) return false;

		return get_post_field('post_name', $parentId) == $slug;
	}

	function applyCurrentMenuItemClass($slug) {
		echo isPageOrChildASlug($slug) ? ' class="current-menu-item"':  '';
	}