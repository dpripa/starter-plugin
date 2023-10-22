<?php
namespace MainPlugin\Plugin\Setting;

use const MainPlugin\KEY;

defined( 'ABSPATH' ) || exit;

class Tab {
	public static function add(
		string $key,
		array $items,
		string $nav_title,
		?string $title = null
	): array {
		return array(
			'type'      => 'tab',
			'key'       => $key,
			'items'     => $items,
			'nav_title' => $nav_title,
			'title'     => $title,
		);
	}
}
