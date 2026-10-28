<?php
/**
 * Allows the creation of coloured boxes.
 *
 * @package stillbirth-cre
 */

namespace HerefordNetAu\Blocks;

use ScorpioTek\WPUtil\Blocks\ScorpioTekBlocks;
/**
 * Creates the Gutenberg block for adding coloured boxes that adjust to mobile.
 */
class ColouredBoxes extends ScorpioTekBlocks {
	public function __construct() {
		parent::__construct(
			'coloured-boxes',
			'Coloured Boxes',
			'Lots of Coloured Boxes',
			'oxygen-vsb-blocks',
			'images-alt',
		);
		$this->create_fields();
		$this->register();
	}

	public function create_fields() {
		$this->fields_builder
		->addRepeater(
			'coloured_boxes_repeater',
			array(
				'label'        => 'Coloured Boxes',
				'instructions' => 'Use this space to add/remove boxes.',
				'layout'       => 'block',
				'button_label' => 'Add Additional Box',
				'min'          => 1,
			)
		)
		->addColorPicker(
			'color',
			array(
				'label'    => 'Select the box color',
				'required' => 1,
				'instructions' => 'Pink = #d16d94, Dark Blue = #00427f, Green = #91923A',
			)
		)
		->addText(
			'text',
			array(
				'label'         => 'Text to Display',
				'instructions'  => 'Do stuff',
				'required'      => 1,
				'default_value' => 'Text to Display',
			)
		)
		->addImage(
			'image',
			array(
				'label' => 'Display Image',
				'required' => 1,
			)
		)
		->addURL(
			'url',
			array(
				'label' => 'Target Link',
				'required' => 1,
			)
		);
	}

	public function callback() {
		/** Styles */ ?>
		<style type="text/css">
			.coloured-box-text {
				color: #ebf0f5;
				padding-top: 30px;
				padding-bottom: 30px;
				text-align: center;
				font-size: 22px;
			}


			.coloured-boxes-container {
				flex-direction: row;
				display: flex;
				justify-content: space-between;
				text-align: justify;
				flex-wrap: wrap;
				padding-bottom: 114px;
			}

			.coloured-boxes-container a {
				width: 30%;
				margin-bottom: 30px;
			}
			/** Sets the animation of the image when mouse enters div. */
			.coloured-box:hover .coloured-box-image img {
				transform: scale(1.2);
			}

			.coloured-box-image {
				line-height: 0;
				overflow: hidden;
			}

			.coloured-box-image img {
				transition: all 0.3s;
			}
		</style>
		<?php
		if( have_rows( 'coloured_boxes_repeater' ) ): ?>
			<div class="coloured-boxes-container">
			<?php while( have_rows('coloured_boxes_repeater') ) : the_row();
				$text   = \get_sub_field( 'text' );
				$colour = \get_sub_field( 'color' );
				$image  = \get_sub_field( 'image' )['sizes']['medium_large'];
				$url    = \get_sub_field( 'url' );
				?>
				<a href="<?php echo $url ?>">
					<div class="coloured-box" style="">
						<div class="coloured-box-image">
							<img src="<?php echo $image ?>" />
						</div>
						<div class ="coloured-box-text" style="background-color:<?php echo $colour; ?>">
							<?php echo $text; ?>
						</div>
					</div>
				</a>
			<?php endwhile; ?>
			</div>
		<?php endif;
	}
}
