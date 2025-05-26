<?php
namespace OmgPlugin;

defined( 'ABSPATH' ) || exit;

class Deactivation {
	public function __construct() {
		register_deactivation_hook( ROOT_FILE, array( $this, 'deactivate' ) );
	}

	public function deactivate(): void {
		Admin\Notice::reset();
	}
}
