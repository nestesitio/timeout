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
				<div class="col col--two col--padding">
					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					<h1 class="academy-studio-archive__logo academy-studio-archive__logo--studio">Timeout Studio</h1>
					<!-- <h1 class="home-module__title">The Best of lisbon</h1> -->
					<p class="academy-studio-archive__info"></p>
					<h2 class="academy-studio-archive__description"></h2>
					
					<!-- <p class="studio-info">Bilhetes e informação:</p>
					<p class="studio-info">Espaço Time Out Piso 0 Mercado da Ribeira | <a href="mailto:reservas@academiatimeout.pt">reservas@academiatimeout.pt</a> | 213470391</p> -->
					<?php else: ?>
					<h1 class="academy-studio-archive__logo academy-studio-archive__logo--studio">Estúdio Timeout</h1>
					<!-- <h1 class="home-module__title">O melhor de Lisboa, agora em palco</h1> -->
					<p class="academy-studio-archive__info"></p>
					<h2 class="academy-studio-archive__description"></h2>
					
<!-- 		
					<p class="studio-info">Bilhetes e informação:</p>
					<p class="studio-info">Espaço Time Out Piso 0 Mercado da Ribeira | <a href="mailto:reservas@academiatimeout.pt">reservas@academiatimeout.pt</a> | 213470391</p>
 -->
					<?php endif; ?>
					
				</div>
				<div class="col col--two">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/imagemestudio1.jpg" alt="Academia Timeout">
					<img class="img-responsive img-collapse" src="<?php echo get_template_directory_uri(); ?>/img/imagemestudio2.jpg" alt="Academia Timeout">
				</div>
				<!-- <div class="col col--two">
					<div class="col--two studio-float padding-studio">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
							<h2 class="studio-archive-subtitle">March 17</h2>
							<h1 class="studio-archive-title">TIAGO BETTENCOURT</h1>
							<p class="studio-archive-text">Casa lotada e esgotada para ouvir o Tiago Bettencourt e ajudar a Associação Cais no Festival Mais Música Mais Ajuda.</p>
						<?php else: ?>
							<h2 class="studio-archive-subtitle">17 Março de 2016</h2>
							<h1 class="studio-archive-title">TIAGO BETTENCOURT</h1>
							<p class="studio-archive-text">Casa lotada e esgotada para ouvir o Tiago Bettencourt e ajudar a Associação Cais no Festival Mais Música Mais Ajuda.</p>
						<?php endif; ?>
				</div>
				<div class="col--two studio-float">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/temp/palco.jpg" alt="Studio Timeout">
				</div>
				</div> -->
				<!-- <div class="col col--two">

					<div class="col--two studio-float">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/temp/blasted.jpg" alt="Studio Timeout">
				</div><div class="col--two studio-float padding-studio">
					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<h2 class="studio-archive-subtitle">February 26</h2>
						<h1 class="studio-archive-title">BLASTED MECHANISM</h1>
						<p class="studio-archive-text">O Estúdio Time Out recebeu os Blasted Mechanism | Tributo a David Bowie, naquele que foi o segundo concerto em Lisboa do Festival solidário Mais Música, Mais Ajuda. </p>

					<?php else: ?>

						<h2 class="studio-archive-subtitle">26 Fevereiro de 2016</h2>
						<h1 class="studio-archive-title">BLASTED MECHANISM</h1>
						<p class="studio-archive-text">O Estúdio Time Out recebeu os Blasted Mechanism | Tributo a David Bowie, naquele que foi o segundo concerto em Lisboa do Festival solidário Mais Música, Mais Ajuda. </p>
					<?php endif; ?>
				</div>
					
				</div>
				<div class="col col--two">
						<div class="col--two studio-float">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/temp/musico.jpg" alt="Studio Timeout">
				</div><div class="col--two studio-float padding-studio">
					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<h2 class="studio-archive-subtitle">March 2</h2>
						<h1 class="studio-archive-title">CÍCERO</h1>
						<p class="studio-archive-text"> No final do inverno português, o carioca Cícero trouxe "A Praia" ao Estúdio Time Out. Imperdível e arrebatador!</p>
					<?php else: ?>
						<h2 class="studio-archive-subtitle">2 Março de 2016</h2>
						<h1 class="studio-archive-title">CÍCERO</h1>
						<p class="studio-archive-text"> No final do inverno português, o carioca Cícero trouxe "A Praia" ao Estúdio Time Out. Imperdível e arrebatador!</p>
					<?php endif; ?>	
				</div>
					
				</div> -->
			</header><!-- .page-header -->

			<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					
							<header class="home-module__header add-2">
								<h1 class="home-module__title">The best of Lisbon</h1>
								<p class="home-module__subtitle">Time out Market</p>
							</header>
							
					
						<?php else: ?>
					
							<header class="home-module__header add-2">
								<h1 class="home-module__title">Este mês no mercado</h1>
								<p class="home-module__subtitle">Time out Market</p>
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
