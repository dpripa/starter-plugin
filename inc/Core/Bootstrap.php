<?php

namespace MyPlugin\Core;

defined('ABSPATH') || exit;

trait Bootstrap {
	private static $instance;

	public static function get_instance(string $namespace, $root_file): self {
		if (empty(self::$instance)) {
			self::$instance = new self($namespace, $root_file);
		}

		return self::$instance;
	}

	private $is_theme;
	private $key;
	private $root_file;
	private $daemon;

	private function init(string $namespace, string $root_file, bool $is_theme = false): void {
		$this->is_theme = $is_theme;
		$this->key = strtolower($namespace);
		$this->root_file = $root_file;
		$this->daemon = Daemon::get_instance();
	}

	public function get_key(string $key = ''): string {
		return str_replace('_', '-', $this->key . ($key ? ("_$key") : ''));
	}

	public function get_root_file(): string {
		return $this->root_file;
	}

	public function is_theme(): bool {
		return $this->is_theme;
	}
}
