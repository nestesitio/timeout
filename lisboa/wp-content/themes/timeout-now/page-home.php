<?php /* Template Name: Home */ ?>
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
								<h1 class="home-module__title"><?php the_field('subtitulo_1_en'); ?></h1>
								<p class="home-module__subtitle"><?php the_field('titulo_1_en'); ?></p>
							</header>
							<div class="home-module__image-wrapper add-1">
								<img class="home-module__image" src="<?php the_field('imagem_1_en'); ?>" alt="O melhor de lisboa">
							</div>
							
						</a>
						<?php else: ?>
						<a href="<?php echo get_permalink(85); ?>">
							<header class="home-module__header add-2">
								<h1 class="home-module__title"><?php the_field('subtitulo_1'); ?></h1>
								<p class="home-module__subtitle"><?php the_field('titulo_1'); ?></p>
							</header>
							<div class="home-module__image-wrapper add-1">
						
								<img class="home-module__image" src="<?php the_field('imagem_1'); ?>" alt="O melhor de lisboa">
							</div>
							
						</a>
						<?php endif; ?>
					</article>
					<article class="home-module home-module--special scroll ">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						<a href="<?php echo get_permalink(738); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title"><?php the_field('subtitulo_2_en'); ?></h1>
								<p class="home-module__subtitle"><?php the_field('titulo_2_en'); ?></p>
								
							</header>
							<div class="home-module__image-wrapper add-3">
								<img class="home-module__image" src="<?php the_field('imagem_2_en'); ?>" alt="Timeout Studio">
							</div>
							
						</a> 
						<?php else: ?>
					<a href="<?php echo get_permalink(735); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title"><?php the_field('subtitulo_2'); ?><</h1>
								<p class="home-module__subtitle"><?php the_field('titulo_2'); ?></p>
								
							</header>
							<div class="home-module__image-wrapper add-3">
							
								<img class="home-module__image" src="<?php the_field('imagem_2'); ?>" alt="Studio Timeout">
							</div>
							
						</a> 
						<?php endif; ?>
					</article>
				</div>

				<article class="col col--two home-module scroll eatshop">

					<?php if(ICL_LANGUAGE_CODE=='en') : ?>
					<a href="<?php echo get_post_type_archive_link( 'comer-e-beber' ); ?>">
						<header class="home-module__header">
							<h1 class="home-module__title"><?php the_field('subtitulo_3_en'); ?></h1>
							<p class="home-module__subtitle"><?php the_field('titulo_3_en'); ?></p>
						</header>
						<div class="home-module__col">
							<div class="home-module__image-wrapper">
							
								<img class="home-module__image home-desktop-img" src="<?php the_field('imagem_3_en'); ?>" alt="Comer e beber no mercado Timeout em Lisboa">
								<img class="home-module__image home-mobile-img" src="<?php the_field('imagem_3_mobile_en'); ?>" alt="Comer e beber no mercado Timeout em Lisboa">
							</div>
						</div>
						<div class="home-module__col  header-fix">
							<h2 class="home-module__subtitle home-module__subtitle--smaller"><?php the_field('titulo_texto_3_en'); ?></h2>
							<p class="home-module__description"><?php the_field('texto_3_en'); ?></p>
						</div>
						
					</a>
					<?php else: ?>
					<a href="<?php echo get_post_type_archive_link( 'comer-e-beber' ); ?>">
						<header class="home-module__header">
							<h1 class="home-module__title"><?php the_field('subtitulo_3'); ?></h1>
							<p class="home-module__subtitle"><?php the_field('titulo_3'); ?></p>
						</header>
						<div class="home-module__col">
							<div class="home-module__image-wrapper">

								<img class="home-module__image home-desktop-img" src="<?php the_field('imagem_3'); ?>" alt="Comer e beber no mercado Timeout em Lisboa">
								<img class="home-module__image home-mobile-img" src="<?php the_field('imagem_3_mobile'); ?>" alt="Comer e beber no mercado Timeout em Lisboa">
							</div>
						</div>
						<div class="home-module__col  header-fix">
							<h2 class="home-module__subtitle home-module__subtitle--smaller"><?php the_field('titulo_texto_3'); ?></h2>
							<p class="home-module__description"><?php the_field('texto_3'); ?></p>
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
							
							
						
						<?php else: ?>
						<a href="<?php echo get_post_type_archive_link( 'estudio' ); ?>">
							<header class="home-module__header">
								<h1 class="home-module__title">Eventos & Concertos</h1>
								<p class="home-module__subtitle">Estúdio Time Out</p>
							</header>

							<?php endif; ?>
							<div class="home-module__image-wrapper">
								<?php
					$args = array(

				'post_type' 		=> 'estudio',
				'meta_key'	=> 'date',
				'orderby'	=> 'date',
				'order'		=> 'ASC',
				'posts_per_page' 	=> '1'
			);
					$myposts = new WP_Query( $args );
					while($myposts->have_posts()) : $myposts->the_post();

						get_template_part( 'template-parts/content', 'archive-studio-home' );

					endwhile; wp_reset_postdata();
					?>
							</div>
							
						</a>
						
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
					<article class="home-module scroll newsletter-module">
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
