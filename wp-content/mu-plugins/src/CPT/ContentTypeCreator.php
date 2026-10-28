<?php
/**
 * Registers the content types used in this website project.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\CPT;

use ScorpioTek\WPUtil\CPT\CPTCreator;
use ScorpioTek\WPUtil\CPT\TaxonomyCreator;

class ContentTypeCreator {
	/**
	 * Invoked from the init hook. Generates the content types for the website.
	 *
	 * @return void
	 */
	public static function content_types_init() {
		/** Create Taxonomies. **/
		$taxonomy_creator = new TaxonomyCreator(
			'attributes',
			array(
				'mdr_dog',
				'mdr_bonded_dog_pair',
			),
			'Attribute',
			'Attributes',
		);
		$taxonomy_creator->build();
		$content_type_creator = new CPTCreator( 'mdr_dog' );
		$content_type_creator->set_labels( 'Dog', 'dogs' );
		$content_type_creator->set_map_meta_cap( true );
		$content_type_creator->set_capability_type( 'dog' );
		$content_type_creator->set_public( true );
		$content_type_creator->set_show_ui( true );
		$content_type_creator->set_has_archive( true );
		$content_type_creator->set_show_in_menu( true );
		$content_type_creator->set_supports( array( 'title', 'thumbnail' ) );
		$content_type_creator->set_menu_icon( 'fas fa-paw' );
		$content_type_creator->set_slug( 'dogs' );
		$content_type_creator->build();
	}
}
