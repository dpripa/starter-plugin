<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

abstract class StaticClass {
	protected static $is_initialized = false;

	protected function is_initialized(): bool {
		if (self::$is_initialized) {
			throw new \Exception('Can only be initialized once');
		}

		$is_initialized = self::$is_initialized;
		self::$is_initialized = true;

		return $is_initialized;
	}
}
