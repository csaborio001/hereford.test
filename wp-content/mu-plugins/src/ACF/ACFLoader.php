<?php
/**
 * Loads all the ACF fields used in the website.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\ACF;

class ACFLoader {
	/**
	 * Holds all the FieldsBuilder fields so that they can be registered in batch.
	 *
	 * @var array field_builder_collection
	 */
	private $field_builder_collection = array();

	public function __construct() {
		$this->setup_guests_fields();
	}

	private function setup_guests_fields() {
		// $gfb = new GuestsFieldsBuilder( 'post_type', '=', 'aipa_guest' );
		// $gfb->add_last_name_field();
		// $this->field_builder_collection[] = $gfb;
	}

	/**
	 * Setter for the field_builder_collection property.
	 *
	 * @param string $field_builder_collection the new value of the field_builder_collection property.
	 */
	public function set_field_builder_collection( $field_builder_collection ) {
		$this->field_builder_collection = $field_builder_collection;
		return $this->get_field_builder_collection();
	}
	/**
	 * Getter for the field_builder_collection property.
	 *
	 * @return string - the value of the field_builder_collection property.
	 */
	public function get_field_builder_collection() {
		return $this->field_builder_collection;
	}
}
