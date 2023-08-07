<?php

namespace MyPlugin\Core\Root;

use MyPlugin\Core\App;
use MyPlugin\Core\Extension;
use MyPlugin\Core\Helper\Singleton;

defined('ABSPATH') || exit;

final class Daemon implements App {
	use Singleton;

	private $key;
	private $root_file;

	public $fs;
	public $asset;

	private function __construct() {
		$str = Extension\Str::get_instance();
		$this->key = $str->generate_random();
		$this->root_file = __FILE__;
		$this->fs = new Extension\FS($this);
		$this->asset = new Extension\Asset($this, $this->fs);
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
