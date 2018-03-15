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
					<h2 class="eat-and-shop-archive-header__subtitle">Tasted and tested</h2>
					<h1 class="eat-and-shop-archive-header__title">Restaurants, bars & shops</h1>
					<p class="eat-and-shop-archive-header__description">Have you ever heard of curated burgers? Curated nigiri? Curated pizzas, sandwiches or even curated cod? Probably not. After all, Time Out Market is the first market in the world where everything has been chosen, tasted and tested (with four or five stars, and not one star less) by an independent panel of city experts: Time Out’s own journalists and critics. More than 40 spaces with the leading representatives in all the food categories that help make Lisbon what it is - and tastes - all together under one roof. Find out everything you need to taste - and what Time Out had to say about it.</p>
					<?php else: ?>
					<h2 class="eat-and-shop-archive-header__subtitle">Provado e Aprovado</h2>
					<h1 class="eat-and-shop-archive-header__title">Restaurantes, bares e lojas </h1>
					<p class="eat-and-shop-archive-header__description">Já alguma vez ouviu falar em curadoria de hambúrgueres, nigiri, pizzas, bifes, pregos, bacalhau -   à brás e não só? É natural. Afinal de contas, o Time Out Market de Lisboa foi o primeiro mercado do mundo onde tudo foi escolhido, provado e aprovado (com 4 ou 5 estrelas, e nem uma estrela menos) por um painel independente de especialistas na cidade: os críticos e os jornalistas da Time Out. Mais de 40 espaços com todas as categorias gastronómicas que dão vida a Lisboa. Tudo debaixo do mesmo tecto. Veja aqui tudo o que há para provar (e aprovar) no mercado, e o que disse a Time Out sobre o assunto.</p>
					<?php endif; ?>
				</div>
				<canvas id="canvas" width="1920" height="904" style="background-color:#000000;width:87%;margin:0 auto;"></canvas>
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
