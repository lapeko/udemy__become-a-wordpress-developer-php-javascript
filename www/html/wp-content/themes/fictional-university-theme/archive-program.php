<?php
  get_header();
  addBanner(array(
    'background' => '/images/library-hero.jpg',
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone',
  ));
?>
    <div class="container container--narrow page-section">
        <ul class="link-list min-list">
            <?php while(have_posts()): the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>
            <?php endwhile; echo paginate_links(); ?>
        </ul>
        <?php paginate_links() ?>
	</div>
<?php get_footer(); ?>