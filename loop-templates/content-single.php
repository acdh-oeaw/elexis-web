<?php
/**
 * Single post partial template.
 *
 * @package elexis
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<div class="entry-meta">

		<?php
			$avatar = get_theme_mod( 'post_avatar_toggle', true );
			$author = get_theme_mod( 'post_author_toggle', true );
			$postdate = get_theme_mod( 'post_postdate_toggle', true );
			$readingtime = get_theme_mod( 'post_readingtime_toggle', false );
			$icons =  get_theme_mod( 'post_icons_toggle', false );
			$tags =  get_theme_mod( 'post_tags_toggle', true );
			$authorbio =  get_theme_mod( 'post_authorbio_toggle', true );
			elexis_entry_meta($avatar, $author, $postdate, $readingtime, $icons, $tags, $authorbio, 60);
		?>

		</div><!-- .entry-meta -->

    <?php 
      $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
      if ($postThumbnail) { echo '<div class="entry-top-thumbnail">'.$postThumbnail.'</div>'; }
    ?>

		<?php $post_category_toggle = get_theme_mod( 'post_category_toggle', true ); if ($post_category_toggle) { elexis_entry_list_categories(); } ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'elexis' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
