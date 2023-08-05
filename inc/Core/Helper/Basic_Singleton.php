<?php

namespace MyPlugin\Core\Helper;

defined('ABSPATH') || exit;

trait Basic_Singleton {
	private static $instance;

	public static function get_instance(): self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {}
}
