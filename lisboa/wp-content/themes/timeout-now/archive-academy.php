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
query_posts( $query_string . '&posts_per_page=-1&meta_key=date&orderby=meta_value_num&order=ASC' );

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		<?php
		if ( have_posts() ) : ?>

			<header class="page-header academy-studio-archive">
				<div style="float:right;" class="col col--two">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/academia-timeout-2.jpg" alt="Academia Timeout">
					<img class="img-responsive img-collapse" src="<?php echo get_template_directory_uri(); ?>/img/academia-timeout-3.jpg" alt="Academia Timeout">
				</div>
				<div style="float:right;" class="col col--two col--padding ">
					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					<h1 class="academy-studio-archive__logo">Timeout Academy</h1>
					<h2 class="academy-studio-archive__description">The first cookery academy to operate inside a food hall, the Time Out Academy is a place to learn, perfect and share your love of food. From “I can't even fry an egg” to “I'm on course for a Michelin star” workshops, to lunches and  dinners with live cooking and programmes for kids, there’s a bit of everything for everyone - including classes for those who  prefer to take home a tastier - to say the least - souvenir than a painted Barcelos cockerel.</h2>
					<p class="academy-studio-archive__info">The academy is run by foodie Rodrigo Meneses and his team.</p>

					<?php else: ?>
					<h1 class="academy-studio-archive__logo">Academia Timeout</h1>
					<h2 class="academy-studio-archive__description">A primeira escola de cozinha a funcionar dentro de um food hall é um espaço para aprender, aperfeiçoar e partilhar o amor pela comida.  Desde “não sei estrelar nem um ovo” ao “sou um Chef estrela Michelin”, há workshops para todos. E depois ainda há almoços e jantares com  live cooking, programas para miúdos e cursos para turistas - uma recordação mais saborosa - no mímino - que um galo de Barcelos.</h2>
					<p class="academy-studio-archive__info">A Academia é conduzida pelo foodie Rodrigo Meneses e a sua equipa.</p>

					<?php endif; ?>
					
				</div>
				
				
			</header><!-- .page-header -->
			<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					
							<header class="home-module__header add-2">
								<h1 class="home-module__title">This month in the market</h1>
								<p class="home-module__subtitle">Schedule</p>
							</header>
							
					
						<?php else: ?>
					
							<header class="home-module__header add-2">
								<h1 class="home-module__title">Este mês no mercado</h1>
								<p class="home-module__subtitle">Programação</p>
							</header>
						
						
						<?php endif; ?>

			
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'archive-academy-studio' );

			endwhile;

			//the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
