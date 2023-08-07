<?php

namespace MyPlugin\Core\Extension;

use MyPlugin\Core\Helper\Singleton;

defined('ABSPATH') || exit;

class Arr {
	use Singleton;

	public function map_associative(callable $callback, array $array): array {
		$result = [];

		foreach ($array as $key => $val) {
			$result[$key] = $callback($key, $val);
		}

		return $result;
	}

	public function insert_to_position(array $array_for_insert, array $target_array, int $position): array {
		if (empty($target_array)) {
			return $array_for_insert;
		}

		return array_merge(
			array_slice($target_array, 0, $position),
			$array_for_insert,
			array_slice($target_array, $position)
		);
	}
}
