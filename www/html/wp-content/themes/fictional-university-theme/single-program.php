<?php
	get_header();
	while (have_posts()): the_post();
?>
    <?php addBanner() ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("program") ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span>All programs</span>
                </a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content"><?php the_content(); ?></div>

        <?php
	        $today = date('Ymd');
            $relatedEvents = new WP_Query( array(
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'event_date',
                        'compare' => '>=',
                        'type' => 'numeric',
                        'value' => $today
                    ),
                    array(
                        'key' => 'related_programs',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"',
                    )
                )
            ));
            if (count($relatedEvents->posts)) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
            };
            while ( $relatedEvents->have_posts() ) : $relatedEvents->the_post();
        ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                    <?php $eventDate = new DateTime(get_field('event_date')) ?>
                    <span class="event-summary__month"><?php echo $eventDate->format('M'); ?></span>
                    <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
                    <p><?php echo has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 18) ?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        ?>

        <?php
            $relatedProfessors = new WP_Query( array(
                'posts_per_page' => -1,
                'post_type' => 'professor',
                'orderby' => 'title',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'related_programs',
                        'compare' => 'LIKE',
                        'value' => '"' . get_the_ID() . '"',
                    )
                )
            ));
            if ($relatedProfessors->have_posts()) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professor(s)</h2>';
                echo '<ul class="professor-cards">';
            }
            while ($relatedProfessors->have_posts()) : $relatedProfessors->the_post();
        ?>
            <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                    <img
                        class="professor-card__image"
                        src="<?php the_post_thumbnail_url('professorLandscape'); ?>"
                        alt="<?php the_title() ?>"
                    >
                    <span class="professor-card__name"><?php the_title() ?></span>
                </a>
            </li>
        <?php
            endwhile;
            if ($relatedProfessors->have_posts()) echo '</ul>';
            wp_reset_postdata();

            $relatedCampuses = get_field('related_campuses');
            if ($relatedCampuses) {
                echo '<hr class="section-break">';
	            echo '<h2 class="headline headline--medium">' . get_the_title() . ' is Available At These Campuses:</h2>';
                echo '<ul class="mit-list link-list">';
                foreach ($relatedCampuses as $campus) { ?>
                    <li><a href="<?php echo get_permalink($campus) ?>"><?php echo get_the_title($campus) ?></a></li>
                <?php }
                echo '</ul>';
            }
        ?>
    </div>
<?php
    endwhile;
    get_footer();
?>
