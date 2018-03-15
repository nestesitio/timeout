<?php 
$slug = get_post()->post_name;
if ($slug == 'eatdrink' || $slug == 'comer-beber'):
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
    <div class="home-module__image-wrapper">
        <img class="home-module__image" src="<?php echo get_the_post_thumbnail_url($post); ?>" alt="<?php echo get_post_custom_values('module-title', $post->ID)[0] ?>">
    </div>


</a>


