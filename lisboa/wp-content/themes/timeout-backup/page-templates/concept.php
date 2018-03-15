<?php
/**
 * Template Name: Concept
 *
 * @package timeout
 */
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        while (have_posts()) : the_post();
            ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class('concept'); ?>>
                <div class="concept__header">
                    <?php the_field('video'); ?>
                </div>
                <div class="concept__intro">
                    <div class="col col--three">
                        <h1 class="concept__title"><?php nl2br(the_field('title')); ?></h1>
                    </div>
                    <div class="col col--three concept__description">
                        <?php the_field('left-column'); ?>
                    </div>
                    <div class="col col--three concept__description concept__description--highlight">
                        <?php the_field('right-column') ?>
                    </div>
                </div>
                <div class="gallery-container">
                    <?php if (ICL_LANGUAGE_CODE == 'en') : ?>
                        <h1 class="concept__timeline-title">Gallery</h1>
                        <h2 class="concept__timeline-subtitle">See inside the Time Out Market Lisbon</h2>
                    <?php else: ?>
                        <h1 class="concept__timeline-title">Galeria</h1>
                        <h2 class="concept__timeline-subtitle">Tudo o que se passa no Time Out Market</h2>
                    <?php endif; ?>
                    <?php
                    $images = get_field('galeria');

                    if ($images):
                        ?>

                        <div id="carousel" class="flexslider">
                            <ul class="slides">
        <?php foreach ($images as $image): ?>
                                    <li>
                                    <!-- 	<a href="<?php echo $image['url']; ?>" rel="lightbox"> -->
                                        <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                                        <!-- </a> -->
                                    </li>
        <?php endforeach; ?>
                            </ul>
                        </div>
                            <?php endif; ?>

                </div>

                <section class="concept__timeline">
                    <h1 class="concept__timeline-title"><?php esc_html_e('Timeline', 'timeout'); ?></h1>
                    <h2 class="concept__timeline-subtitle"><?php esc_html_e('history of the Market', 'timeout'); ?></h2>

                    <div id="concept__timeline-holder" class="concept__timeline-holder">
                        <div class="concept__timeline-wrapper handle">
    <?php
    if (have_rows('item')):

        $isEven = true;

        while (have_rows('item')) : the_row();

            if ($isEven) :
                ?>

                                        <article class="concept__timeline-item <?php the_sub_field('border-top'); ?>">
                                            <div class="concept__timeline-item-top">
                                                <h2 class="concept__timeline-item-year"><?php the_sub_field('timeline-year'); ?></h2>
                                                <h1 class="concept__timeline-item-title"><?php the_sub_field('timeline-title'); ?></h1>
                                                <div class="concept__timeline-item-description"><?php the_sub_field('timeline-description'); ?></div>
                                            </div>
                                            <div class="concept__timeline-item-bottom" style="border-color: <?php the_sub_field('color'); ?>">
                <?php
                if (get_sub_field('image')) {
                    echo wp_get_attachment_image(get_sub_field('image'), 'full', false, array("class" => "concept__timeline-item-image"));
                }
                ?>
                                            </div>							
                                        </article>

                                            <?php else: ?>

                                        <article class="concept__timeline-item <?php the_sub_field('border-top'); ?>">
                                            <div class="concept__timeline-item-top">
                                        <?php
                                        if (get_sub_field('image')) {
                                            echo wp_get_attachment_image(get_sub_field('image'), 'full', false, array("class" => "concept__timeline-item-image"));
                                        }
                                        ?>
                                            </div>
                                            <div class="concept__timeline-item-bottom" style="border-color: <?php the_sub_field('color'); ?>">
                                                <h2 class="concept__timeline-item-year"><?php the_sub_field('timeline-year'); ?></h2>
                                                <h1 class="concept__timeline-item-title"><?php the_sub_field('timeline-title'); ?></h1>
                                                <div class="concept__timeline-item-description"><?php the_sub_field('timeline-description'); ?></div>
                                            </div>
                                        </article>

            <?php
            endif;

            $isEven = !$isEven;

        endwhile;

    endif;
    ?>
                        </div>
                    </div>

                    <div id="concept__timeline-pig" class="concept__timeline-pig">
                            <?php if (ICL_LANGUAGE_CODE == 'en') : ?>
                            <div class="handle" style="background-position: -100px 0px;"></div>
    <?php else: ?>
                            <div class="handle" style="background-position: 0px 0px;"></div>
    <?php endif; ?>
                    </div>
                </section>

            </div><!-- #post-## -->

                        <?php
                    endwhile; // End of the loop.
                    ?>

    </main><!-- #main -->
</div><!-- #primary -->

        <?php
        get_footer();
        