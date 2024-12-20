<?php
    get_header();
    while (have_posts()) {
        the_post();
        $parent_id = wp_get_post_parent_id(get_the_ID());
        $child_pages = get_pages(array(
            'parent' => get_the_ID(),
            'sort_column' => 'menu_order')
        );
?>
        <?php addBanner() ?>

        <div class="container container--narrow page-section">
           <?php if ($parent_id) { ?>
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                        <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_id); ?>">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <?php echo get_the_title($parent_id); ?>
                        </a>
                        <span class="metabox__main"><?php the_title(); ?></span>
                    </p>
                </div>
            <?php } ?>

            <?php
                if ($parent_id or count($child_pages)) {
                    $title = $parent_id ? get_the_title($parent_id) : get_the_title();
                    $id = $parent_id ?: get_the_ID();
            ?>
                <div class="page-links">
                    <h2 class="page-links__title"><a href="<?php echo get_permalink($parent_id); ?>"><?php echo $title ?></a></h2>
                    <ul class="min-list">
                        <?php
                            echo wp_list_pages(array(
                                'title_li' => NULL,
                                'parent' => $id,
                                'sort_column' => 'menu_order')
                            )
                        ?>
                    </ul>
                </div>
            <?php } ?>

            <div class="generic-content">
                <?php the_content(); ?>
            </div>
        </div>
<?php
	}
    get_footer();
?>
