<?php
namespace StarterPlugin;

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

		$plugin_name          = '"' . Setup::get_plugin_name() . '"';
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
			__( '%1$s requires the following plugins: %2$s.', 'starter-plugin' ) :
			__( '%1$s requires the %2$s plugin.', 'starter-plugin' );
		$message = sprintf( $message, $plugin_name, $missing_requirements );

		Admin\Notice::render( $message, 'error' );

		return true;
	}
}
