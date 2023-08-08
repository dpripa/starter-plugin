<?php

namespace MyPlugin\Core\Extension\Setting\Control;

defined( 'ABSPATH' ) || exit;

class Checkbox extends Control {

	protected static $default_args = [
		'options' => [],
	];

	public static function render( string $type, string $name, /* array|string|null */ $value, ?string $title, array $args ): void { // phpcs:ignore
		$args = wp_parse_args(
			$args,
			wp_parse_args(
				static::$default_args,
				static::$default_base_args
			)
		);
		?>
		<div class="c0r3-control-checkbox">
			<fieldset id="<?php echo esc_attr( $name ); ?>">
				<?php
				foreach ( $args['options'] as $option_key => $option_title ) {
					?>
					<div class="c0r3-control-checkbox__option">
						<label>
							<input
								type="checkbox"
								name="<?php echo esc_attr( "{$name}[$option_key]" ); ?>"
								<?php static::checked( $option_key, $value ); ?>
							>
							<?php echo wp_kses_post( is_array( $option_title ) ? ( $option_title[0] ?? '' ) : $option_title ); ?>
						</label>
						<?php if ( is_array( $option_title ) && isset( $option_title[1] ) ) { ?>
							<div class="c0r3-description">
								<?php echo wp_kses_post( $option_title[1] ); ?>
							</div>
						<?php } ?>
					</div>
					<?php
				}
				?>
			</fieldset>
			<?php static::render_description( $args ); ?>
		</div>
		<?php
	}

	protected static function checked( string $option_key, /* array|string|null */ $value ): void { // phpcs:ignore
		if ( is_array( $value ) && in_array( $option_key, array_keys( $value ), true ) ) {
			echo 'checked';
		}
	}
}
