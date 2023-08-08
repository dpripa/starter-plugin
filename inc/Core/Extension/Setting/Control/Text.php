<?php

namespace MyPlugin\Core\Extension\Setting\Control;

defined( 'ABSPATH' ) || exit;

class Text extends Control {

	protected static $default_args = array(
		'placeholder' => '',
		'width'       => 300,
	);

	public static function render( string $type, string $name, /* mixed */ $value, ?string $title, array $args ): void {
		if ( 'number' === $type && empty( $args['width'] ) ) {
			$args['width'] = 90;
		}

		$args = wp_parse_args(
			$args,
			wp_parse_args(
				static::$default_args,
				static::$default_base_args
			)
		);
		?>
		<div class="c0r3-control-text">
			<input
				type="<?php echo esc_attr( $type ); ?>"
				id="<?php echo esc_attr( $name ); ?>"
				name="<?php echo esc_attr( $name ); ?>"
				value="<?php echo esc_attr( $value ); ?>"
				<?php
				static::placeholder( $args );
				static::required( $args );
				?>
				style="<?php static::width( $args, $type ); ?>"
			>
			<?php static::render_description( $args ); ?>
		</div>
		<?php
	}

	protected static function width( array $args, ?string $type = null ): void {
		echo 'width:' . esc_attr( $args['width'] ) . 'px;';
	}
}
