<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI: https://github.com/dpripa/wp-starter-plugin
 * Description: WordPress Starter Plugin.
 * Version: 1.0.0
 * Text Domain: my_plugin
 * Author: Dmitry Pripa
 * Author URI: https://github.com/dpripa
 * Requires PHP: 7.2.0
 * Requires at least: 5.0.0
 * License: GPL
 * License URI: https://github.com/dpripa/wp-starter-plugin/blob/main/LICENSE
 */

namespace MyPlugin;

defined('ABSPATH') || exit;

const KEY = 'my_plugin';

function get_url(string $rel = '', bool $stamp = false): string {
	$url = rtrim(plugin_dir_url(__FILE__), '/\\') . $rel;

	if ($stamp) {
		$path = get_path($rel);

		if (!file_exists($path)) {
			return $url;
		}

		return add_query_arg(['ver' => filemtime($path)], $url);
	}

	return $url;
}

function get_path(string $rel = ''): string {
	$path = plugin_dir_path(__FILE__);

	return $rel ? "$path{$rel}" : rtrim($path, '/\\');
}

$autoload = get_path('vendor/autoload.php');

if (!file_exists($autoload)) {
	throw new \Exception('Autoloader not exists');
}

require_once $autoload;

new Setup();
