<?php
/**
 * Partial template for content in page.php
 *
 * @package elexis
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

  <?php 
    $single_posts_layout_order = get_theme_mod( 'single_posts_layout_order', array( 'featured_image', 'post_title' ) );

    foreach ($single_posts_layout_order as $layout_area) {
      if ($layout_area == 'featured_image') {
        $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
        if ($postThumbnail) { 
          $postThumbnailCaption = get_post(get_post_thumbnail_id())->post_excerpt;
          echo '<div class="entry-top-thumbnail">'.$postThumbnail.'</div>'; 
          if(!empty($postThumbnailCaption)){ 
            echo '<div class="entry-top-thumbnail-caption">' . $postThumbnailCaption . '</div>';
          }
        }
      } else if ($layout_area == 'post_title') {
        the_title( '<h1 class="entry-title">', '</h1>' );
      }
    }
  ?>

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
