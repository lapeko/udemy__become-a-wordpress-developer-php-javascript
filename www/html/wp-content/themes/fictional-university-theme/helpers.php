<?php
	function is_page_slug_or_child($slug): bool {
		if (is_page($slug)) return true;

		$parentId = wp_get_post_parent_id(0);
		if (!$parentId) return false;

		return get_post_field('post_name', $parentId) == $slug;
	}

	function applyCurrentMenuItemClass($slug) {
		echo is_page_slug_or_child($slug) ? ' class="current-menu-item"':  '';
	}