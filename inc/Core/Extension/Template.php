<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined('ABSPATH') || exit;

class Template {
	protected $app;
	protected $fs;
	protected $args;

	public function __construct(App $app, FS $fs, array $args = []) {
		$this->app = $app;
		$this->fs = $fs;
		$this->args = wp_parse_args(
			$args,
			[
				'template_dir' => $app->is_theme() ? 'template-part' : 'template',
			]
		);
	}

	public function get(string $name, array $args = []): string {
		ob_start();

		if ($this->app->is_theme()) {
			$this->render($name, $args);

		} else {
			include $this->fs->get_path("{$this->args['template_dir']}/$name.php");
		}

		return ob_get_clean();
	}

	public function render(string $name, array $args = []): void {
		if ($this->app->is_theme()) {
			get_template_part("{$this->args['template_dir']}/$name", null, $args);

		} else {
			echo $this->get($name, $args); // phpcs:ignore
		}
	}
}
