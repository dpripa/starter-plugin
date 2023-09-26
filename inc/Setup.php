<?php
namespace MainPlugin;

defined( 'ABSPATH' ) || exit;

class Setup {
	public function __construct() {
		new Plugin();

		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init(): void {
		load_plugin_textdomain( KEY, false, Plugin\Fs::get_path( 'lang' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets(): void {
		Plugin\Asset::enqueue_style( 'main' );
		Plugin\Asset::enqueue_script( 'main' );
	}
}
