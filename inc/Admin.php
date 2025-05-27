<?php
namespace StarterPlugin;

defined( 'ABSPATH' ) || exit;

class Admin {
	public function __construct() {
		new Admin\Notice();
	}
}
