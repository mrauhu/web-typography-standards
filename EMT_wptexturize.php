<?php

/**
 * Part from WordPress Formatting API.
 * 
 * Added for make Web Typography Standards comportable with WordPress filters
 *
 */

/**
 * Replaces common plain text characters into formatted entities
 * using Eugene Muraev Typograph
 *
 * As an example,
 *
 *     'cause today's effort makes it worth tomorrow's "holiday" ...
 *
 * Becomes:
 *
 *     &#8217;cause today&#8217;s effort makes it worth tomorrow&#8217;s &#8220;holiday&#8221; &#8230;
 *
 * Code within certain html blocks are skipped.
 *
 *
 * @global array $wp_cockneyreplace Array of formatted entities for certain common phrases
 * @global array $shortcode_tags
 * @staticvar array $static_characters
 * @staticvar array $static_replacements
 * @staticvar array $default_no_texturize_tags
 * @staticvar array $default_no_texturize_shortcodes
 * @staticvar bool  $run_texturize
 *
 * @param string $text The text to be formatted
 * @param bool   $reset Set to true for unit testing. Translated patterns will reset.
 * @return string The string replaced with html entities
 */
function EMT_wptexturize( $text, $reset = false ) {
	global $wp_cockneyreplace, $shortcode_tags;
	static $static_characters, $static_replacements,
		$default_no_texturize_tags, $default_no_texturize_shortcodes, $run_texturize = true;

	// If there's nothing to do, just stop.
	if ( empty( $text ) || false === $run_texturize ) {
		return $text;
	}

	// Set up static variables. Run once only.
	if ( $reset || ! isset( $static_characters ) ) {
		/**
		 * Filter whether to skip running wptexturize().
		 *
		 * Passing false to the filter will effectively short-circuit wptexturize().
		 * returning the original text passed to the function instead.
		 *
		 * The filter runs only once, the first time wptexturize() is called.
		 *
		 * @since 4.0.0
		 *
		 * @see wptexturize()
		 *
		 * @param bool $run_texturize Whether to short-circuit wptexturize().
		 */
		$run_texturize = apply_filters( 'run_wptexturize', $run_texturize );
		if ( false === $run_texturize ) {
			return $text;
		}

		$default_no_texturize_tags = array('pre', 'code', 'kbd', 'style', 'script', 'tt');
		$default_no_texturize_shortcodes = array('code');
		
		// if a plugin has provided an autocorrect array, use it
		if ( isset($wp_cockneyreplace) ) {
			$cockney = array_keys( $wp_cockneyreplace );
			$cockneyreplace = array_values( $wp_cockneyreplace );
		} else {
			$cockney = $cockneyreplace = array();
		}

		$static_characters = $cockney;
		$static_replacements = $cockneyreplace;
	}

	// Must do this every time in case plugins use these filters in a context sensitive manner
	/**
	 * Filter the list of HTML elements not to texturize.
	 *
	 * @since 2.8.0
	 *
	 * @param array $default_no_texturize_tags An array of HTML element names.
	 */
	$no_texturize_tags = apply_filters( 'no_texturize_tags', $default_no_texturize_tags );
	
	EMT_safe_tags( $default_no_texturize_shortcodes, $no_texturize_tags );
	
	/**
	 * Filter the list of shortcodes not to texturize.
	 *
	 * @since 2.8.0
	 *
	 * @param array $default_no_texturize_shortcodes An array of shortcode names.
	 */
	$no_texturize_shortcodes = apply_filters( 'no_texturize_shortcodes', $default_no_texturize_shortcodes );

	$no_texturize_shortcodes_stack = array();

	// Look for shortcodes and HTML elements.

	$tagnames = array_keys( $shortcode_tags );
	$tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );
	$tagregexp = "(?:$tagregexp)(?![\\w-])"; // Excerpt of get_shortcode_regex().

	$comment_regex =
		  '!'           // Start of comment, after the <.
		. '(?:'         // Unroll the loop: Consume everything until --> is found.
		.     '-(?!->)' // Dash not followed by end of comment.
		.     '[^\-]*+' // Consume non-dashes.
		. ')*+'         // Loop possessively.
		. '(?:-->)?';   // End of comment. If not found, match all input.

	$shortcode_regex =
		  '\['              // Find start of shortcode.
		. '[\/\[]?'         // Shortcodes may begin with [/ or [[
		. $tagregexp        // Only match registered shortcodes, because performance.
		. '(?:'
		.     '[^\[\]<>]+'  // Shortcodes do not contain other shortcodes. Quantifier critical.
		. '|'
		.     '<[^\[\]>]*>' // HTML elements permitted. Prevents matching ] before >.
		. ')*+'             // Possessive critical.
		. '\]'              // Find end of shortcode.
		. '\]?';            // Shortcodes may end with ]]

	$regex =
		  '/('                   // Capture the entire match.
		.     $shortcode_regex   // Find shortcodes.
		. ')/s';

	$textarr = preg_split( $regex, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );

	foreach ( $textarr as &$curl ) {
		// Only call _wptexturize_pushpop_element if $curl is a delimiter.
		$first = $curl[0];
		if ( '' === trim( $curl ) ) {
			// This is a newline between delimiters.  Performance improves when we check this.

			continue;

		} elseif ( '[' === $first && 1 === preg_match( '/^' . $shortcode_regex . '$/', $curl ) ) {
			// This is a shortcode delimiter.

			if ( '[[' !== substr( $curl, 0, 2 ) && ']]' !== substr( $curl, -2 ) ) {
				// Looks like a normal shortcode.
				_wptexturize_pushpop_element( $curl, $no_texturize_shortcodes_stack, $no_texturize_shortcodes );
			} else {
				// Looks like an escaped shortcode.
				continue;
			}

		} elseif ( empty( $no_texturize_shortcodes_stack ) ) {
			// This is neither a delimiter, nor is this content inside of no_texturize pairs.  Do texturize.

			$curl = str_replace( $static_characters, $static_replacements, $curl );
			
			// Run EMT
			$curl = EMT_run( $curl );
		}
	}
	$text = implode( '', $textarr );

	return $text;
}

