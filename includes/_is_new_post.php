<?php
/**
 * post_classの出力するclassに、新着であれば、new-post、更新であれば、modified-postを追加する。
 * 条件分岐タグ : 新着かどうか is_new_post() 、更新かどうか is_modified_post
 * ループ外で使う場合 : is_new_post( $new_post->post_date )
 * 設定した期間を異なる期間で判定（3日以内の更新かどうかを判定） :
 *  is_modified_post( $new_post->post_modified, 3 )
 *
 * 参照 : http://www.warna.info/archives/2034/
 *
 * @param array $classes Array of default classes.
 * @param array|string $class array or string space separated class names.
 * @param int $post_id post ID.
 * @return array Array of marged classes.
 */
function new_and_modefied_post_class( $classes, $class, $post_id ) {
	$post_id = (int)$post_id;
	$post = get_post( $post_id );

	if ( is_new_post() ) {
		$classes[] = 'new-post';
	}
	if ( is_modified_post() && $post->post_modified > $post->post_date ) {
		$classes[] = 'modified-post';
	}
	return $classes;
}
add_filter( 'post_class', 'new_and_modefied_post_class', 10, 3 );

/**
 * 新着かどうかを判別する。
 *
 * @param string $post_date PHP date format.
 * @param int $days days of new period.
 * @return bool within or not
 */
function is_new_post( $post_date = '', $days = 0 ) {
	global $post;
	if ( ! $post_date ) {
		$post_date = $post->post_date;
	}
	if ( ! $days ) {
		$days = absint( get_option( 'new_days', 7 ) );
	}
	return is_widthin_days( $post_date, $days );
}

/**
 * 更新かどうかを判別する。
 *
 * @param string $post_date PHP date format.
 * @param int $days days of modified period.
 * @return bool within or not
 */
function is_modified_post( $post_date = '', $days = 0 ) {
	global $post;
	if ( ! $post_date ) {
		$post_date = $post->post_modified;
	}
	if ( ! $days ) {
		$days = absint( get_option( 'modified_days', 7 ) );
	}
	return is_widthin_days( $post_date, $days );
}

/**
 * 期間内かどうかを判別する。
 *
 * @param string $post_date PHP date format.
 * @param int $days days of period.
 * @return bool within or not
 */
function is_widthin_days( $post_date, $days = 7 ) {
	if ( in_array( strtotime( $post_date ), array( false, -1 ) ) ) {
		return false;
	}

	$limit = current_time( 'timestamp' ) - ( $days - 1 ) * 24 * 3600;
	if ( mysql2date( 'Y-m-d', $post_date ) >= date( 'Y-m-d', $limit ) ) {
		return true;
	}
	return false;
}

/**
 * 表示設定ページに新着と更新の表示期間（日数）の設定項目を追加する
 */
function add_days_items() {
	add_settings_field( 'new_days', '新着期間設定', 'display_new_days_field', 'reading' );
	add_settings_field( 'modified_days', '更新期間設定', 'display_modified_days_field', 'reading' );
}
add_action( 'admin_init', 'add_days_items' );

/**
 * 設定で保存できる項目に、新着表示日数と更新表示日数を追加する
 *
 * @param array $whitelist_options.
 * @return array filtered whitelist options
 **/
function allow_new_and_modified_post_data( $whitelist_options ) {
	$whitelist_options['reading'][] = 'new_days';
	$whitelist_options['reading'][] = 'modified_days';
	return $whitelist_options;
}
add_filter( 'whitelist_options', 'allow_new_and_modified_post_data' );

/**
 * 表示設定画面に新着表示日数の設定項目を表示する
 */
function display_new_days_field() {
	$new_days = absint( get_option( 'new_days', 7 ) );
?>
	<input type="text" name="new_days" id="new_days" size="1" value="<?php echo esc_attr( $new_days ); ?>" />
	日間<span class="description">（1日間だと本日のみ、1週間にするには7日間としてください。）</span>
<?php
}

/**
 * 表示設定画面に更新表示日数の設定項目を表示する
 */
function display_modified_days_field() {
	$modified_days = absint( get_option( 'modified_days', 7 ) );
?>
	<input type="text" name="modified_days" id="modified_days" size="1" value="<?php echo esc_attr( $modified_days ); ?>" />
	日間<span class="description">（1日間だと本日のみ、1週間にするには7日間としてください。）</span>
<?php
}