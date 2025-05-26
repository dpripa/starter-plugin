<?php
namespace OmgPlugin;

defined( 'ABSPATH' ) || exit;

class Env {
	protected array $dev_hosts = array(
		'localhost',
		'local',
		'loc',
		'development',
		'dev',
		'mamp',
	);

	protected array $dev_envs = array(
		'development',
		'local',
	);

	protected static bool $is_dev;

	public function __construct() {
		$host           = explode( '.', wp_parse_url( home_url(), PHP_URL_HOST ) );
		$root_host      = end( $host );
		static::$is_dev = in_array( $root_host, $this->dev_hosts, true ) ||
			in_array( wp_get_environment_type(), $this->dev_envs, true )
			|| ( defined( 'WP_ENVIRONMENT' ) && in_array( WP_ENVIRONMENT, $this->dev_envs, true ) );
	}

	public static function is_dev(): bool {
		return static::$is_dev;
	}
}
