<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined('ABSPATH') || exit;

class Hook {
	protected $app;

	public function __construct(App $app) {
		$this->app = $app;
	}

	public function apply_filters(string $slug, /* mixed */ ...$args) /* mixed */ {
		return apply_filters($this->app->get_key($slug), ...$args);
	}

	public function add_filter(string $slug, callable $callback, int $priority = 10, int $accepted_args = 1): self {
		add_filter($this->app->get_key($slug), $callback, $priority, $accepted_args);

		return $this;
	}

	public function do_action(string $slug, /* mixed */ ...$args): self {
		do_action($this->app->get_key($slug), ...$args);

		return $this;
	}

	public function add_action(string $slug, callable $callback, int $priority = 10, int $accepted_args = 1): self {
		add_action($this->app->get_key($slug), $callback, $priority, $accepted_args);

		return $this;
	}

	public function activation(callable $callback): self {
		if ($this->app->is_theme()) {
			add_action('after_switch_theme', $callback, 10, 2);

		} else {
			register_activation_hook($this->app->get_root_file(), $callback);
		}

		return $this;
	}

	public function deactivation(callable $callback): self {
		if ($this->is_theme) {
			add_action('switch_theme', $callback, 10, 3);

		} else {
			register_deactivation_hook($this->app->get_root_file(), $callback);
		}

		return $this;
	}
}
