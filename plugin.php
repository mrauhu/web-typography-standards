<?php
/*
Plugin Name: [ram108] Web Typography Standards
Plugin URI: http://wordpress.org/plugins/ram108-typo/
Description: Автоматически форматирует текст с использованием норм, правил и специфики русского языка и экранной типографики. Оnly for the Russian language typography.
Version: 0.6.4
Author: ram108, mrauhu
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

/**
 * Hooks that use `wptexturize()`
 */
$ignored_hooks = array(
	'wp_title' => true, // Fix: no space between `|` symbol and Blog name
);

// Init typograph
$ram108_typo = new EMTypograph();
$ram108_typo->setup(array(
	// WordPress have `wpautop( $text, $preserve_line_br = true )`
	'Text.paragraphs'		            => 'off',
	'Text.breakline'	               	=> 'off',
	// CSS-based, may break design of page
	'OptAlign.all'		            	=> 'off',
	// Fix: bug with Russian abbreviations, like: `Госдума РФ` -> `Госдума Р. Ф.`
	'Nobr.dots_for_surname_abbr'        => 'off',
	'Nobr.spaces_nobr_in_surname_abbr'  => 'off',
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
 * Change all wptexturize filters to EMT_wptexturize
 * @global string $wp_filter
 * @return boolean
 */
function ram108_typo_change_filter(){
	global $wp_filter;
	global $ignored_hooks;

	// Fix: use `wptexturize()` filter if is feed
	if (is_feed()) {
		return false;
	}

	foreach ( $wp_filter as $tag => $filter_list ) {
		// Use `wptexturize()` filter for ignored hooks
		if (isset($ignored_hooks[$tag])) {
			continue;
		}

		foreach ( $filter_list as $priority => $data ) {
			foreach ( $data as $id => $func ) {
				if ( 'wptexturize' == $id ) {
					// Fix: WordPress 4.7+ comparability
					remove_filter($tag, 'wptexturize');
					add_filter($tag, 'EMT_wptexturize', $priority - 1);
				}
			}
		}
	}

	return true;
}

// Activate plugin on `wp` action, because we need `WP_Query` for function `is_feed()`
add_action('wp', 'ram108_typo_change_filter', 100);
