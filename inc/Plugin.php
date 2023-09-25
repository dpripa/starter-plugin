<?php
namespace MyPlugin;

defined( 'ABSPATH' ) || exit;

class Plugin {
	public function __construct() {
		new Plugin\Notice();
	}
}
