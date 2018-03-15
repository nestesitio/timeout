<?php
/**
 * Template part for displaying page content in archive-academy.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('scroll'); ?>>
	
	<div class="col col--two">
		<?php the_post_thumbnail( 'full', array( 'class' => 'academy__image' ) ); ?>
	</div>

	<div class="col col--two col--padding">
		<p class="academy__category" style="color: <?php the_field('color'); ?>"><?php the_field('category'); ?></p>
		<h1 class="academy__title"><?php the_title( ); ?></h1>

		<div class="academy__info">
			<p class="icon icon-date-2" style="color: <?php the_field('color'); ?>"><span><?php the_field('date'); ?></span></p>
			<p class="icon icon-tempo" style="color: <?php the_field('color'); ?>"><span><?php the_field('hour'); ?></span></p>
			<p class="icon icon-duracao-1" style="color: <?php the_field('color'); ?>"><span><?php the_field('duration'); ?> <small>Min.</small></span></p>
			<p class="icon icon-custo-2" style="color: <?php the_field('color'); ?>"><span><?php the_field('price'); ?> €</span></p>
		</div>

		<h2 class="academy__description"><?php the_content( ); ?></h2>
		
		<?php if(get_field('link')) : ?>
		<a class="academy__link" href="<?php the_field('link'); ?>" target="_blank" style="background-color: <?php the_field('color'); ?>; border: 1px solid <?php the_field('color'); ?>;"><?php esc_html_e( 'Book', 'timeout' ); ?></a>
		<?php endif; ?>

	</div>	

</article><!-- #post-## -->
