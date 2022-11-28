<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

trait Simpleton {
	protected static $is_initialized = false;

	protected function is_initialized(): bool {
		if (static::$is_initialized) {
			throw new \Exception('Can only be initialized once');
		}

		$is_initialized = static::$is_initialized;
		static::$is_initialized = true;

		return $is_initialized;
	}
}
