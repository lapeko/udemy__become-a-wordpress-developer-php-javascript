<?php
	get_header();
	addBanner();
	if (!is_user_logged_in()) {
		wp_redirect(home_url());
		exit();
	}
?>

	<div class="container container--narrow page-section">
		<ul class="min-list link-list">
			<?php
				$notes = new WP_Query(array(
					'post_type' => 'note',
					'posts_per_page' => 2,
					'author' => get_current_user_id(),
				));
				while ($notes->have_posts()): $notes->the_post();
			?>
				<li>
					<input class="note-title-field" value="<?php esc_attr(the_title()); ?>">
					<span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
					<span class="delete-note"><i class="fa fa-trash"></i> Delete</span>
					<textarea class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>

<?php get_footer(); ?>