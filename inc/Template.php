<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

final class Template {
	private const TEMPLATE_DIR = 'template';

	public static function get(string $name, array $args = []): string {
		ob_start();
		include get_path(self::TEMPLATE_DIR . "/$name.php");

		return ob_get_clean();
	}

	public static function render(string $name, array $args = []): void {
		echo self::get($name, $args); // phpcs:ignore
	}
}
