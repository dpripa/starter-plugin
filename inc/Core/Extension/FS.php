<?php

namespace MyPlugin\Core\Extension;

use O0W7_1\App;

defined( 'ABSPATH' ) || exit;

class FS {
	protected $app;

	public function __construct( App $app ) {
		$this->app = $app;
	}

	public function get_url( string $rel = '', bool $stamp = false ): string {
		if ( $this->app->is_theme() ) {
			$url = get_theme_file_uri( $rel );

		} else {
			$url = plugin_dir_url( $this->app->get_root_file() );
			$url = $rel ? ( $url . $rel ) : rtrim( $url, '/\\' );
		}

		if ( $stamp ) {
			$path = $this->get_path( $rel );

			if ( ! file_exists( $path ) ) {
				return $url;
			}

			return add_query_arg( array( 'ver' => filemtime( $path ) ), $url );
		}

		return $url;
	}

	public function get_path( string $rel = '' ): string {
		if ( $this->app->is_theme() ) {
			$path = get_stylesheet_directory() . '/';

		} else {
			$path = plugin_dir_path( $this->app->get_root_file() );
		}

		return $rel ? "$path{$rel}" : rtrim( $path, '/\\' );
	}
}
