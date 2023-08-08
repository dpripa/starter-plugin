<?php

namespace MyPlugin\Core\Extension\Setting\Control;

defined( 'ABSPATH' ) || exit;

abstract class Base_Control {

	protected static $default_base_args = array(
		'description' => '',
		'width'       => 300,
		'placeholder' => '',
		'required'    => false,
	);

	abstract public static function render( string $type, string $name, /* mixed */ $value, ?string $title, array $args ): void;

	protected static function render_description( array $args ): void {
		$args = wp_parse_args( $args, static::$default_base_args );

		if ( $args['description'] ) {
			?>
			<div class="c0r3-description">
				<?php echo wp_kses_post( $args['description'] ); ?>
			</div>
			<?php
		}
	}

	protected static function width( array $args, ?string $type = null ): void {
		$args = wp_parse_args( $args, static::$default_base_args );

		echo 'width:' . esc_attr( $args['width'] ) . 'px;';
	}

	protected static function placeholder( array $args ): void {
		$args = wp_parse_args( $args, static::$default_base_args );

		if ( $args['placeholder'] ) {
			echo 'placeholder="' . esc_attr( $args['placeholder'] ) . '"';
		}
	}

	protected static function required( array $args ): void {
		$args = wp_parse_args( $args, static::$default_base_args );

		if ( $args['required'] ) {
			echo 'required';
		}
	}
}
