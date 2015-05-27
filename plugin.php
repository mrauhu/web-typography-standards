<?php
/*
Plugin Name: [ram108] Web Typography Standards
Plugin URI: http://wordpress.org/plugins/ram108-typo/
Description: Apply web typography standards to Wordpress content: space control, punctuation, intelligent character replacement, CSS hooks and more.
Version: 0.2.2
Author: ram108
Author URI: http://profiles.wordpress.org/ram108
Author Email: plugin@ram108.ru
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
===========================================================
Copyright 2014 by Kirill Borodin plugin@ram108.ru
http://www.ram108.ru/donate
OM SAI RAM
*/

// Load libraries
require_once('EMT.php');
require_once('EMT_wptexturize.php');

// Init typograph
$ram108_typo = new EMTypograph();
$ram108_typo->setup(array(
	'Text.paragraphs'		=> 'off',
	'Text.breakline'		=> 'off',
	'OptAlign.all'			=> 'off',
));

/**
 * Run EMT on selected text
 * @global EMTypograph $ram108_typo
 * @param string $text
 * @return string
 */
function EMT_run( $text ){
	global $ram108_typo;
	$ram108_typo->set_text( $text );
	return $ram108_typo->apply();
}

/**
 * Change EMT safe tags
 * with checking result of filter 'no_texturize_tags'
 * @global EMTypograph $ram108_typo
 * @param array $old Tags list before run filter
 * @param array $new Tags list after run filter
 */
function EMT_safe_tags ( $old, $new ) {
	global $ram108_typo;
	
	// Check for changes
	$added_tags = array_diff( $old, $new );
	$removed_tags = array_diff( $new, $old );
	
	if ( count( $added_tags ) > 0 ) {
		foreach( $added_tags as $tag_to_add ) {
			$ram108_typo->add_safe_tag($tag_to_add);
		}
	}
	
	if ( count( $removed_tags ) > 0 ) {
		foreach( $removed_tags as $tag_to_remove ) {
			$ram108_typo->remove_safe_block( $tag_to_remove );
		}
	}
}

/**
 * Change all wptexturize filters to EMT_wptexturize
 * @global string $wp_filter
 */
function ram108_typo_change_filter(){
	global $wp_filter;
	foreach ( $wp_filter as $tag => $filter_list ) {
		foreach ( $filter_list as $priority => $data ) {
			foreach ( $data as $id => $func ) {
				if ( 'wptexturize' == $id ) {
					$wp_filter[ $tag ] [ $priority ] [ $id ] ['function'] = 'EMT_wptexturize';
				}
			}
		}
	}
}

// activate plugin
add_action('init', 'ram108_typo_change_filter', 100);