<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('eat-and-shop-single'); ?>>
	
	<div class="eat-and-shop-single__col">
			<?php echo wp_get_attachment_image( get_field('image-detail'), 'full', false, array( "class" => "eat-and-shop-single__image--desktop" )  ); ?>

		<?php if(is_single('300') || is_single('140') || is_single('136') || is_single('301') || is_single('108') || is_single('302') || is_single('303') || is_single('107') || is_single('105') || is_single('304')) {
			echo wp_get_attachment_image( get_field('image-detail'), 'full', false, array( "class" => "eat-and-shop-single__image--mobile" )  );
		} else {
			the_post_thumbnail( 'full', array( 'class' => 'eat-and-shop-single__image--mobile' ) );
		}
		?>

	
	</div>

	<div class="eat-and-shop-single__col eat-and-shop-single__col--pad">
		<?php if(get_field('tag')) : ?>
		<h2 class="eat-and-shop-single__subtitle"><?php the_field('tag'); ?></h2>
		<?php endif; ?>
		
		<h1 class="eat-and-shop-single__title"><?php the_title(); ?></h1>
		<div class="eat-and-shop-single__description">
			<?php the_content(); ?>
			
		</div>
	</div>

	<?php
	if( have_rows('content') ):

		while( have_rows('content') ) : the_row();

			if( get_row_layout() == 'recipe' ):
				
				echo get_template_part('template-parts/types/content', 'recipe');

			endif;

		endwhile;

	endif;
	?>

</article><!-- #post-## -->
