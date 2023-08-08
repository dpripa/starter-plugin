<?php

namespace MyPlugin\Core\Extension\Setting\Control;

defined( 'ABSPATH' ) || exit;

abstract class Control extends Base_Control {

	public static function render_title( string $type, string $name, ?string $title, array $args, string $required_label ): void {
		$args = wp_parse_args( $args, static::$default_base_args );

		?>
		<label for="<?php echo esc_attr( $name ); ?>">
			<?php
			if ( $title ) {
				echo '<span class="c0r3-control__title-text">' . esc_html( $title ) . '</span>';
			}

			if ( isset( $args['required'] ) && true === $args['required'] ) {
				echo '<span class="c0r3-control__required">' . esc_html( $required_label ) . '</span>';
			}
			?>
		</label>
		<?php
	}
}
