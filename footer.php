<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package elexis
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'theme_layout_container', 'container' );
?>

<?php get_sidebar( 'footerfull' ); ?>

<?php get_sidebar( 'footersecondary' ); ?>

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

