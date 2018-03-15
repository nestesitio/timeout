<section class="eat-and-shop-recipe">
	<div class="eat-and-shop-recipe__col eat-and-shop-recipe__col--pad eat-and-shop-recipe__col--full">
		<h2 class="eat-and-shop-recipe__category"><?php esc_html_e( 'Recipe', 'timeout' ); ?>
			<?php if(get_sub_field('icon')): ?>
			<span class="eat-and-shop-recipe__icon icon icon-<?php the_sub_field('icon'); ?>"></span>
			<?php endif; ?>
		</h2>
		<h1 class="eat-and-shop-recipe__title"><?php the_sub_field('title'); ?></h1>
		<div class="eat-and-shop-recipe__description">
			<?php the_sub_field('description'); ?>
		</div>

	</div>

	<div class="eat-and-shop-recipe__col eat-and-shop-recipe__col--full">
		
		<div class="eat-and-shop-recipe__col eat-and-shop-recipe__col--pad">
			<h2 class="eat-and-shop-recipe__category"><?php esc_html_e( 'Ingredients', 'timeout' ); ?></h2>
			<div class="eat-and-shop-recipe__ingredients">
				<?php the_sub_field('ingredients') ?>
			</div>
		</div>

		<div class="eat-and-shop-recipe__col">
			<?php echo wp_get_attachment_image( get_sub_field('image'), 'full', false, array( "class" => "eat-and-shop-recipe__image" )  ); ?>
		</div>

	</div>
</section>