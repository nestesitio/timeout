<?php
/**
 * The template for displaying Conceito.
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
			<!-- <article id="post-<?php the_ID(); ?>" class="contact-video" data-type="<?php the_field('category'); ?>" >
	
	
			<div class="concept__header">
					<iframe width="960" height="315" src="https://www.youtube.com/embed/1_5E1WsSF_s?rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen></iframe>
				<div style="clear: both;"></div>
			</div>

		<div class="clear">
			
			<div class="eat-and-shop-archive__col">
				<h1 class="eat-and-shop-archive__title">lorem ipsum sssaet amet</h1>

		

				<h2 class="eat-and-shop-archive__subtitle">Maecenas luctus ipstum a pulvinar </h2>
			</div>
		</div>
	
	</article><article id="post-<?php the_ID(); ?>" class="contact-video" data-type="<?php the_field('category'); ?>" >
	
	
			<div class="concept__header">
					<iframe width="960" height="315" src="https://www.youtube.com/embed/1_5E1WsSF_s?rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen></iframe>
					<div style="clear: both;"></div>
				</div>

		<div class="clear">
			
			<div class="eat-and-shop-archive__col">
				<h1 class="eat-and-shop-archive__title">lorem ipsum set amet</h1>

		

				<h2 class="eat-and-shop-archive__subtitle">Maecenas luctus ipstum a pulvinar </h2>
			</div>
		</div>
	
</article><article id="post-<?php the_ID(); ?>" class="contact-video" data-type="<?php the_field('category'); ?>" >
	
	
			<div class="concept__header">
					<iframe width="960" height="315" src="https://www.youtube.com/embed/1_5E1WsSF_s?rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen></iframe>
					<div style="clear: both;"></div>
				</div>

		<div class="clear">
			
			<div class="eat-and-shop-archive__col">
				<h1 class="eat-and-shop-archive__title">lorem ipsum set amet</h1>

		

				<h2 class="eat-and-shop-archive__subtitle">Maecenas luctus ipstum a pulvinar </h2>
			</div>
		</div>
	
</article><article id="post-<?php the_ID(); ?>" class="contact-video" data-type="<?php the_field('category'); ?>" >
	
	
			<div class="concept__header">
					<iframe width="960" height="315" src="https://www.youtube.com/embed/1_5E1WsSF_s?rel=0&amp;controls=1&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen></iframe>
					<div style="clear: both;"></div>
				</div>

		<div class="clear">
			
			<div class="eat-and-shop-archive__col">
				<h1 class="eat-and-shop-archive__title">lorem ipsum set amet</h1>

		

				<h2 class="eat-and-shop-archive__subtitle">Maecenas luctus ipstum a pulvinar </h2>
			</div>
		</div>
	
</article> --><!-- #post-## -->

			
			<div class="clear">
				<header class="home-module__header map-header">
					<h1 class="home-module__title title-map">Mapa</h1>
					<p class="home-module__subtitle">Como chegar ao mercado</p>
								
				</header>
			</div>
			<?php
			while ( have_posts() ) : the_post();
			?>

			<div id="post-<?php the_ID(); ?>" <?php post_class('contacts'); ?>>
				
				<div id="contacts__map"></div>

			</div><!-- #post-## -->

			<?php
			endwhile; // End of the loop.
			?>
		<!-- 	<div class="col-60">
					<header class="home-module__header">
								<h1 class="home-module__title">Contacts</h1>
							</header>
			

				<div class="inner-col-60-1">
					<div class="space-1">
						1
					</div>
					<div class="space-2">
						2
					</div>
				</div>
				<div class="inner-col-60-2">
					<div class="space-3">
						3
					</div>
					<div class="space-4">
						4
					</div>
				</div>
				<div class="inner-col-60-3">
					<div class="space-5">
						5
					</div>
					
				</div>
			</div> -->
			<div class="transport-img" style="width:50%;margin: 0 auto;margin-bottom: 25px;">
				<img src="<?php echo get_template_directory_uri(); ?>/img/transport.jpg" usemap="#m_usaMap" />
				<map name="m_usaMap">
					<area target="_blank" title="Bus" href="http://carris.transporteslisboa.pt/pt/carreiras/" coords="336,298,416,490" shape="rect">
					<area target="_blank" title="Metro" href="http://metro.transporteslisboa.pt/" coords="495,298,592,490" shape="rect">
					<area target="_blank" title="Train" href="https://www.cp.pt/passageiros/pt" coords="681,298,784,490" shape="rect">
					<area target="_blank" title="Ferry" href="http://transtejo.transporteslisboa.pt/" coords="850,298,987,490" shape="rect">
					<area target="_blank" title="Bus" href="https://www.aerobus.pt/pt-PT/Pagina-Inicial.aspx" coords="1054,298,1160,490" shape="rect">
					<!-- <area target="_blank" title="Taxi" href="" coords="1218,298,1316,490" shape="rect"> -->
					<area target="_blank" title="Car Parking" href="https://www.aerobus.pt/en-GB/Home-2.aspx" coords="1356,298,1482,490" shape="rect">
				</map>
			</div>
			<div class="clear academia-parent">
		
				

				<article class="col col--two footer-module">
					<article class="home-module home-module--special scroll">
						<?php if(ICL_LANGUAGE_CODE=='en') : ?>
						
							
							<div class="home-module__image-wrapper">
								<img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/temp/contact-newsletter.jpg" alt="Newsletter">
							</div>
							
					
						<?php else: ?>
						
							
							<div class="home-module__image-wrapper">
							
								<img class="home-module__image img-map" src="<?php echo get_template_directory_uri(); ?>/img/temp/contact-newsletter.jpg" alt="Newsletter">
							</div>
							
					
						<?php endif; ?>
					</article>
					
					
				</article>


				<div class="col col--two footer-module academia-child">
					

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
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
?>

