<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="eat-and-shop-archive__image-wrapper">
		<div class="search-img-container" >
			<?php the_post_thumbnail( 'full', array( 'class' => 'eat-and-shop-archive__image' ) ); ?>
		</div>
		</div>

		<div class="clear">
		
			<div class="eat-and-shop-archive__col">
				<?php the_title( sprintf( '<h1 class="eat-and-shop-archive__title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<h2 class="eat-and-shop-archive__subtitle"><?php echo get_the_popular_excerpt1024() ?></h2>
			</div>
		</div>

		
	<footer class="entry-footer">
		<?php timeout_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
