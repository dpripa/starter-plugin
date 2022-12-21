<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

final class Setup {
	public function __construct() {
		add_action('plugins_loaded', [$this, 'init']);
	}

	public function init(): void {
		load_plugin_textdomain(KEY, false, get_path('lang'));
		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
	}

	public function enqueue_assets(): void {}
}
