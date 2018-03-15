<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package timeout
 */

?>

<section class="no-results not-found">
	<header class="page-header" style="margin-top:50px;text-align:center">
		<h1 class="home-module__subtitle">
			<?php if(ICL_LANGUAGE_CODE=='en') : ?>
			<?php esc_html_e( 'Nothing Found', 'timeout' ); ?>
		<?php else: ?>
		<?php esc_html_e( 'Sem resultados', 'timeout' ); ?>
		<?php endif; ?>
	</h1>
	</header><!-- .page-header -->

	<div class="page-content" style="width:80%;margin:0 auto;text-align:center;">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'timeout' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>
<?php if(ICL_LANGUAGE_CODE=='en') : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'timeout' ); ?></p>

<?php else: ?>
			<p><?php esc_html_e( 'Pedimos desculpa, mas nada correspondeu aos seus critérios de procura. Por favor volte a tentar com palavras-chave diferentes.', 'timeout' ); ?></p>
			<?php endif; ?>
			<?php
			

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'timeout' ); ?></p>
			<?php
			

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
