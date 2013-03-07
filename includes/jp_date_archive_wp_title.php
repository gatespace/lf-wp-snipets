<?php
/**
 * 日付別アーカイブタイトルを修正
 * http://memo.dogmap.jp/2012/04/16/wordpress-fix-date-archive-title/
 */

function jp_date_archive_wp_title( $title ) {
	if ( is_date() ) {
		$title = '';
		if ( $y = intval(get_query_var('year')) )
			$title .= sprintf('%4d年', $y);
		if ( $m = intval(get_query_var('monthnum')) )
			$title .= sprintf('%2d月', $m);
		if ( $d = intval(get_query_var('day')) )
			$title .= sprintf('%2d日', $d);
		$title .= ' | ';
	}
	return $title;
}
add_filter( 'wp_title', 'jp_date_archive_wp_title', 1 );