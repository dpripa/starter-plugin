<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined('ABSPATH') || exit;

class Asset {
	protected $app;
	protected $fs;
	protected $args;

	public function __construct(App $app, FS $fs, array $args = []) {
		$this->app = $app;
		$this->fs = $fs;
		$this->args = wp_parse_args(
			$args,
			[
				'asset_dir' => 'asset',
				'script_dir' => 'script',
				'style_dir' => 'style',
				'postfix' => '.min',
			]
		);
	}

	public function enqueue_script(string $name, array $deps = [], array $args = [], bool $in_footer = true): void {
		$key = $this->app->get_key($name);
		$filename = "$name{$this->args['postfix']}.js";
		$rel = "{$this->args['asset_dir']}/{$this->args['script_dir']}/$filename";
		$url = $this->fs->get_url($rel);
		$path = $this->fs->get_path($rel);

		if (!file_exists($path)) {
			throw new \Exception("The \"$name\" script asset file does not exist");
		}

		wp_enqueue_script($key, $url, $deps, filemtime($path), $in_footer);

		if ($args) {
			wp_localize_script($key, $key, $args);
		}
	}

	public function enqueue_inline_script(string $parent_name, string $js_code, string $position = 'after'): void {
		wp_add_inline_script($this->app->get_key($parent_name), $js_code, $position);
	}

	public function enqueue_style(string $name, array $deps = [], /* string|array */ $addition = null): void {
		$key = $this->app->get_key($name);
		$filename = "$name{$this->args['postfix']}.css";
		$rel = "{$this->args['asset_dir']}/{$this->args['style_dir']}/$filename";
		$url = $this->fs->get_url($rel);
		$path = $this->fs->get_path($rel);

		if (!file_exists($path)) {
			throw new \Exception("The \"$name\" style asset file does not exist");
		}

		wp_enqueue_style($key, $url, $deps, filemtime($path));

		if (empty($addition)) {
			return;
		}

		if (is_string($addition)) {
			wp_add_inline_style($key, $addition);

		} elseif (is_array($addition)) {
			$css_vars = ':root{';

			foreach ($addition as $var_name => $var_val) {
				$css_vars .= '--' . str_replace('_', '-', $this->app->get_key($var_name)) . ':' . $var_val . ';';
			}

			wp_add_inline_style($key, "$css_vars}");
		}
	}

	public function enqueue_external_script(string $name, string $url, bool $in_footer = true): void {
		wp_enqueue_script($this->app->get_key($name), $url, false, null, $in_footer); // phpcs:ignore
	}

	public function enqueue_external_style(string $name, string $url): void {
		wp_enqueue_style($this->app->get_key($name), $url, false, null); // phpcs:ignore
	}

	public function enqueue_args(string $name, array $args): void {
		$key = $this->app->get_key($name);

		wp_register_script($key, null, [], null); // phpcs:ignore
		wp_localize_script($key, $key, $args);
	}
}
