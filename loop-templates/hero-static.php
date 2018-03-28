<?php
/**
 * Static hero setup.
 *
 * @package elexis
 */

$hero_static_title = get_theme_mod( 'hero_static_title' );
$hero_static_text = get_theme_mod( 'hero_static_text' );
$hero_button = get_theme_mod( 'hero_button' );
$hero_static_url = get_theme_mod( 'hero_static_url' );
$hero_static_image = get_theme_mod( 'hero_static_image' );

?>


	<!-- ******************* The Hero Area ******************* -->

	<div class="wrapper" id="wrapper-static-hero">

			<div class="<?php echo esc_attr( $container ); ?>" id="wrapper-static-content" tabindex="-1">

				<div class="row">

					<?php if ($hero_static_title) { ?><h1><?php echo $hero_static_title; ?></h1><?php } ?>
					<?php if ($hero_static_text) { ?><p><?php echo $hero_static_text; ?></p><?php } ?>
					<?php if ($hero_button) { ?><button class="btn"><?php echo $hero_button; ?></button><?php } ?>

				</div>

			</div>

	</div><!-- #wrapper-static-hero -->
