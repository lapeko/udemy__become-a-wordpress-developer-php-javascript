<?php
    get_header();
    while (have_posts()): the_post();
?>
        <?php addBanner(); ?>

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("event") ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>All events</span>
                    </a>
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>

            <div class="generic-content">
                <?php the_content(); ?>
            </div>

            <?php
                $relPrograms = get_field('related_programs');
                if ($relPrograms) {
            ?>
                <hr class="section-break">
                <h2 class="headline headline--medium">Related Program(s)</h2>
                <ul class="link-list min-list">
                    <?php foreach ($relPrograms as $relProgram) { ?>
                        <li><a href="<?php echo get_the_permalink($relProgram) ?>"><?php print_r(get_the_title($relProgram)); ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
<?php
    endwhile;
    get_footer();
?>
