<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined( 'ABSPATH' ) || exit;

class I18n {
	protected $app;
	protected $fs;
	protected $args;

	public function __construct( App $app, FS $fs, array $args = array() ) {
		$this->app  = $app;
		$this->fs   = $fs;
		$this->args = wp_parse_args(
			$args,
			array(
				'dirname' => 'lang',
			)
		);

		if ( $this->app->is_theme() ) {
			add_action(
				'after_setup_theme',
				function (): void {
					load_theme_textdomain( $this->app->get_key(), $this->get_path() );
				},
				1
			);

		} else {
			add_action(
				'plugins_loaded',
				function (): void {
					load_plugin_textdomain( $this->app->get_key(), false, $this->get_path() );
				},
				1
			);
		}
	}

	public function get_path( bool $rel = false ): string {
		return $rel ? $this->args['dirname'] : $this->fs->get_path( $this->args['dirname'] );
	}

	public function get_url(): string {
		return $this->fs->get_url( $this->args['dirname'] );
	}

	public function localize_script( string $script_name ): self {
		wp_set_script_translations( $this->app->get_key( $script_name ), $this->app->get_key(), $this->get_path() );

		return $this;
	}

	public function __( string $text ): string {
		return translate( $text, $this->app->get_key() ); // phpcs:ignore
	}

	public function _x( string $text, string $context ): string { // phpcs:ignore
		return translate_with_gettext_context( $text, $context, $this->app->get_key() ); // phpcs:ignore
	}

	public function _n( string $single, string $plural, int $number ): string { // phpcs:ignore
		return _n( $single, $plural, $number, $this->app->get_key() ); // phpcs:ignore
	}
}
