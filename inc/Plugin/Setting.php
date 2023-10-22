<?php
namespace MainPlugin\Plugin;

defined( 'ABSPATH' ) || exit;

class Setting {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets() {
		Asset::enqueue_style( 'setting' );
		Asset::enqueue_script( 'setting' );
	}
}
