<?php

namespace MyPlugin\Core\Extension;

use O0W7_1\App;

defined( 'ABSPATH' ) || exit;

class Hook {
	protected $app;

	public function __construct( App $app ) {
		$this->app = $app;
	}

	public function apply_filters( string $slug, /* mixed */ ...$args ) /* mixed */ {
		return apply_filters( $this->app->get_key( $slug ), ...$args );
	}

	public function add_filter( string $slug, callable $callback, int $priority = 10, int $accepted_args = 1 ): void {
		add_filter( $this->app->get_key( $slug ), $callback, $priority, $accepted_args );
	}

	public function do_action( string $slug, /* mixed */ ...$args ): void {
		do_action( $this->app->get_key( $slug ), ...$args );
	}

	public function add_action( string $slug, callable $callback, int $priority = 10, int $accepted_args = 1 ): void {
		add_action( $this->app->get_key( $slug ), $callback, $priority, $accepted_args );
	}

	public function add_activation( callable $callback ): void {
		if ( $this->app->is_theme() ) {
			add_action( 'after_switch_theme', $callback, 10, 2 );

		} else {
			register_activation_hook( $this->app->get_root_file(), $callback );
		}
	}

	public function add_deactivation( callable $callback ): void {
		if ( $this->app->is_theme() ) {
			add_action( 'switch_theme', $callback, 10, 3 );

		} else {
			register_deactivation_hook( $this->app->get_root_file(), $callback );
		}
	}
}
