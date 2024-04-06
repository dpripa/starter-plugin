<?php
namespace MyPlugin\Plugin;

use const MyPlugin\KEY;
use const MyPlugin\ROOT_FILE;

defined( 'ABSPATH' ) || exit;

class Dep {
	public static function validate( array $deps ): bool {
		if ( empty( $deps ) ) {
			return false;
		}

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_data  = \get_plugin_data( ROOT_FILE );
		$plugin_name  = '"' . $plugin_data['Name'] . '"';
		$missing_deps = '';

		foreach ( $deps as $dep_classname => $dep_title ) {
			if ( ! class_exists( $dep_classname ) ) {
				$missing_deps .= $missing_deps ? ", \"$dep_title\"" : "\"$dep_title\"";
			}
		}

		if ( empty( $missing_deps ) ) {
			return false;
		}

		$message = 1 < count( $deps ) ?
			__( '%1$s requires the following plugins: %2$s.', KEY ) :
			__( '%1$s requires the %2$s plugin.', KEY );
		$message = sprintf( $message, $plugin_name, $missing_deps );

		Notice::render( $message, 'error' );

		return true;
	}
}
