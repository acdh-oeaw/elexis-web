<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package elexis
 */

?>

<article <?php post_class('card'); ?> id="post-<?php the_ID(); ?>">

  <div class="entry-top-thumbnail">

    <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

  </div><!-- .entry-top-thumbnail -->

	<header class="entry-header">
  	
  	<?php $card_category_toggle = get_theme_mod( 'card_category_toggle', true ); if ($card_category_toggle) { elexis_entry_list_categories(); } ?>

		<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		'</a></h4>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
		the_excerpt();
		?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'elexis' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php 
  			$avatar = get_theme_mod( 'card_avatar_toggle', true );
  			$author = get_theme_mod( 'card_author_toggle', true );
  			$postdate = get_theme_mod( 'card_postdate_toggle', true );
  			$readingtime = get_theme_mod( 'card_readingtime_toggle', false );
  			$icons =  get_theme_mod( 'card_icons_toggle', true );
  			$tags =  get_theme_mod( 'card_tags_toggle', false );
  			elexis_entry_meta($avatar, $author, $postdate, $readingtime, $icons, $tags); 
  		?>
		</div><!-- .entry-meta -->

	<?php endif; ?>

</article><!-- #post-## -->
