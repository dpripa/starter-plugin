<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;

defined('ABSPATH') || exit;

class Info {
	protected $app;

	public function __construct(App $app) {
		$this->app = $app;
	}
}
