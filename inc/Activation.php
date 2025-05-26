<?php
namespace OmgPlugin;

defined( 'ABSPATH' ) || exit;

class Activation {
	public function __construct() {
		register_activation_hook( ROOT_FILE, array( $this, 'activate' ) );
	}

	public function activate(): void {}
}
