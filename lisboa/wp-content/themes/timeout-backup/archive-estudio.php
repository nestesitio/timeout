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

<?php
global $query_string;
query_posts($query_string . '&posts_per_page=-1&meta_key=date&orderby=meta_value_num&order=ASC');
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if (have_posts()) : ?>

            <header class="page-header academy-studio-archive">
                <?php
                $slug = (ICL_LANGUAGE_CODE == 'en') ? 'estudio-en-time-out' : 'estudio-pt-time-out';
                $post = get_page_by_path($slug);
                $src = wp_get_attachment_url(get_field('logo', $post->ID));
                ?>
                <div class="col col--two col--padding">
                    <h1 class="academy-studio-archive__logo" style="background-image: url('<?php echo $src?>')"><?php echo $post->post_title ?></h1>
                    <!-- <h1 class="home-module__title">The Best of lisbon</h1> -->
                    <p class="academy-studio-archive__info"></p>
                    <h2 class="academy-studio-archive__description">
                        <?php echo $post->post_content ?>
                    </h2>
                    <br />
                    <p class="studio-info"><?php echo get_field('more-info', $post->ID) ?></p>
                    <?php
                    $arr = ['info-local', 'info-email', 'info-tel'];
                    $infos = [];
                    foreach ($arr as $key) {
                        $value = get_field($key, $post->ID);
                        if (null != $value) {
                            if ($key == 'info-email') {
                                $value = '<a href="mailto:' . $value . '">' . $value . '</a>';
                            }
                            $infos[$key] = $value;
                        }
                    }
                    ?>
                    <p class="studio-info"><?php echo implode(' | ', $infos); ?></p> 


                </div>
                <div class="col col--two">
                    <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url($post); ?>" alt="<?php echo $post->post_title; ?>">
                </div>

            </header><!-- .page-header -->

            <header class="home-module__header add-2">
                <h1 class="home-module__title"><?php echo get_field('list-header', $post->ID) ?></h1>
                <p class="home-module__subtitle"><?php echo get_field('list-title', $post->ID) ?></p>
            </header>

            <?php
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
