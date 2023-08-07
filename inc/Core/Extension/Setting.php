<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\App;
use MyPlugin\Core\Daemon;

defined('ABSPATH') || exit;

class Setting {
	protected $key;
	protected $daemon;
	protected $asset;
	protected $url;

	public function __construct(App $app, Daemon\App $daemon, Asset $asset, Url $url) {
		$this->key = $app->get_key();
		$this->daemon = $daemon;
		$this->asset = $asset;
		$this->url = $url;

		add_action('plugins_loaded', $this->enqueue_asset(), 1);
	}

	protected function enqueue_asset(): callable {
		return function (): void {
			$this->daemon->asset->enqueue_style('setting');
			$this->daemon->asset->enqueue_script('setting');
		};
	}
}
