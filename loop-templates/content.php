<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package elexis
 */

//Extract variables from the query
extract( $wp_query->query_vars );
if (!$blocks_per_row) { 
  $blocks_per_row = get_theme_mod( 'archive_columns_per_row', 'col-md-12' );
}
if (!$blocks_layout_type) {
  $blocks_layout_type = get_theme_mod( 'archive_blocks_layout_type', 'card-vertical' );
}
// Get the card style selection
$card_predefined_style = get_theme_mod( 'card_predefined_style', 'flat-style' );

$articleClasses = array(
  'card',
  $blocks_per_row,
  $card_predefined_style
);
?>

<article <?php post_class($articleClasses); ?> id="post-<?php the_ID(); ?>">

  <div class="card-inner <?php echo esc_attr( $blocks_layout_type ); ?>">

  <?php 
    $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
    if ($postThumbnail && $blocks_layout_type != 'card-no-image' ) { echo '<a class="entry-top-thumbnail" href="'.esc_url( get_permalink() ).'" rel="bookmark">'.$postThumbnail.'</a>'; }
  ?>

    <div class="entry-text-content">

    	<header class="entry-header">
      	
      	<?php $card_category_toggle = get_theme_mod( 'card_category_toggle', true ); if ($card_category_toggle) { elexis_entry_list_categories(); } ?>

        <?php
          // @specific-elexis start
          $fields = get_post_custom();
          if(isset($fields['card_overlay_icon'])) {
            echo '<a href="'.esc_url( get_permalink() ).'" rel="bookmark"><i data-feather="'.$fields['card_overlay_icon'][0].'" class="card-overlay-icon"></i></a>';
          }
          // @specific-elexis end
        ?>

    		<?php 
      		if ( is_sticky() ) { $sticky = '<i data-feather="star" class="sticky-icon"></i>'; } else { $sticky = ''; } 
      		the_title( sprintf( '<h4 class="entry-title">'.$sticky.'<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),'</a></h4>' );
        ?>
    
    	</header><!-- .entry-header -->
    
    	<div class="entry-content">
    
    		<?php
    		the_excerpt();
    		?>

        <?php if (get_theme_mod( 'card_readmore_toggle', false )) { ?>
          <a class="btn btn-round mb-1" href="<?php echo esc_url( get_permalink( get_the_ID() )); ?>"><?php echo __( 'Read More','elexis' ); ?></a>
        <?php } ?>

    		<?php
    		wp_link_pages( array(
    			'before' => '<div class="page-links">' . __( 'Pages:', 'elexis' ),
    			'after'  => '</div>',
    		) );
    		?>
    
    	</div><!-- .entry-content -->
    
    	<?php if ( 'post' == get_post_type() ) {
  			$avatar = get_theme_mod( 'card_avatar_toggle', true );
  			$author = get_theme_mod( 'card_author_toggle', true );
  			$postdate = get_theme_mod( 'card_postdate_toggle', true );
  			$readingtime = get_theme_mod( 'card_readingtime_toggle', false );
  			$icons =  get_theme_mod( 'card_icons_toggle', true );
  			$tags =  get_theme_mod( 'card_tags_toggle', false );
        if ($avatar OR $author OR $postdate OR $readingtime OR $icons OR $tags) {
      ?>
          <div class="entry-meta <?php if (get_theme_mod( 'card_readmore_toggle', false )) { echo 'mt-3'; } ?>">
          <?php elexis_entry_meta($avatar, $author, $postdate, $readingtime, $icons, $tags); ?>
    		  </div><!-- .entry-meta -->
    	<?php } } ?>
  
    </div><!-- .entry-text-content -->

	</div><!-- .card-inner -->

</article><!-- #post-## -->
