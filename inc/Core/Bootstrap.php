<?php

namespace MyPlugin\Core;

defined('ABSPATH') || exit;

trait Bootstrap {
	private static $instance;

	public static function get_instance(string $namespace, string $root_file): self {
		if (empty(self::$instance)) {
			self::$instance = new self($namespace, $root_file);
		}

		return self::$instance;
	}

	private function __construct(string $namespace, string $root_file) {}

	private $is_theme;
	private $key;
	private $root_file;
	private $daemon;
	private $initialized_setups = [];

	private function init(string $namespace, string $root_file, bool $is_theme = false): void {
		$this->is_theme = $is_theme;
		$this->key = strtolower($namespace);
		$this->root_file = $root_file;
		$this->daemon = Daemon\App::get_instance();
	}

	public function validate_setup(string $classname): bool {
		$has_instance = in_array($classname, $this->initialized_setups, true);

		$this->initialized_setups[] = $classname;

		if (defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY) {
			$reflection = new \ReflectionClass($classname);

			if (!$reflection->isFinal()) {
				throw new \Exception("The $classname class associated with setup scope must be final.");
			}

			if ($has_instance) {
				throw new \Exception("The $classname class associated with the setup scope must have just one instance call.");
			}
		}

		return $has_instance;
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
