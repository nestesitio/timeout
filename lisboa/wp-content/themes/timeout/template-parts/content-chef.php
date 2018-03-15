<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class('academy-studio academia-parent'); ?>>

	<div class="col col--two">
		<div class="academy-module">
			<?php the_post_thumbnail( 'full', array( 'class' => 'academy-studio__image' ) ); ?>
		
		</div>
	</div>
			
	<div class="col col--two col--padding">
		<p class="academy-studio__category" style="color: <?php the_field('color'); ?>"><?php the_field('category'); ?></p>
		<h1 class="academy-studio__title"><?php the_title( ); ?></h1>

		<h2 class="academy-studio__description"><?php echo the_content() ?></h2>

	</div>	

</article><!-- #post-## -->
