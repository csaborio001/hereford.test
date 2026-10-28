<?php
/**
 * Hooks most of the actions and filters in the system.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\Hooks;

use ScorpioTek\WPUtil\Hooks\WPHooker;
use ScorpioTek\WPUtil\Shortcodes\SearchShortCodes;
use ScorpioTek\WPUtil\Shortcodes\TaxonomyShortCodes;
use HerefordNetAu\Shortcodes\ShortCodesCreator;
use HerefordNetAu\Assets\AssetLoader;


class FrontEndHooker extends WPHooker {
	public function __construct( $auto_register = true ) {
		parent::__construct();
		$this->setup_frontend_assets();
		// $this->setup_frontend_shortcodes();
		if ( $auto_register ) {
			$this->register_hooks();
		}
	}

	private function setup_frontend_assets() {
		$asset_loader = new AssetLoader();
		$this->af_registration->add_action( 'wp_enqueue_scripts', $asset_loader, 'load_front_end_assets' );
		// $this->af_registration->add_action( 'init', TaxonomyShortCodes::class, 'initialize' );
		// $this->af_registration->add_action( 'init', ShortCodesCreator::class, 'initialize' );
		// $this->af_registration->add_action( 'init', SearchShortCodes::class, 'initialize' );
		// $this->af_registration->add_action( 'pre_get_posts', QueryMod::class, 'modify_query' );
	}
}
