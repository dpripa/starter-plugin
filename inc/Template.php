<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

final class Template extends StaticClass {
	public static function get(string $name, array $args = []): string {
		ob_start();
		include get_path("template/$name.php");

		return ob_get_clean();
	}

	public static function render(string $name, array $args = []): void {
		echo self::get($name, $args); // phpcs:ignore
	}
}
