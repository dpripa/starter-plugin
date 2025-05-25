<?php
namespace MyPlugin;

defined( 'ABSPATH' ) || exit;

class Admin {
	public function __construct() {
		new Admin\Notice();
	}
}
