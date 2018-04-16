<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package elexis
 */

get_header();

$container = get_theme_mod( 'theme_layout_container', 'container' );
$home_content_blocks = get_theme_mod( 'home_content_blocks' );
if (!$home_content_blocks) { 
  $home_content_blocks[0]["blocks_per_row"] = 'col-md-12'; 
}
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

      <?php foreach ($home_content_blocks as $home_content_block) { 
        if (isset($home_content_block["block_title"])) { $block_title = $home_content_block["block_title"]; }
        if (isset($home_content_block["blocks_per_row"])) { $blocks_per_row = $home_content_block["blocks_per_row"]; }
        if (isset($home_content_block["number_of_blocks"])) { $number_of_blocks = $home_content_block["number_of_blocks"]; }
        if (isset($home_content_block["blocks_orderby"])) { $blocks_orderby = $home_content_block["blocks_orderby"]; } else { $blocks_orderby = 'date'; }
        if (isset($home_content_block["blocks_order"])) { $blocks_order = $home_content_block["blocks_order"]; } else { $blocks_order = 'DESC'; }
        if (isset($home_content_block["blocks_orderby_metakey"])) { $blocks_orderby_metakey = $home_content_block["blocks_orderby_metakey"]; } else { $blocks_orderby_metakey = ''; }
        if (isset($home_content_block["blocks_post_category_query"])) { $blocks_post_category_query = implode(",",$home_content_block["blocks_post_category_query"]); } else { $blocks_post_category_query = ''; }
        if (isset($home_content_block["blocks_post_tags_query"])) { $blocks_post_tags_query = implode(",",$home_content_block["blocks_post_tags_query"]); } else { $blocks_post_tags_query = ''; }
        if (isset($home_content_block["blocks_layout_type"])) { $blocks_layout_type = $home_content_block["blocks_layout_type"]; }

        //Query the defined content blocks
        $args = array(
        	'post_type' => 'post',
        	'posts_per_page' => $number_of_blocks,
        	'orderby' => $blocks_orderby,
        	'order' => $blocks_order,
        	'meta_key'  => $blocks_orderby_metakey,
        	'tax_query' => array(
        		'relation' => 'OR',
        		array(
        			'taxonomy' => 'category',
        			'field'    => 'term_id',
        			'terms'    => array( $blocks_post_category_query ),
        		),
        		array(
        			'taxonomy' => 'post_tag',
        			'field'    => 'term_id',
        			'terms'    => array( $blocks_post_tags_query ),
        		),
        	),
        );

        $query = new WP_Query( $args );
      ?>

				<?php if ( $query->have_posts() ) : ?>

          <?php if ($block_title) { ?>
            <h5 class="content-block-title"><span class="separator-title"><?php echo esc_attr( $block_title ); ?></span></h5>
          <?php } ?>
          <?php if ($blocks_per_row) { set_query_var( 'blocks_per_row', $blocks_per_row ); } else { set_query_var( 'blocks_per_row', 'col-md-12' ); } ?>
          <?php if ($blocks_layout_type) { set_query_var( 'blocks_layout_type', $blocks_layout_type ); } else { set_query_var( 'blocks_layout_type', 'card-vertical' ); } ?>

          <div class="card-wrapper">

  					<?php /* Start the Loop */ ?>
  					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
  
  						<?php
  
  						/*
  						 * Include the Post-Format-specific template for the content.
  						 * If you want to override this in a child theme, then include a file
  						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
  						 */
  						get_template_part( 'loop-templates/content', get_post_format() );
  						?>
  
  					<?php endwhile; ?>
          </div><!-- .card-wrapper -->

  				<?php else : //No results ?>
  					<?php get_template_part( 'loop-templates/content', 'none' ); ?>
  				<?php endif; ?>
        
      <?php wp_reset_query(); } ?>
			</main><!-- #main -->

			<!-- The pagination component -->
			<?php elexis_pagination(); ?>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>
		

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
