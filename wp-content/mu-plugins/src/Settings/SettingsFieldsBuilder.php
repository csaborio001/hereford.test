<?php
/**
 * Create the fields that are part of the website settings.
 *
 * @package hereford-net-au
 */

namespace HerefordNetAu\Settings;

use ScorpioTek\WPUtil\ACF\OptionsBuilder;

class SettingsFieldsBuilder extends OptionsBuilder {
	public function add_options_fields() {
		$this->add_tab( 'News Settings', array() );
		$this->add_news_options_fields();
	}

	private function add_news_options_fields() {
		$this->add_settings_repeater_with_text(
			'News Category',
			'News Categories',
			'Category Name'
		);
	}

	/**
	 * Helper function that adds a repeater with a text field inside. This configuration
	 * is used repeatedly in the settings section.
	 *
	 * @param string $singular_name - The singular name of the repeater, will be used to name it.
	 * @param string $plural_name   - The plural name, used to display as label of repeater.
	 * @param string $row_header    - Optional, a string to display for the text element row header.
	 */
	private function add_settings_repeater_with_text( $singular_name, $plural_name, $row_header = '', $width = 50 ) {
		if ( empty( $row_header ) ) {
			$row_header = $singular_name;
		}
		$this->get_fields_builder()
		->addRepeater(
			'repeater_' . \strtolower( str_replace( ' ', '_', $plural_name ) ),
			array(
				'label'        => $plural_name,
				'instructions' => "Enter a {$singular_name} per line",
				'layout'       => 'table',
				'button_label' => "Add {$singular_name}",
				'wrapper'      => array(
					'width' => $width,
				),
			)
		)
		->addText(
			\strtolower( \str_replace( ' ', '_', $row_header ) ),
		);
	}
}
