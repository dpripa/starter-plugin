<?php

namespace MyPlugin\Core\Daemon;

use MyPlugin\Core;

defined('ABSPATH') || exit;

final class App implements Core\App {
	use Core\Helper\Singleton;

	private $key;
	private $root_file;

	public $fs;
	public $asset;

	private function __construct() {
		$str = Core\Extension\Str::get_instance();
		$this->key = $str->generate_random();
		$this->root_file = str_replace('Daemon', 'Bootstrap.php', __DIR__);
		$this->fs = new Core\Extension\FS($this);
		$this->asset = new Core\Extension\Asset($this, $this->fs);
	}

	public function get_key(string $key = ''): string {
		return $this->key;
	}

	public function get_root_file(): string {
		return $this->root_file;
	}

	public function is_theme(): bool {
		return false;
	}
}
