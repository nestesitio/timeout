<?php
/**
 * Template part for displaying page content in archive-academy-studio.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('academy-studio scroll academia-parent'); ?>>

	<div class="col col--two">
		<div class="academy-module">
			  <a href="<?php echo get_permalink( $post->ID ); ?>">
			 	<?php the_post_thumbnail( 'full', array( 'class' => 'academy-studio__image' ) ); ?>
			 </a>

	</div>
	</div>
	<?php if(get_field('link')) : ?>
			 <a class="academy-link" style="text-transform:none;text-decoration:none;" href="<?php echo get_permalink( $post->ID ); ?>">
			 	
			 <?php else:
		
			 endif; ?>
	<div class="col academia-child col--two col--padding">
		<p class="academy-studio__category" style="color: <?php the_field('color'); ?>"><?php the_field('category'); ?></p>
		<h1 class="academy-studio__title"><?php the_title( ); ?></h1>

		<div class="academy-studio__info">
			<p class="icon icon-date-2" style="color: <?php the_field('color'); ?>"><span><?php the_field('date'); ?></span></p>
			<p class="icon icon-tempo" style="color: <?php the_field('color'); ?>"><span><?php the_field('hour'); ?></span></p>
			<?php if(get_field('duration')) : ?>
			<p class="icon icon-duracao-1" style="color: <?php the_field('color'); ?>"><span><?php the_field('duration'); ?></span></p>
			<?php endif; ?>
			<p class="icon icon-custo-2" style="color: <?php the_field('color'); ?>"><span><?php the_field('price'); ?> €</span></p>
		</div>

		<h2 class="academy-studio__description excerptmobile"><?php echo get_the_popular_excerptmobile() ?></h2>
		<h2 class="academy-studio__description excerpt1024"><?php echo get_the_popular_excerpt1024() ?></h2>
		<h2 class="academy-studio__description excerpt1280"><?php echo get_the_popular_excerpt1280() ?></h2>
		<h2 class="academy-studio__description excerpt1366"><?php echo get_the_popular_excerpt1366() ?></h2>
		<h2 class="academy-studio__description excerpt1600"><?php echo get_the_popular_excerpt1600() ?></h2>
		<h2 class="academy-studio__description excerpt1920"><?php echo get_the_popular_excerpt1920() ?></h2>
	
		<?php if(get_field('link')) : ?>
		<?php if(ICL_LANGUAGE_CODE=='en') : ?>
		<a class="academy-studio__link" target="_blank" href="<?php the_field('link'); ?>" targett="_blank" style="background-color: <?php the_field('color'); ?>; border: 1px solid <?php the_field('color'); ?>;"><?php esc_html_e( 'Buy', 'timeout' ); ?></a>
		<?php else: ?>
		<a class="academy-studio__link" target="_blank" href="<?php the_field('link'); ?>" targett="_blank" style="background-color: <?php the_field('color'); ?>; border: 1px solid <?php the_field('color'); ?>;"><?php esc_html_e( 'Comprar', 'timeout' ); ?></a>
	
		<?php endif; ?>
		<?php endif; ?>

		<?php if(get_field('link')) : ?>
			 </a>
			 	
			 <?php else:
		
			 endif; ?>

	</div>	

</article><!-- #post-## -->
