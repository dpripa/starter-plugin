<?php
namespace MyPlugin\Helper;

defined( 'ABSPATH' ) || exit;

trait DashToCamelcase {
	public static function dash_to_camelcase( string $string, bool $ucfirst = false ): string {
		$words    = explode( '-', $string );
		$words    = array_map( 'ucfirst', $words );
		$words[0] = $ucfirst ? ucfirst( $words[0] ) : lcfirst( $words[0] );

		return implode( '', $words );
	}
}
