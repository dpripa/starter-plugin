<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

final class Setup extends StaticClass {
	public function __construct() {
		if ($this->is_initialized()) {
			return;
		}

		add_action('plugins_loaded', [$this, 'init']);
	}

	public function init(): void {
		load_plugin_textdomain(KEY, false, get_path('lang'));
		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
	}

	public function enqueue_assets(): void {}
}
