<?php
/**
 * Template part for displaying page content in archive-academy.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('eat-and-shop-archive scroll'); ?> data-type="<?php the_field('category'); ?>" data-floor="<?php the_field('piso_value'); ?>">
	<?php 

	$id = get_the_ID();

	if($id == 765) {
			?>
		
		<a href="http://www.timeoutmarket.com/en/studio/">
	<?php } elseif($id == 762) {
		?>
	
		<a href="http://www.timeoutmarket.com/estudio/">
	<?php } else {
	
	?>	
		<a href="<?php the_permalink(); ?>">
	<?php
		} ?>
	


		<div class="eat-and-shop-archive__image-wrapper">
			<?php the_post_thumbnail( 'full', array( 'class' => 'eat-and-shop-archive__image' ) ); ?>
		</div>
		<div class="clear">
			<div class="eat-and-shop-archive__col">
				<p class="eat-and-shop-archive__number"><?php the_field('space-number'); ?></p>
			</div>
			<div class="eat-and-shop-archive__col">
				<h1 class="eat-and-shop-archive__title"><?php echo strip_tags(get_the_title()); ?></h1>

		

				<h2 class="eat-and-shop-archive__subtitle"><?php echo get_the_popular_excerpt1024() ?></h2>
			</div>
		</div>
	</a>
</article><!-- #post-## -->
