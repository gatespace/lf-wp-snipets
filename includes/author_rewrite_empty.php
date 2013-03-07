<?php
/**
 * 投稿者アーカイブを作らないフィルター
 * テーマのfunctions.phpに記述後、設定→パーマリンク設定を更新（flush_rules() を実行）すること。
 */
add_filter( 'author_rewrite_rules', '__return_empty_array' );