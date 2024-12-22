<?php
namespace MyPlugin;

use Exception;

defined( 'ABSPATH' ) || exit;

class Setup {
	public function __construct() {
		new Activation();
		new Deactivation();
		new Env();
		new Admin();

		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'init', array( $this, 'load_textdomain' ) );
	}

	public function init(): void {
		if ( Dep::validate( $this->get_deps() ) ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	public function load_textdomain(): void {
		load_plugin_textdomain( KEY, false, Fs::get_path( 'lang' ) );
	}

	/**
	 * @throws Exception
	 */
	public function enqueue_assets(): void {
		Asset::enqueue_style( 'main' );
		Asset::enqueue_script( 'main' );
	}

	protected function get_deps(): array {
		return array();
	}
}
