<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined('ABSPATH') || exit;

class Form {
	protected $app;
	protected $url;
	protected $args = [
		'form_type' => 'admin_post',
		'form_url' => 'admin-post',
		'ajax_type' => 'wp_ajax',
		'ajax_url' => 'admin-ajax',
	];

	public function __construct(App $app, Url $url) {
		$this->app = $app;
		$this->url = $url;
	}

	public function add(string $name, callable $callback): void {
		$this->add_base('form', $name, $callback);
	}

	public function get_url(string $name = ''): string {
		return $this->get_base_url('form', $name);
	}

	public function add_ajax(string $name, callable $callback): void {
		$this->add_base('ajax', $name, $callback);
	}

	public function get_ajax_url(string $name = ''): string {
		return $this->get_base_url('ajax', $name);
	}

	protected function add_base(string $type, string $name, callable $callback): void {
		add_action("{$this->args["{$type}_type"]}_" . $this->app->get_key($name), $callback);
		add_action("{$this->args["{$type}_type"]}_nopriv_" . $this->app->get_key($name), $callback);
	}

	protected function get_base_url(string $type, string $name = ''): string {
		$url = $this->url->get_admin($this->args["{$type}_url"]);

		if ($name) {
			if (!has_action("{$this->args["{$type}_type"]}_" . $this->app->get_key($name))) {
				throw new \Exception("The \"$name\" action isn't defined");
			}

			return add_query_arg($url, ['action' => $this->app->get_key($name)]);
		}

		return $url;
	}
}
