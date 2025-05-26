<?php
namespace OmgPlugin\Helper;

defined( 'ABSPATH' ) || exit;

trait DashToCamelcase {
	public static function dash_to_camelcase( string $str, bool $ucfirst = false ): string {
		$words    = explode( '-', $str );
		$words    = array_map( 'ucfirst', $words );
		$words[0] = $ucfirst ? ucfirst( $words[0] ) : lcfirst( $words[0] );

		return implode( '', $words );
	}
}
