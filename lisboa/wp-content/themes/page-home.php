<?php
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

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();
			?>

			<div id="post-<?php the_ID(); ?>" <?php post_class('home'); ?>>

			</div><!-- #post-## -->

			<div class="home-slideshow">

				<?php
				endwhile; // End of the loop.
				?>

				<?php
				$args = array(
					'post_type' => 'highlights',
					'posts_per_page' => '5'
				);
				$myposts = new WP_Query( $args );
				while($myposts->have_posts()) : $myposts->the_post();
				?>
					
				
				<a class="home-slideshow__slider" href="<?php the_permalink(); ?>" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>);">
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
				while($myposts->have_posts()) : $myposts->the_post();
				?>
				
					<div class="home-slideshow__control">
						<div class="home-slideshow__control-span"></div>
					</div>

				<?php
				endwhile; wp_reset_postdata();
				?>

				 </div>

			</div>

			<div class="clear middle">
			
				<div class="col col--two">
					<article class="home-module scroll">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<a href="<?php echo get_permalink(266); ?>">
							<header class="home-module__header add-2">
								<h1 class="home-module__title">Who we are</h1>
								<p class="home-module__subtitle">Time out Market</p>
							</header>
							<div class="home-module__image-wrapper add-1">
								<img class="home-module__image" src="<?php echo get_template_directory_uri(); ?>/img/temp/conceito.jpg" alt="O melhor de lisboa">
							</div>
							
						</a>
						<?php else: ?>
						<a href="<?php echo get_permalink(85); ?>">
							<header class="home-module__header add-2">
								<h1 class="home-module__title">Quem somos</h1>
								<p class="home-module__subtitle">Time out Market</p>
							</header>
							<div class="home-module__image-wrapper add-1">
						
								<img class="home-module__image" src="<?php echo get_template_directory_uri(); ?>/img/temp/conceito.jpg" alt="O melhor de lisboa">
							</div>
							
						</a>
						<?php endif; ?>
					</article>
					<article class="home-module home-module--special scroll ">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<a href="<?php echo get_permalink(738); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">This Month</h1>
								<p class="home-module__subtitle">Calendar</p>
								
							</header>
							<div class="home-module__image-wrapper add-3">
								<img class="home-module__image" src="<?php echo get_template_directory_uri(); ?>/img/temp/studio.jpg" alt="Timeout Studio">
							</div>
							
						</a> 
						<?php else: ?>
					<a href="<?php echo get_permalink(735); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">A não perder</h1>
								<p class="home-module__subtitle">Agenda</p>
								
							</header>
							<div class="home-module__image-wrapper add-3">
							
								<img class="home-module__image" src="<?php echo get_template_directory_uri(); ?>/img/temp/studio.jpg" alt="Studio Timeout">
							</div>
							
						</a> 
						<?php endif; ?>
					</article>
				</div>

				<article class="col col--two home-module scroll eatshop">

					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					<a href="<?php echo get_post_type_archive_link( 'comer-e-beber' ); ?>">
						<header class="home-module__header">
							<h1 class="home-module__title">Meet our vendors</h1>
							<p class="home-module__subtitle">Eat&Drink</p>
						</header>
						<div class="home-module__col">
							<div class="home-module__image-wrapper">
							
								<img class="home-module__image home-desktop-img" src="<?php echo get_template_directory_uri(); ?>/img/temp/comer-e-beber.jpg" alt="Comer e beber no mercado Timeout em Lisboa">
								<img class="home-module__image home-mobile-img" src="<?php echo get_template_directory_uri(); ?>/img/comer_mobile.jpg" alt="Comer e beber no mercado Timeout em Lisboa">
							</div>
						</div>
						<div class="home-module__col  header-fix">
							<h2 class="home-module__subtitle home-module__subtitle--smaller">Tasted <br>and tested</h2>
							<p class="home-module__description">Have you ever heard of curated burgers? Curated nigiri? Curated pizzas, sandwiches or even curated cod? Probably not. After all, Time Out Market is the first market in the world where everything has been chosen...</p>
						</div>
						
					</a>
					<?php else: ?>
					<a href="<?php echo get_post_type_archive_link( 'comer-e-beber' ); ?>">
						<header class="home-module__header">
							<h1 class="home-module__title">Conheça as nossas bancas</h1>
							<p class="home-module__subtitle">Comer&Beber</p>
						</header>
						<div class="home-module__col">
							<div class="home-module__image-wrapper">

								<img class="home-module__image home-desktop-img" src="<?php echo get_template_directory_uri(); ?>/img/temp/comer-e-beber.jpg" alt="Comer e beber no mercado Timeout em Lisboa">
								<img class="home-module__image home-mobile-img" src="<?php echo get_template_directory_uri(); ?>/img/comer_mobile.jpg" alt="Comer e beber no mercado Timeout em Lisboa">
							</div>
						</div>
						<div class="home-module__col  header-fix">
							<h2 class="home-module__subtitle home-module__subtitle--smaller">Provado e <br>Aprovado</h2>
							<p class="home-module__description">Já alguma vez ouviu falar em curadoria de hambúrgueres, nigiri, pizzas, bifes, pregos, bacalhau -  à brás e não só? É natural. Afinal de contas, o Time Out Market de Lisboa foi o primeiro mercado do mundo onde…</p>
							<h1 class="home-module__title"><br></h1>
						</div>
						
					</a>
					<?php endif; ?>
				</article>
			</div>

			<article class="home-module scroll">
				<a href="<?php echo get_post_type_archive_link( 'academia' ); ?>">
				<?php if(ICL_LANGUAGE_CODE=='en') : ?>
				
				<header class="home-module__header">
					<h1 class="home-module__title">Workshops & Masterclasses</h1>
					<p class="home-module__subtitle">Time Out Academy</p>
				</header>
				
				<?php else: ?>
				<header class="home-module__header">
					<h1 class="home-module__title">Workshops & Masterclasses</h1>
					<p class="home-module__subtitle">Academia Time Out</p>
				</header>
				<?php endif; ?>
				</a>
				

					<?php
					$args = array(

				'post_type' 		=> 'academia',
				'meta_key'	=> 'date',
				'orderby'	=> 'date',
				'order'		=> 'ASC',
				'posts_per_page' 	=> '1'
			);
					
					$myposts = new WP_Query( $args );
					while($myposts->have_posts()) : $myposts->the_post();

						get_template_part( 'template-parts/content', 'archive-academy-studio' );

					endwhile; wp_reset_postdata();
					?>
				</div>
				

			</article>
			<div class="clear">
		
				

				<article class="col col--two footer-module">
					<article class="home-module home-module--special scroll">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<a href="<?php echo get_post_type_archive_link( 'estudio' ); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">Events & Concerts</h1>
								<p class="home-module__subtitle">Studio</p>
							</header>
							<div class="home-module__image-wrapper">
								<img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/estudio_destaque_en.jpg" alt="Map Timeout">
							</div>
							
						</a>
						<?php else: ?>
						<a href="<?php echo get_post_type_archive_link( 'estudio' ); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">Eventos & Concertos</h1>
								<p class="home-module__subtitle">Estúdio Time Out</p>
							</header>
							<div class="home-module__image-wrapper">
							
								<img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/estudio_destaque_pt.jpg" alt="Mapa Timeout">
							</div>
							
						</a>
						<?php endif; ?>
					</article>
					
					
				</article>
				<div class="col col--two footer-module">
					<article class="home-module home-module--special scroll">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<a href="<?php echo get_permalink(539); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">Map & Contacts</h1>
								<p class="home-module__subtitle">How to get there</p>
							</header>
							<div class="home-module__image-wrapper">
								<img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/temp/mapa.jpg" alt="Map Timeout">
							</div>
							
						</a>
						<?php else: ?>
						<a href="<?php echo get_permalink(539); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">Mapa & Contactos</h1>
								<p class="home-module__subtitle">Como chegar</p>
							</header>
							<div class="home-module__image-wrapper">
							
								<img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/temp/mapa.jpg" alt="Mapa Timeout">
							</div>
							
						</a>
						<?php endif; ?>
					</article>
					<article class="home-module scroll">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					
							<header class="home-module__header">
								<h1 class="home-module__title">News & Offers</h1>
								<p class="home-module__subtitle">Newsletter</p>
							</header>
							<div class="TTWForm-container">
      
      						 <?php echo do_shortcode( '[contact-form-7 id="764" title="Newsletter EN" html_class="TTWForm"]' ); ?>
							    
							</div>
						
						<?php else: ?>
							<header class="home-module__header">
								<h1 class="home-module__title">Novidades & Ofertas</h1>
								<p class="home-module__subtitle">Newsletter</p>
							</header>
							<div class="TTWForm-container">
  
      							      <?php echo do_shortcode( '[contact-form-7 id="761" title="Newsletter PT" html_class="TTWForm"]' ); ?>

							     
							</div>
							
					
						<?php endif; ?>
					</article>
					
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
