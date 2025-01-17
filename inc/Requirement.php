<?php
namespace MyPlugin;

use function get_plugin_data;

defined( 'ABSPATH' ) || exit;

class Requirement {
	protected static array $requirements = array();

	public static function add( string $classname_or_filename, string $title ): void {
		self::$requirements[ $classname_or_filename ] = $title;
	}

	public static function validate(): bool {
		if ( empty( static::$requirements ) ) {
			return false;
		}

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_data          = get_plugin_data( ROOT_FILE );
		$plugin_name          = '"' . $plugin_data['Name'] . '"';
		$missing_requirements = '';

		foreach ( static::$requirements as $classname_or_filename => $title ) {
			if ( ! class_exists( $classname_or_filename ) && ! is_plugin_active( $classname_or_filename ) ) {
				$missing_requirements .= $missing_requirements ? ", \"$title\"" : "\"$title\"";
			}
		}

		if ( empty( $missing_requirements ) ) {
			return false;
		}

		$message = 1 < count( static::$requirements ) ?
			__( '%1$s requires the following plugins: %2$s.', 'wc-jovvie-payments-gateway' ) :
			__( '%1$s requires the %2$s plugin.', 'wc-jovvie-payments-gateway' );
		$message = sprintf( $message, $plugin_name, $missing_requirements );

		Admin\Notice::render( $message, 'error' );

		return true;
	}
}
