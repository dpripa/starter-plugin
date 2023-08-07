<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined('ABSPATH') || exit;

class Form {
	protected $app;
	protected $url;
	protected $args = [
		'ajax_type' => 'wp_ajax',
		'ajax_url' => 'admin-ajax',
		'form_type' => 'admin_post',
		'form_url' => 'admin-post',
	];

	public function __construct(App $app, Url $url) {
		$this->app = $app;
		$this->url = $url;
	}

	public function add_ajax(string $name, callable $callback): void {
		$this->add('ajax', $name, $callback);
	}

	public function get_ajax_url(string $name = ''): string {
		return $this->get_url('ajax', $name);
	}

	public function add_form(string $name, callable $callback): void {
		$this->add('form', $name, $callback);
	}

	public function get_form_url(string $name = ''): string {
		return $this->get_url('form', $name);
	}

	protected function add(string $type, string $name, callable $callback): void {
		add_action("{$this->args["{$type}_type"]}_" . $this->app->get_key($name), $callback);
		add_action("{$this->args["{$type}_type"]}_nopriv_" . $this->app->get_key($name), $callback);
	}

	protected function get_url(string $type, string $name = ''): string {
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
