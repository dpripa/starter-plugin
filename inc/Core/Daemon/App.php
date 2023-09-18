<?php

namespace MyPlugin\Core\Daemon;

defined( 'ABSPATH' ) || exit;

final class App implements \O0W7_1\App {
	use \O0W7_1\Helper\Singleton;

	private $key;
	private $root_file;

	public $fs;
	public $asset;
	public $hook;
	public $url;

	private function __construct() {
		$str             = \O0W7_1\Extension\Str::get_instance();
		$this->key       = $str->generate_random();
		$this->root_file = str_replace( 'Daemon', 'Bootstrap.php', __DIR__ );
		$this->fs        = new \O0W7_1\Extension\FS( $this );
		$this->asset     = new \O0W7_1\Extension\Asset( $this, $this->fs );
		$this->hook      = new \O0W7_1\Extension\Hook( $this );
		$this->url       = \O0W7_1\Extension\Url::get_instance();
	}

	public function validate_setup( string $namespace ): bool {
		return false;
	}

	public function get_key( string $key = '' ): string {
		return $this->key;
	}

	public function get_root_file(): string {
		return $this->root_file;
	}

	public function is_theme(): bool {
		return false;
	}
}
