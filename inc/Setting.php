<?php
namespace MainPlugin;

defined( 'ABSPATH' ) || exit;

class Setting {
	public function __construct() {
		new Setting\General();
	}
}
