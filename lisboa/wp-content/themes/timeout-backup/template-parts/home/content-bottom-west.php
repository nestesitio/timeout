<?php
$query = new WP_Query(['post_type' => 'page',
    'meta_key' => 'home-zone', 'meta_value' => $zone]);
if ($query->have_posts()) :
    while ($query->have_posts()) :
        $query->the_post();
        $post = get_post();
        $slug = $post->post_name;
        $category = get_field('category', $post->ID);
        $shorcid = (ICL_LANGUAGE_CODE == 'en') ? 764 : 761;
        $shortit = (ICL_LANGUAGE_CODE == 'en') ? 'EN' : 'PT';

        if ($category == 'newsletter-form'):
            ?>
            <header class="home-module__header">
                <h1 class="home-module__title"><?php echo get_field('header', $post->ID) ?></h1>
                <p class="home-module__subtitle"><?php echo $post->post_title ?></p>
            </header> 
            <div class="TTWForm-container">
                <?php echo do_shortcode('[contact-form-7 id="764" title="Newsletter EN" html_class="TTWForm"]'); ?>
            </div>
        <?php else: ?>       
            <a href="<?php echo get_permalink(539); ?>">
                <header class="home-module__header">
                    <h1 class="home-module__title"><?php echo get_field('header', $post->ID) ?></h1>
                    <p class="home-module__subtitle"><?php echo $title ?></p>
                </header>
                <div class="home-module__image-wrapper">
                    <img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/temp/mapa.jpg" alt="Map Timeout">
                </div>

            </a>
        <?php
        endif;

    endwhile;

endif;

