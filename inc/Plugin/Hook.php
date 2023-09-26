<?php
namespace MainPlugin\Plugin;

use const MainPlugin\ROOT_FILE;

defined( 'ABSPATH' ) || exit;

class Hook {
	protected const NAMESPACE = __NAMESPACE__;

	public static function apply_filters( ?string $class, string $key, /* mixed */ ...$args ) /* mixed */ {
		return apply_filters( static::get_name( $class, $key ), ...$args );
	}

	public static function add_filter( ?string $class, string $key, callable $callback, int $priority = 10, int $accepted_args = 1 ): void {
		add_filter( static::get_name( $class, $key ), $callback, $priority, $accepted_args );
	}

	public static function do_action( string $class, string $key, /* mixed */ ...$args ): void {
		do_action( static::get_name( $class, $key ), ...$args );
	}

	public static function add_action( string $class, string $key, callable $callback, int $priority = 10, int $accepted_args = 1 ): void {
		add_action( static::get_name( $class, $key ), $callback, $priority, $accepted_args );
	}

	public static function add_activation( callable $callback ): void {
		register_activation_hook( ROOT_FILE, $callback );
	}

	public static function add_deactivation( callable $callback ): void {
		register_deactivation_hook( ROOT_FILE, $callback );
	}

	protected static function get_name( ?string $class, string $key ) {
		if ( empty( $class ) ) {
			$class = static::NAMESPACE;

		} else {
			if ( ! class_exists( $class ) ) {
				throw new \Exception( "Class \"$class\" in not exists" );
			}
		}

		return $class . '\\' . $key;
	}
}
