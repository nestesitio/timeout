<?php 
$slug = get_post()->post_name;
if ($slug == 'eatdrink' || $slug == 'comerbeber'):
    $link = get_post_type_archive_link('comer-e-beber');
elseif ($slug == 'time-out-market' || $slug == 'time-out-market-en') :
    $link = (ICL_LANGUAGE_CODE == 'en') ? get_permalink(266) : get_permalink(85);
elseif ($slug == 'agenda-home' || $slug == 'calendar-home') :
    $link = (ICL_LANGUAGE_CODE == 'en') ? get_permalink(738) : get_permalink(735);
endif;
?>
<a href="<?php echo $link; ?>">
    <header class="home-module__header">
        <h1 class="home-module__title"><?php echo get_post_custom_values('header', $post->ID)[0] ?></h1>
        <p class="home-module__subtitle"><?php echo $post->post_title ?></p>
    </header>
    <div class="home-module__col">
        <div class="home-module__image-wrapper">

            <img class="middle-east-image home-module__image home-desktop-img" src="<?php echo get_the_post_thumbnail_url($post); ?>" alt="Comer e beber no mercado Timeout em Lisboa">
            <img class="middle-east-image home-module__image home-mobile-img" src="<?php echo get_the_post_thumbnail_url($post); ?>" alt="Comer e beber no mercado Timeout em Lisboa">
        </div>
    </div>
    <div class="home-module__col  header-fix">
        <h2 class="home-module__subtitle home-module__subtitle--smaller">
            <?php echo get_post_custom_values('text-title', $post->ID)[0] ?>
        </h2>
        <p class="home-module__description"><?php echo get_the_popular_excerpt(220, $post->post_content) ?></p>
    </div>

</a>


