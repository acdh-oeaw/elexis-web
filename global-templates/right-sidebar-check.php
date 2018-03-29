<?php
/**
 * Right sidebar check.
 *
 * @package elexis
 */
?>

<?php $sidebar_pos = get_theme_mod( 'theme_layout_sidebar', 'right' ); ?>

<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

  <?php get_sidebar( 'right' ); ?>

<?php endif; ?>
