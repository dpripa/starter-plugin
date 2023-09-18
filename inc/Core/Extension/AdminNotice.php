<?php

namespace MyPlugin\Core\Extension;

use O0W7_1\App;

defined( 'ABSPATH' ) || exit;

class AdminNotice {
	protected $key;

	public function __construct( App $app ) {
		$this->key = $app->get_key( 'admin_transient_notices' );

		add_action( 'admin_init', $this->render_transients() );
	}

	public function render_transients(): callable {
		return function (): void {
			$notices = $this->get_transients();

			if ( empty( $notices ) ) {
				return;
			}

			foreach ( $notices as $level => $messages ) {
				foreach ( $messages as $message ) {
					self::render( $message, $level );
				}
			}

			$this->update_transients( array() );
		};
	}

	protected function get_transients(): array {
		return get_option( $this->key, array() );
	}

	protected function update_transients( array $notices ): void {
		update_option( $this->key, $notices );
	}

	public function add_transient( string $message, string $level = 'warning' ): void {
		$notices             = $this->get_transients();
		$notices[ $level ][] = $message;

		$this->update_transients( $notices );
	}

	public function render( string $message, string $level = 'warning' ): void {
		add_action(
			'admin_notices',
			function () use ( $message, $level ): void {
				?>
				<div class="notice notice-<?php echo esc_attr( $level ); ?> is-dismissible" style="padding-top: 10px; padding-bottom: 10px;">
					<?php echo wp_kses_post( $message ); ?>
				</div>
				<?php
			}
		);
	}
}
