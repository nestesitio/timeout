<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class('academy-studio academia-parent'); ?>>

    <div class="col col--two">
        <div class="academy-module">

            <?php if (get_field('link')) : ?>
                <a targett="_blank" href="<?php the_field('link'); ?>">
                    <?php the_post_thumbnail('full', array('class' => 'academy-studio__image')); ?>
                </a>
            <?php
            else:
                the_post_thumbnail('full', array('class' => 'academy-studio__image'));
            endif;
            ?>

        </div>
    </div>

    <div class="col col--two col--padding">
        <p class="academy-studio__category" style="color: <?php the_field('color'); ?>"><?php the_field('category'); ?></p>
        <h1 class="academy-studio__title"><?php the_title(); ?></h1>

        <div class="academy-studio__info">
            <p class="icon icon-date-2" style="color: <?php the_field('color'); ?>"><span><?php the_field('date'); ?></span></p>
            <p class="icon icon-tempo" style="color: <?php the_field('color'); ?>"><span><?php the_field('hour'); ?></span></p>
            <?php if (get_field('duration')) : ?>
                <p class="icon icon-duracao-1" style="color: <?php the_field('color'); ?>"><span><?php the_field('duration'); ?></span></p>
            <?php endif; ?>
            <p class="icon icon-custo-2" style="color: <?php the_field('color'); ?>"><span><?php the_field('price'); ?> €</span></p>
        </div>


        <h2 class="academy-studio__description"><?php echo the_content() ?></h2>

        <?php if (get_field('link')) : ?>
            <?php if (ICL_LANGUAGE_CODE == 'en') : ?>
                <a class="academy-studio__link" target="_blank" href="<?php the_field('link'); ?>" targett="_blank" style="background-color: <?php the_field('color'); ?>; border: 1px solid <?php the_field('color'); ?>;"><?php esc_html_e('Buy', 'timeout'); ?></a>
            <?php else: ?>
                <a class="academy-studio__link" target="_blank" href="<?php the_field('link'); ?>" targett="_blank" style="background-color: <?php the_field('color'); ?>; border: 1px solid <?php the_field('color'); ?>;"><?php esc_html_e('Comprar', 'timeout'); ?></a>

            <?php endif; ?>
        <?php endif; ?>



    </div>	

</article><!-- #post-## -->
