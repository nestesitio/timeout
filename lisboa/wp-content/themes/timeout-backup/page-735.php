<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */
get_header();
?>



<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        $slug = (ICL_LANGUAGE_CODE == 'en') ? 'agenda-en' : 'agenda-pt';
        $post = get_page_by_path($slug);
        /* Simple way to get current month name */

        if (ICL_LANGUAGE_CODE == 'en'):
            $mons = [1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "Dezcember"];
        else:
            $mons = [1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro"];
        endif;


        $date = getdate();
        $month = $date['mon'];

        $month_name = $mons[$month];
        ?>

        <?php if (have_posts()) : ?>
            <header class="page-header academy-studio-archive">
                <div class="col col--two col--padding">


                    <h1 class="agenda-title"><?php echo $post->post_title ?></h1>
                    <h2 class="agenda-subtitle"><?php echo $month_name; ?> <?php echo date("Y"); ?></h2>
                    <p class="academy-studio-archive__info"><?php echo get_field('header', $post->ID) ?></p> 
                    <h2 class="academy-studio-archive__description"><?php echo $post->post_content ?></h2>


                </div>
                <div class="col col--two">
                    <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($post); ?>" alt="<?php echo $post->post_title; ?>">
                </div>


            </header>


            <header class="home-module__header add-2">
                <h1 class="home-module__title"><?php echo get_field('list-header', $post->ID) ?></h1>
                <p class="home-module__subtitle"><?php echo get_field('list-title', $post->ID) ?></p>
            </header>




            <?php
            $args = ['post_type' => array('estudio', 'academia'),
                'meta_key' => 'date',
                'orderby' => 'date',
                'order' => 'ASC'
            ];
            query_posts($args);
            /* Start the Loop */
            while (have_posts()) : the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part('template-parts/content', 'archive-academy-studio');

            endwhile;

//the_posts_navigation();

        else :

            get_template_part('template-parts/content', 'none');

        endif;
        ?>


    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
