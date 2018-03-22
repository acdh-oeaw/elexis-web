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
  	
  	<?php elexis_entry_list_categories(); ?>

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
			<?php elexis_posted_on(); ?>
		</div><!-- .entry-meta -->

	<?php endif; ?>

	<footer class="entry-footer">

		<?php elexis_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
