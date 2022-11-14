<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

trait Simpleton {
	private static $is_initialized = false;

	private function is_initialized(): bool {
		if (self::$is_initialized) {
			throw new \Exception('Can only be initialized once');
		}

		$is_initialized = self::$is_initialized;
		self::$is_initialized = true;

		return $is_initialized;
	}
}
