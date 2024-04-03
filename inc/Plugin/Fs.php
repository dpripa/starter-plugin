<?php
namespace MyPlugin\Plugin;

use const MyPlugin\ROOT_FILE;

defined( 'ABSPATH' ) || exit;

class Fs {
	protected const ROOT_FILE = ROOT_FILE;

	public static function get_url( string $rel = '', bool $stamp = false ): string {
		$url = plugin_dir_url( static::ROOT_FILE );
		$url = $rel ? ( $url . $rel ) : rtrim( $url, '/\\' );

		if ( $stamp ) {
			$path = static::get_path( $rel );

			if ( ! file_exists( $path ) ) {
				return $url;
			}

			return add_query_arg( array( 'ver' => filemtime( $path ) ), $url );
		}

		return $url;
	}

	public static function get_path( string $rel = '' ): string {
		$path = plugin_dir_path( static::ROOT_FILE );

		return $rel ? "$path{$rel}" : rtrim( $path, '/\\' );
	}

	public static function write( string $path, string $content ): string {
		$output = error_log( '/*test*/', '3', $path ); // phpcs:ignore

		if ( $output ) {
			unlink( $path );
			error_log( $content, '3', $path ); // phpcs:ignore
			chmod( $path, 0600 );
		}

		return $output;
	}

	public static function read( string $path ): string {
		if ( file_exists( $path ) ) {
			$file     = fopen( $path , 'r' ); // phpcs:ignore
			$response = '';

			fseek( $file, -1048576, SEEK_END );

			while ( ! feof( $file ) ) {
				$response .= fgets( $file );
			}

			fclose( $file ); // phpcs:ignore

			return $response;
		}

		return '';
	}
}
