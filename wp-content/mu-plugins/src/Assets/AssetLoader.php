<?php
namespace HerefordNetAu\Assets;

class AssetLoader {
	private function style( string $name ): void {
		$file = WPMU_PLUGIN_DIR . '/dist/css/' . $name . '.min.css';
		if ( is_file( $file ) ) {
			wp_enqueue_style( 'hereford-net-au-' . $name, WPMU_PLUGIN_URL . '/dist/css/' . $name . '.min.css', array(), (string) filemtime( $file ) );
		}
	}
	public function load_front_end_assets(): void {
		$this->style( 'hereford-net-au-variables' );
		$this->style( 'hereford-net-au' );
		foreach ( glob( WPMU_PLUGIN_DIR . '/dist/scripts/*.min.js' ) ?: array() as $file ) {
			wp_enqueue_script( 'hereford-net-au-' . basename( $file ), WPMU_PLUGIN_URL . '/dist/scripts/' . basename( $file ), array(), (string) filemtime( $file ), true );
		}
	}
	public function load_admin_assets(): void {
		$this->style( 'st-admin-styles' ); }
}
