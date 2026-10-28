<?php
/**
 * Contains the functionality to create the capabilities for all roles in the system.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\Capabilities;

use ScorpioTek\WPUtil\CapBuilder;
use ScorpioTek\WPUtil\RoleConfig;

/**
 * Exposes all the methods that allow the customization of the admin interface.
 */
class CapabilitiesCreator {

	public function create_capabilities() {
		// Only use the line below to reset everything, comment afterwards.
		// $this->delete_roles();
		$this->create_vinnies_connect_administrator_role();
		$this->create_vinnies_connect_manager_role();
		$this->create_area_coordinator_role();
		$this->create_intake_eng_officer_role();
		$this->create_external_roles();

	}

	private function delete_roles() {
		RoleConfig::remove_roles(
			array(
				'vinnies_connect_administrator',
				'vinnies_connect_manager',
				'area_coordinator',
				'intake_eng_officer',
				'referrer',
				'client',
				'volunteer',
			)
		);
	}

	private function create_vinnies_connect_administrator_role() {
		$role_config = new RoleConfig( 'vinnies_connect_administrator' );
		$cap_builder = new CapBuilder(
			array(
				'clients',
				'volunteers',
				'referrers',
				'intake_eng_officers',
				'area_coordinators',
				'matches',
				'pages',
				'lgas',
				'announcements',
				'triggers',
			)
		);

		$role_config->add_allow_capabilities(
			array_merge(
				$cap_builder->get_basic_editor_caps(),
				$cap_builder->construct_capabilities( 'full' ),
				$cap_builder->get_user_admin_caps(),
				$cap_builder->get_media_full(),
				$cap_builder->get_cap_users_full(),
			)
		);
		$role_config->register_role();
	}

	private function create_vinnies_connect_manager_role() {
		$role_config = new RoleConfig( 'vinnies_connect_manager' );
		$cap_builder = new CapBuilder(
			array(
				'clients',
				'volunteers',
				'referrers',
				'intake_eng_officers',
				'area_coordinators',
				'matches',
				'pages',
				'lgas',
				'announcements',
				'triggers',
			)
		);

		$role_config->add_allow_capabilities(
			array_merge(
				$cap_builder->get_basic_editor_caps(),
				$cap_builder->construct_capabilities( 'edit_others' ),
				$cap_builder->get_media_full(),
				$cap_builder->get_cap_edit_users(),
			)
		);
		$role_config->register_role();
	}

	private function create_area_coordinator_role() {
		$role_config = new RoleConfig( 'area_coordinator' );
		$cap_builder = new CapBuilder(
			array(
				'clients',
				'volunteers',
				'matches',
			)
		);

		$role_config->add_allow_capabilities(
			array_merge(
				$cap_builder->get_basic_editor_caps(),
				$cap_builder->construct_capabilities( 'edit_others' ),
				$cap_builder->get_media_full(),
			)
		);
		$role_config->register_role();
	}

	private function create_intake_eng_officer_role() {
		$role_config = new RoleConfig( 'intake_eng_officer' );
		$cap_builder = new CapBuilder(
			array(
				'clients',
				'volunteers',
				'matches',
				'referrers',
			)
		);

		$role_config->add_allow_capabilities(
			array_merge(
				$cap_builder->get_basic_editor_caps(),
				$cap_builder->construct_capabilities( 'edit_others' ),
				$cap_builder->get_media_full(),
			)
		);
		$role_config->register_role();
	}

	private function create_external_roles() {
		$role_config = new RoleConfig( 'referrer' );
		$role_config->register_role();
		$role_config = new RoleConfig( 'client' );
		$role_config->register_role();
		$role_config = new RoleConfig( 'volunteer' );
		$role_config->register_role();
	}
}
