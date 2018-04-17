<?php
/**
 * Sidebar setup for footer full.
 *
 * @package elexis
 */

$container   = get_theme_mod( 'theme_layout_container', 'container' );

?>

<?php if ( is_active_sidebar( 'footersecondary' ) ) : ?>

	<!-- ******************* The Secondary Footer Full-width Widget Area ******************* -->

	<div class="wrapper" id="wrapper-footer-secondary" <?php if ( !is_active_sidebar( 'footerfull' ) ) { ?>style="margin-top:auto;"<?php } ?>>

		<div class="<?php echo esc_attr( $container ); ?>" id="footer-secondary-content" tabindex="-1">

			<div class="row">

				<?php dynamic_sidebar( 'footersecondary' ); ?>

			</div>

		</div>

	</div><!-- #wrapper-footer-secondary -->

<?php endif; ?>
