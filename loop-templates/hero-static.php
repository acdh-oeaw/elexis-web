<?php
/**
 * Static hero setup.
 *
 * @package elexis
 */

$container = get_theme_mod( 'theme_layout_container', 'container' );
$hero_static_title = get_theme_mod( 'hero_static_title' );
$hero_static_text = get_theme_mod( 'hero_static_text' );
$hero_button = get_theme_mod( 'hero_button' );
$hero_static_url = get_theme_mod( 'hero_static_url' );
$hero_static_image = get_theme_mod( 'hero_static_image' );

?>


	<!-- ******************* The Hero Area ******************* -->

	<div class="wrapper" id="wrapper-hero-content" <?php if ($hero_static_image) { ?>style="background-image:url(<?php echo esc_attr( $hero_static_image ); ?>)"<?php } ?>>

			<div class="<?php echo esc_attr( $container ); ?>" id="wrapper-hero-inner" tabindex="-1">

				<div class="row">

					<?php if ($hero_static_title) { ?><h1><?php echo esc_attr( $hero_static_title ); ?></h1><?php } ?>
					<?php if ($hero_static_text) { ?><p><?php echo esc_attr( $hero_static_text ); ?></p><?php } ?>
					<?php if ($hero_button) { ?><button class="btn"><?php echo esc_attr( $hero_button ); ?></button><?php } ?>

				</div>

			</div>

	</div><!-- #wrapper-hero-content -->
