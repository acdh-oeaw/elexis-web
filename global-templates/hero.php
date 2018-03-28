<?php
/**
 * Hero setup.
 *
 * @package elexis
 */

?>

<?php
  $hero_type_setting  = get_theme_mod( 'hero_type_setting', false );
  if ($hero_type_setting != 'none' && $hero_type_setting) {
?>

	<div class="wrapper" id="wrapper-hero">
	
		<?php 
  		if ($hero_type_setting == 'static-hero') {
  		  get_template_part( 'loop-templates/hero-static' );
  		} else if ($hero_type_setting == 'post-hero') {
    		get_template_part( 'loop-templates/hero-post' );
      }
    ?>

	</div>

<?php } ?>
