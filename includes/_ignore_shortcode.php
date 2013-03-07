<?php
/**
 * 投稿内でコメントアウトできるようにする
 * 使い方[ignore]コメントアウト[/ignore]
 */

function littleflag_ignore_shortcode( $atts, $content = null ) {
	return null;
}
add_shortcode('ignore', 'littleflag_ignore_shortcode', '9999');
