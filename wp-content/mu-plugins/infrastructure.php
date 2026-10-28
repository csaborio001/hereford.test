<?php
/**
 * Plugin Name: hereford-net-au Infrastructure
 * Description: Project assets and optional ACF integration.
 * Version: 0.1.0
 */

use ScorpioTek\WPUtil\Modules\ModuleLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; }
require_once __DIR__ . '/vendor/autoload.php';
add_action(
	'plugins_loaded',
	static function () {
		$assets = new HerefordNetAu\Assets\AssetLoader();
		add_action( 'wp_enqueue_scripts', array( $assets, 'load_front_end_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $assets, 'load_admin_assets' ) );
		// The base site must work with ACF inactive. Enable project hooks when needed.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			new HerefordNetAu\Hooks\Hooker();
		}
	}
);

if ( class_exists( ModuleLoader::class ) ) {
	$ml = new ModuleLoader(
		array(
			'LoginScreen',
			'MaintenanceMode',
			'ScorpioTekFancyUI',
		)
	);
}
