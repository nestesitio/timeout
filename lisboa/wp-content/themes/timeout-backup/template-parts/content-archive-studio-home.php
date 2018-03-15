<?php
/**
 * Template part for displaying page content in archive-academy-studio.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('academy-studio scroll academia-parent'); ?>>

    <div class="col">
        <div class="academy-module event-parent" style="min-height: 100px;">



            <a href="<?php echo get_permalink($post->ID); ?>">



                <?php the_post_thumbnail('full', array('class' => 'academy-studio__image event-class')); ?>
                <div class="event-text-container" style=" position: absolute; bottom: 10px; left: 10px;">
                    <p>
                        <span>
                            <?php the_field('date'); ?>
                        </span>
                    </p>
                    <h1 class="academy-studio__title"><?php the_title(); ?></h1>
                </div>
            </a>


        </div>
    </div>


</article><!-- #post-## -->
