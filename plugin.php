<?php
/*
Plugin Name: [ram108] Web Typography
Plugin URI: http://wordpress.org/plugins/ram108-typo/
Description: Apply web typography standards to Wordpress content: space control, punctuation, intelligent character replacement, CSS hooks and more.
Version: 0.1
Author: ram108
Author URI: http://profiles.wordpress.org/ram108
Author Email: plugin@ram108.ru
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
===========================================================
Copyright 2014 by Kirill Borodin plugin@ram108.ru
http://www.ram108.ru/donate
OM SAI RAM
===========================================================
Muravjev Typograph original script http://mdash.ru
*/

// init typo
require_once('EMT.php');
$ram108_typo = new EMTypograph();
$ram108_typo->setup(array(
	'Text.paragraphs'	=> 'off',
	'Text.breakline'	=> 'off',
));

// new wptextorize function with typo
function ram108_typo_wptexturize( $text ){
	global $ram108_typo;
	$ram108_typo->set_text( $text );
	return $ram108_typo->apply();
}

// change all wptexturize filters to ram108_typo_wptexturize
function ram108_typo_change_filter(){
	global $wp_filter;
	foreach ( $wp_filter as $tag => $filter_list ) 
	foreach ( $filter_list as $priority => $data ) 
	foreach ( $data as $id => $func ) 
	if ( 'wptexturize' == $id ) $wp_filter[ $tag ] [ $priority ] [ $id ] ['function'] = 'ram108_typo_wptexturize';
}

add_action('init', 'ram108_typo_change_filter', 100);