<?php
namespace MyPlugin;

defined( 'ABSPATH' ) || exit;

class Setup {
	public function __construct() {
		new Env();
		new Admin();

		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function init(): void {
		if ( Dep::validate( $this->get_deps() ) ) {
			return;
		}

		load_plugin_textdomain( KEY, false, \MyPlugin\Fs::get_path( 'lang' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function enqueue_assets(): void {
		Asset::enqueue_style( 'main' );
		Asset::enqueue_script( 'main' );
	}

	protected function get_deps(): array {
		return array();
	}
}
