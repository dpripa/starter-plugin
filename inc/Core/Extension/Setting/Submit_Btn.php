<?php

namespace MyPlugin\Core\Extension\Setting;

defined( 'ABSPATH' ) || exit;

class Submit_Btn {

	public static function render( ?string $btn_title ): void {
		if ( empty( $btn_title ) ) {
			return;
		}
		?>
		<button class="c0r3-submit-btn button button-primary" disabled>
			<?php echo esc_html( $btn_title ); ?>
		</button>
		<?php
	}
}
