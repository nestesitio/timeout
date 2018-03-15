<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

get_header(); ?>

<?php

global $query_string;
query_posts( $query_string . '&posts_per_page=-1&meta_key=space-number&orderby=meta_value_num&order=ASC' );

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header eat-and-shop-archive-header">
				<div class="eat-and-shop-archive-header__info">
					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					<h2 class="eat-and-shop-archive-header__subtitle">Under one roof</h2>
					<h1 class="eat-and-shop-archive-header__title">Restaurants <br>& shops</h1>
					<p class="eat-and-shop-archive-header__description">More than 40 spaces tested and selected by an independent panel of Lisbon experts: the journalists and critics from Time Out Lisboa. From sushi to hamburgers, from traditional dishes to desserts, the leading representatives in every major food category are all here. All together under one roof.</p>
					<?php else: ?>
					<h2 class="eat-and-shop-archive-header__subtitle">Debaixo do mesmo tecto</h2>
					<h1 class="eat-and-shop-archive-header__title">Restaurantes <br>& lojas</h1>
					<p class="eat-and-shop-archive-header__description">Mais de 40 espaços provados e aprovados por um painel independente de especialistas em Lisboa: os jornalistas e críticos da revista Time Out. Do sushi aos hambúrgueres, da comida tradicional às sobremesas, estão cá todas as categorias gastronómicas que dão vida a Lisboa. Tudo debaixo do mesmo tecto.</p>
					<?php endif; ?>
				</div>
				<img class="eat-and-shop-archive-header__image" src="<?php echo get_template_directory_uri(); ?>/img/temp/mapagrande.jpg" alt="Mapa Mercado Timeout">
				<div class="eat-and-shop-archive-header__filters">
					<button class="eat-and-shop-archive-header__filter">Eat</button>
					<button class="eat-and-shop-archive-header__filter">Drink</button>
					<button class="eat-and-shop-archive-header__filter">Shop</button>
				</div>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'archive-eat-and-shop' );

			endwhile;

			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
