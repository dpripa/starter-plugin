<?php
namespace MyPlugin\Helper;

defined( 'ABSPATH' ) || exit;

trait GenerateRandom {
	public static function generate_random(
		int $length = 16,
		string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
	): string {
		$pieces = array();
		$max    = mb_strlen( $keyspace, '8bit' ) - 1;

		for ( $i = 0; $i < $length; ++ $i ) {
			$pieces[] = $keyspace[ random_int( 0, $max ) ];
		}

		return implode( '', $pieces );
	}
}
