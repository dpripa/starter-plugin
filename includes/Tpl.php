<?php
namespace MyPlugin;

defined( 'ABSPATH' ) || exit;

class Tpl {
	protected const DIR = 'templates';

	public static function get( string $name, array $args = array() ): string { // phpcs:ignore
		ob_start();
		include Fs::get_path( static::DIR . "/$name.php" );

		return ob_get_clean();
	}

	public static function render( string $name, array $args = array() ): void {
		echo wp_kses_post( static::get( $name, $args ) );
	}
}
