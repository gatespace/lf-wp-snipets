<?php
/*
Plugin Name: LF WordPress Snipets
Plugin URI:
Description: いろいろなスニペット
Version: 0.1
Author: littleflag.com
Author URI: http://www.littleflag.com/
*/
$hack_dir = trailingslashit(dirname(__FILE__)) . 'includes/';
opendir($hack_dir);
while(($ent = readdir()) !== false) {
	if( !is_dir($ent) && (strtolower( substr($ent,-4) ) == ".php") && (substr($ent, 0, 1) != "_") ) {
		include_once($hack_dir.$ent);
	}
}
closedir();
