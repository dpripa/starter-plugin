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

	private $key;
	private $root_file;
	private $env;
	private $daemon;

	private function init(string $namespace, string $root_file): void {
		$this->key = strtolower($namespace);
		$this->root_file = $root_file;
		$root_file_path_parts = explode(DIRECTORY_SEPARATOR, $root_file);
		$parent_dir_number = count($root_file_path_parts) - 3;
		$isset_root_dir = isset($root_file_path_parts[$parent_dir_number]);

		if ($isset_root_dir && 'plugins' === $root_file_path_parts[$parent_dir_number]) {
			$this->env = 'plugin';

		} elseif ($isset_root_dir && 'themes' === $root_file_path_parts[$parent_dir_number]) {
			$this->env = 'theme';

		} else {
			throw new \Exception('It looks like you are trying to pass a root file that isn\'t associated with either the theme or the plugin');
		}

		$this->daemon = Daemon::get_instance();
	}

	public function get_key(string $key = ''): string {
		return str_replace('_', '-', $this->key . ($key ? ("_$key") : ''));
	}

	public function get_root_file(): string {
		return $this->root_file;
	}

	public function is_theme(): bool {
		return 'theme' === $this->env;
	}
}
