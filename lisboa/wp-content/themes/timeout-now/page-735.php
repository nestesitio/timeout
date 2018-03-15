<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

get_header(); ?>



	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			$args = array(

				'post_type' => array( 'estudio', 'academia' ),
				'meta_key'	=> 'date',
				'orderby'	=> 'date',
				'order'		=> 'ASC'
			);
			query_posts($args);

			?>

		<?php
		if ( have_posts() ) : ?>
			<header class="page-header academy-studio-archive">
				<div class="col col--two col--padding">
					<?php if(ICL_LANGUAGE_CODE=='en') : ?>

						
					<h1 class="agenda-title">Calendar</h1>
					<h2 class="agenda-subtitle"><?php echo $month_name; ?> <?php echo date("Y"); ?></h2>
					<p class="academy-studio-archive__info">Everything that's on at the Market</p> 
					<h2 class="academy-studio-archive__description">In the Market's 10,000 square metres there is always something going on - a lot more than food and drink. Here you can keep up with all the concerts and other events that are on at the Time Out Studio, with the cookery courses at the Time Out Academy and everything that happens in the food hall.</h2>
					<?php else: ?>
					<?php

						/* Simple way to get current month name */

						$mons = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");

						$date = getdate();
						$month = $date['mon'];

						$month_name = $mons[$month];

		

						?>
					<h1 class="agenda-title">Agenda</h1>
					<h2 class="agenda-subtitle"><?php echo $month_name; ?>  <?php echo date("Y"); ?></h2>
					<p class="academy-studio-archive__info">Tudo o que passa no Mercado</p>
					<h2 class="academy-studio-archive__description">Em dez mil metros quadrados de Mercado há sempre muita coisa a acontecer. Muito mais do que comida e bebida. Aqui pode ficar a par de todos os concertos e eventos que acontecem no Estúdio Time Out, dos cursos de cozinha da Academia Time Out e de tudo o que passa no food hall.</h2>
					
					<?php endif; ?>
					
				</div>
				<div class="col col--two">
					<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/agenda_TOM.jpg" alt="Academia Timeout">
				</div>
				
				
			</header>

					
							<header class="home-module__header add-2">
								<h1 class="home-module__title">Este mês no mercado</h1>
								<p class="home-module__subtitle">Programação</p>
							</header>
						
						
			

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
