<?php
/* Template Name: Home */

/**
 * The template for displaying Homepage.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
        while (have_posts()) : the_post();
            ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class('home'); ?>>

            </div><!-- #post-## -->

            <div class="home-slideshow">

                <?php
            endwhile; // End of the loop.
            ?>

            <?php
            $highlights = new WP_Query(['post_type' => 'highlights', 'posts_per_page' => '10',
                'orderby' => 'menu_order', 'order' => 'ASC']);
            while ($highlights->have_posts()) : $highlights->the_post();
                ?>


                <a class="home-slideshow__slider" href="<?php the_permalink(); ?>" style="background-image: url(<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>);">
                    <article class="home-slideshow__block">
                        <div class="home-slideshow__info">
                            <img class="home-slideshow__logo" src="<?php echo get_template_directory_uri(); ?>/img/timeout-market-lisbon.png" alt="Timeout Market Lisbon">
                            <!-- <h1 class="home-slideshow__title"><?php the_excerpt(); ?></h1> -->
                            <h2 class="home-slideshow__subtitle"><?php the_title(); ?></h2>
                        </div>
                    </article>
                </a>

                <?php
            endwhile;
            ?>

            <div class="home-slideshow__controls">

                <?php
                while ($highlights->have_posts()) : $highlights->the_post();
                    ?>

                    <div class="home-slideshow__control">
                        <div class="home-slideshow__control-span"></div>
                    </div>

                    <?php
                endwhile;
                wp_reset_postdata();
                ?>

            </div>

        </div>

        <div class="clear middle">

            <div class="col col--two">
                <div class="middle-west">
                    <article class="home-module scroll">
                        <?php
                        $query = new WP_Query(['post_type' => 'page',
                            'meta_key' => 'home-zone', 'meta_value' => 'middle-north-west']);
                        if ($query->have_posts()) :
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();
                                $slug = $post->post_name;

                                get_template_part('template-parts/home/content', 'middle-west');

                            endwhile;

                        endif;
                        ?>
                    </article>
                    <article class="home-module home-module--special scroll ">
                        <?php
                        $query = new WP_Query(['post_type' => 'page',
                            'meta_key' => 'home-zone', 'meta_value' => 'middle-south-west']);
                        if ($query->have_posts()) :
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();
                                $slug = $post->post_name;

                                get_template_part('template-parts/home/content', 'middle-west');

                            endwhile;

                        endif;
                        ?>
                    </article>
                </div>
            </div>

            <article class="col col--two home-module scroll eatshop">
                <?php
                $query = new WP_Query(['post_type' => 'page',
                    'meta_key' => 'home-zone', 'meta_value' => 'middle-east']);
                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();
                        $post = get_post();
                        $slug = $post->post_name;

                        get_template_part('template-parts/home/content', 'eatshop');

                    endwhile;

                endif;
                ?>
            </article>
        </div>
            
        <!--ACADEMIA-->
        <article class="home-module scroll">
            <?php
                $query = new WP_Query(['post_type' => 'page',
                    'meta_key' => 'home-zone', 'meta_value' => 'academy']);
                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();
                        $post = get_post();
                        $title = $post->post_title;
                        $header = get_field('header', $post->ID);

                    endwhile;

                endif;
                ?>
            <a href="<?php echo get_post_type_archive_link('academia'); ?>">
                <header class="home-module__header">
                    <h1 class="home-module__title">
                        <?php echo $header ?>
                    </h1>
                    <p class="home-module__subtitle"><?php echo $title ?></p>
                </header>
            </a>


            <?php
            $myposts = new WP_Query(['post_type' => 'academia',
                        'meta_key' => 'highlight', 'meta_value' => 'academy', 'posts_per_page' => '1']);
            if(!$myposts->have_posts()){
                $myposts = new WP_Query(['post_type' => 'academia', 'meta_key' => 'date',
                'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => '1']);
            }


            while ($myposts->have_posts()) : $myposts->the_post();

                get_template_part('template-parts/content', 'archive-academy-studio');

            endwhile;
            wp_reset_postdata();
            ?>
            </div>


        </article>

        
        <div class="clear">
            <?php
                $query = new WP_Query(['post_type' => 'page',
                    'meta_key' => 'home-zone', 'meta_value' => 'studio']);
                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();
                        $post = get_post();
                        $title = $post->post_title;
                        $header = get_field('header', $post->ID);

                    endwhile;

                endif;
                ?>

            <article class="col col--two footer-module">
                <article class="home-module home-module--special scroll">
                    <a href="<?php echo get_post_type_archive_link('estudio'); ?>">
                        <header class="home-module__header">
                            <h1 class="home-module__title"><?php echo $header ?></h1>
                            <p class="home-module__subtitle"><?php echo $title ?></p>
                        </header>


                        <div class="home-module__image-wrapper">
                            <?php
                            $myposts = new WP_Query(['post_type' => 'estudio',
                        'meta_key' => 'highlight', 'meta_value' => 'studio', 'posts_per_page' => '1']);
                            if(!$myposts->have_posts()){
                                $myposts = new WP_Query(['post_type' => 'estudio', 'meta_key' => 'date',
                                    'orderby' => 'date', 'order' => 'ASC', 'posts_per_page' => '1']);
                                
                            }
                            while ($myposts->have_posts()) : $myposts->the_post();

                                get_template_part('template-parts/content', 'archive-studio-home');

                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>

                    </a>

                </article>
            </article>
            
            
            <div class="col col--two footer-module">
                <article class="home-module home-module--special scroll">
                    <?php
                    $zone = 'bottom-north-west';
                    include(locate_template('template-parts/home/content-bottom-west.php'));
                    ?>
                </article>
                
                
                <article class="home-module scroll newsletter-module">
                    <?php
                    $zone = 'bottom-south-west';
                    include(locate_template('template-parts/home/content-bottom-west.php'));
                    ?>
                </article>

            </div>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
