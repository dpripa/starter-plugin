<?php

namespace MyPlugin\Core;

defined('ABSPATH') || exit;

interface App {
	public function get_key(string $key = ''): string;
	public function get_root_file(): string;
	public function is_theme(): bool;
}
