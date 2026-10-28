<?php
/**
 * Hooks most of the actions and filters in the system.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\Hooks;

use HerefordNetAu\ACF\ACFLoader;

use HerefordNetAu\Assets\AssetLoader;
use HerefordNetAu\Menus\AdminMenuModifier;
use ScorpioTek\WPUtil\Hooks\WPHooker;
use ScorpioTek\WPUtil\Logging\StreamLogger;

class AdminHooker extends WPHooker {
	public function __construct( $auto_register = true ) {
		parent::__construct();

		// $this->setup_wp_admin_menu();
		//  $this->setup_post_editor_changes();
		 $this->setup_wp_admin_assets();
		// $this->setup_website_options();
		// $this->setup_media_hooks();
		if ( $auto_register ) {
			$this->register_hooks();
		}
	}

	private function setup_website_options() {
		$settings_fields_builder = new SettingsFieldsBuilder( 'Website Settings' );
		$this->af_registration->add_filter( 'acf/init', $settings_fields_builder, 'init_options' );
		/** Fills out default website settings */
		if ( 'executed' !== \get_option( 'mdr_default_settings' ) ) {
			$this->af_registration->add_filter( 'acf/init', SettingsImporter::class, 'import_settings' );
			\add_option( 'mdr_default_settings', 'executed' );
		}
	}

	/**
	 * All media-related hooks such as thumbnail generation.
	 */
	private function setup_media_hooks() {
		$this->af_registration->add_filter( 'image_size_names_choose', ImageSizes::class, 'register_gutenberg_images' );
	}

	private function setup_wp_admin_assets() {
		$asset_loader = new AssetLoader();
		$this->af_registration->add_action( 'admin_enqueue_scripts', $asset_loader, 'load_admin_assets' );
	}
}
