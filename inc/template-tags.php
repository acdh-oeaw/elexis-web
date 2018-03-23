<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package elexis
 */

if ( ! function_exists( 'elexis_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function elexis_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s"> (%4$s) </time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$gravatar = sprintf(
		'<a class="author-avatar" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar( get_the_author_meta( 'ID' ), 40 ) . '</a>'
	);
	$posted_on = sprintf(
		'<a class="post-date" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	$authorname = sprintf(
		'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
	);
	$readicon = sprintf(
		'<a class="read-post-icon" href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="' . __( 'Read More...', 'elexis' ) . '"><i data-feather="bookmark"></i></a>'
	);
	echo $gravatar . '<span class="author-meta">' . $authorname . $posted_on . '</span>'; // WPCS: XSS OK.
  echo '<div class="entry-meta-icons">';
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		comments_popup_link( '', esc_html__( '1', 'elexis' ) . '<i data-feather="message-circle"></i>', esc_html__( '%', 'elexis' ) . '<i data-feather="message-circle"></i>', 'comments-link' );
	}
  edit_post_link( '<i data-feather="edit-3"></i>' );
	echo $readicon;
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '<i data-feather="hash"></i>', ' <i data-feather="hash"></i>' );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . $tags_list . '</span>' ); // WPCS: XSS OK.
		}
	}
	echo '</div>';
}
endif;

if ( ! function_exists( 'elexis_entry_list_categories' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function elexis_entry_list_categories() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'elexis' ) );
		if ( $categories_list && elexis_categorized_blog() ) {
			printf( '<span class="entry-cat-links"><i data-feather="archive"></i>' . $categories_list . '</span>' ); // WPCS: XSS OK.
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function elexis_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'elexis_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );
		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'elexis_categories', $all_the_cool_cats );
	}
	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so components_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so components_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in elexis_categorized_blog.
 */
function elexis_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'elexis_categories' );
}
add_action( 'edit_category', 'elexis_category_transient_flusher' );
add_action( 'save_post',     'elexis_category_transient_flusher' );

