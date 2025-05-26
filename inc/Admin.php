<?php
namespace OmgPlugin;

defined( 'ABSPATH' ) || exit;

class Admin {
	public function __construct() {
		new Admin\Notice();
	}
}
