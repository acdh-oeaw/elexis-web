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
      $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
      if ($postThumbnail) { 
        $postThumbnailCaption = get_post(get_post_thumbnail_id())->post_excerpt;
        echo '<div class="entry-top-thumbnail">'.$postThumbnail.'</div>'; 
        if(!empty($postThumbnailCaption)){ 
          echo '<div class="entry-top-thumbnail-caption">' . $postThumbnailCaption . '</div>';
        }
      }
    ?>

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
