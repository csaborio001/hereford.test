<?php
/**
 * Allows the creation of coloured boxes.
 *
 * @package stillbirth-cre
 */

namespace HerefordNetAu\Blocks;

use HerefordNetAu\Blocks\ColourHerefordNetAuoxes;
/**
 * BlockRegister registers all the blocks by creating new instances of them.
 */
class BlockRegister {
	/**
	 * Should be invoked in the init hook. Registers the blocks that will be used
	 * in the project.
	 */
	public static function register_stillbirth_blocks() {
		$cb = new ColourHerefordNetAuoxes();
	}
}
