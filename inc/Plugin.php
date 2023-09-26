<?php
namespace MainPlugin;

defined( 'ABSPATH' ) || exit;

class Plugin {
	public function __construct() {
		new Plugin\Notice();
	}
}
