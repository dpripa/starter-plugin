<?php

namespace MyPlugin\Core\Extension\Setting\Control;

defined( 'ABSPATH' ) || exit;

class Textarea extends Control {

	protected static $default_args = [];

	public static function render( string $type, string $name, /* mixed */ $value, ?string $title, array $args ): void {
		$args = wp_parse_args(
			$args,
			wp_parse_args(
				static::$default_args,
				static::$default_base_args
			)
		);
		?>
		<div class="c0r3-control-textarea">
			<textarea
				id="<?php echo esc_attr( $name ); ?>"
				name="<?php echo esc_attr( $name ); ?>"
				<?php static::placeholder( $args ); ?>
				style="<?php static::width( $args ); ?>"
			><?php echo esc_html( $value ); ?></textarea>
			<?php static::render_description( $args ); ?>
		</div>
		<?php
	}
}
