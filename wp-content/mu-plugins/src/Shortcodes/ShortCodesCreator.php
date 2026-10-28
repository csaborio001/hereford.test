<?php
/**
 * Contains shortcodes used by Oxygen Templates to display content.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\Shortcodes;

class ShortCodesCreator {

	public static function initialize() {
		add_shortcode( 'shortcode_name', array( SomeClass::class, 'class_function_name' ) );
	}
}
