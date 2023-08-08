<?php

namespace MyPlugin\Core\Extension\Setting\Control;

defined( 'ABSPATH' ) || exit;

class Select extends Control {

	protected static $default_args = array(
		'options'  => array(),
		'multiple' => false,
	);

	public static function render( string $type, string $name, /* array|string|null */ $value, ?string $title, array $args ): void { // phpcs:ignore
		$args = wp_parse_args(
			$args,
			wp_parse_args(
				static::$default_args,
				static::$default_base_args
			)
		);
		?>
		<div class="c0r3-control-select">
			<select
				id="<?php echo esc_attr( $name ); ?>"
				name="<?php echo esc_attr( $name ) . ( $args['multiple'] ? '[]' : '' ); ?>"
				<?php
				echo $args['multiple'] ? 'multiple' : '';
				static::multiple_placeholder( $args );
				static::required( $args );
				?>
				style="<?php static::width( $args ); ?>"
			>
				<?php
				static::placeholder( $args );

				foreach ( $args['options'] as $option_key => $option_title ) {
					?>
					<option
						value="<?php echo esc_attr( $option_key ); ?>"
						<?php static::selected( $option_key, $value ); ?>
					>
						<?php echo esc_html( $option_title ); ?>
					</option>
					<?php
				}
				?>
			</select>
			<?php static::render_description( $args ); ?>
		</div>
		<?php
	}

	protected static function selected( string $option_key, /* array|string|null */ $value ): void { // phpcs:ignore
		echo is_array( $value ) ?
			( in_array( $option_key, $value, true ) ? 'selected' : '' ) :
			( $option_key === $value ? 'selected' : '' );
	}

	protected static function multiple_placeholder( array $args ): void {
		if ( $args['placeholder'] && $args['multiple'] ) {
			echo 'data-placeholder="' . esc_attr( $args['placeholder'] ) . '"';
		}
	}

	protected static function placeholder( array $args ): void {
		if ( $args['placeholder'] && ! $args['multiple'] ) {
			?>
			<option value="" disabled selected hidden>
				<?php echo esc_html( $args['placeholder'] ); ?>
			</option>
			<?php
		}
	}
}
