<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */
if (ICL_LANGUAGE_CODE == 'en') :
    get_header('comeren');
else:
    get_header('comerpt');
endif;

global $query_string;
query_posts($query_string . '&posts_per_page=-1&meta_key=space-number&orderby=meta_value_num&order=ASC');

$slug = (ICL_LANGUAGE_CODE == 'en') ? 'comer-e-beber-en' : 'comer-e-beber-pt';
$post = get_page_by_path($slug);
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if (have_posts()) : ?>

            <header class="page-header eat-and-shop-archive-header">
                <div class="eat-and-shop-archive-header__info">
                    <h2 class="eat-and-shop-archive-header__subtitle"><?php echo get_field('header', $post->ID) ?></h2>
                    <h1 class="eat-and-shop-archive-header__title"><?php echo $post->post_title ?></h1>
                    <p class="eat-and-shop-archive-header__description"><?php echo $post->post_content ?></p>

                </div>
                <div id="canvas-container">
                    <canvas id="canvas" width="1920" height="904" style="display: none; background-color:rgba(0, 0, 0, 1.00);margin:0 auto;width:87%;height:auto;"></canvas>
                    <div id='_preload_div_' style='display: inline-block; height:904px; width: 97%; vertical-align:middle;position:absolute;text-align: center;margin:0 auto;'>
                        <span style='display: inline-block; height: 100%; vertical-align: middle;'></span>	
                        <img src="<?php echo get_template_directory_uri(); ?>/images/_preloader.gif" style='vertical-align: middle; max-height: 100%'/></div>
                </div>

                <div class="eat-and-shop-archive-header__filters">
                    <button class="eat-and-shop-archive-header__filter" data-list-type="eat"><?php echo (ICL_LANGUAGE_CODE == 'en') ? 'Eat' : 'Comer'; ?></button>
                    <button class="eat-and-shop-archive-header__filter" data-list-type="drink"><?php echo (ICL_LANGUAGE_CODE == 'en') ? 'Drink' : 'Beber'; ?></button>
                    <button class="eat-and-shop-archive-header__filter" data-list-type="shop"><?php echo (ICL_LANGUAGE_CODE == 'en') ? 'Shop' : 'Comprar'; ?></button>
                </div>
            </header><!-- .page-header -->

            <?php
            /* Start the Loop */
            while (have_posts()) : the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part('template-parts/content', 'archive-comer-e-beber');

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
