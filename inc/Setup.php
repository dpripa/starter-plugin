<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

final class Setup {
	public function __construct() {
		if (app()->validate_setup(self::class)) {
			return;
		}

		add_action('plugins_loaded', [$this, 'init']);
	}

	public function init(): void {
		new Setting();

		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
	}

	public function enqueue_assets(): void {
		app()->asset->enqueue_style('main');
		app()->asset->enqueue_script('main');
	}
}
