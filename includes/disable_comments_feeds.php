<?php
/**
 * Disable comments feed
 */
function littleflag_feed_force_404( $obj ) {
	if ( $obj->is_comment_feed ) { // $obj->is_feed で全てのフィード
		wp_die("Not Found.<br>".'<a href="'.home_url('/').'">Back to Home.</a>', '', array( 'response' => 404, "back_link" => true ));
	} elseif ( $obj->is_feed ) {
		if (is_author()) {
			wp_die("Not Found.<br>".'<a href="'.home_url('/').'">Back to Home.</a>', '', array( 'response' => 404, "back_link" => true ));
		} else {
			return;
		}
	}
}
add_action( 'parse_query', 'littleflag_feed_force_404' );

/**
 * Disable feed (Type : RDF/RSS 1.0)
 */
/*
remove_action( 'do_feed_rdf', 'do_feed_rdf');
remove_action( 'do_feed_rss',  'do_feed_rss' );
remove_action( 'do_feed_rss2', 'do_feed_rss2' );
remove_action( 'do_feed_atom', 'do_feed_atom' );
*/

/**
 * remove feed link
 */
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/**
 * add feed link
 */
function lf_custom_feeds_alternate() {
	echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . esc_attr(get_bloginfo('name')) . 'のフィード" href="' . get_feed_link() . "\" />\n";
}
add_action( 'wp_head', 'lf_custom_feeds_alternate' );