<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('highlight-single'); ?>>
	
	<div class="highlight-single__col">
		<?php echo wp_get_attachment_image( get_field('image-detail'), 'full', false, array( "class" => "highlight-single__image--desktop" )  ); ?>
		<?php the_post_thumbnail( 'full', array( 'class' => 'highlight-single__image--mobile' ) ); ?>
	</div>

	<div class="highlight-single__col">
	
		<h1 class="highlight-single__subtitle"><?php the_title(); ?></h1>
		<div class="highlight-single__description">
			<?php the_content(); ?>
		</div>
	</div>

</article><!-- #post-## -->
