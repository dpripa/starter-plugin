<?php
namespace MyPlugin;

defined( 'ABSPATH' ) || exit;

class Admin {
	public function __construct() {
		new Plugin\Notice();
	}
}
