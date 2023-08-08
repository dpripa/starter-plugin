<?php

namespace MyPlugin\Core;

defined( 'ABSPATH' ) || exit;

interface App {
	public function validate_setup( string $namespace): bool;
	public function get_key( string $key = ''): string;
	public function get_root_file(): string;
	public function is_theme(): bool;
}
