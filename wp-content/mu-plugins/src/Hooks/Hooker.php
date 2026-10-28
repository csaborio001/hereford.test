<?php
/**
 * Hooks most of the actions and filters in the system.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\Hooks;

use HerefordNetAu\CPT\ContentTypeCreator;
use HerefordNetAu\Endpoints\MDRRestServer;
use HerefordNetAu\ACF\ACFLoader;
use ScorpioTek\WPUtil\Hooks\WPHooker;
use ScorpioTek\WPUtil\Logging\STLogger;

class Hooker extends WPHooker {
	public function __construct( $auto_register = true ) {
		parent::__construct();
		$this->setup_content_types_hooks();
		$this->setup_acf_admin_hooks();
		if ( $auto_register ) {
			$this->register_hooks();
		}
	}

	private function setup_content_types_hooks() {
		if ( class_exists( ContentTypeCreator::class ) ) {
			$this->af_registration->add_action( 'init', ContentTypeCreator::class, 'content_types_init' );
		} elseif ( WP_DEBUG ) {
			STLogger::error( 'INFRASTRUCTURE ERROR: Class ContentTypeCreator could not be found.' );
		}
	}

	/**
	 * Uses the ACFLoader class to create all the fields that are used by the CPT
	 * in the WPAdmin interface.
	 *
	 * @return void
	 */
	private function setup_acf_admin_hooks() {
		$field_builder_collection = array();

		if ( class_exists( ACFLoader::class ) ) {
			$acf_loader               = new ACFLoader();
			$field_builder_collection = $acf_loader->get_field_builder_collection();

			if ( ! is_array( $field_builder_collection ) ) {
				STLogger::error( 'ACFLoader returned non-array field builder collection.' );
				$field_builder_collection = array();
			}

			set_transient(
				'field_builder_collection',
				$field_builder_collection,
				4 * WEEK_IN_SECONDS
			);
		} else {
			STLogger::error( 'WPHooker ERROR: Class ACFLoader could not be found.' );
		}

		foreach ( $field_builder_collection as $field_builder ) {
			if ( ! is_object( $field_builder ) ) {
				STLogger::error( 'Invalid field builder in collection.' );
				continue;
			}

			$this->af_registration->add_action(
				'acf/init',
				$field_builder,
				'register_fields'
			);
		}
	}

	private function setup_website_endpoints() {
		$mdr_rest_server = new MDRRestServer( 'mdr' );
		$this->af_registration->add_action( 'rest_api_init', $mdr_rest_server, 'register_routes', 10, 1 );
	}
}
