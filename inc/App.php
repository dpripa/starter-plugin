<?php
namespace StarterPlugin;

use StarterPlugin\OmgCore\App as AbstractApp;

defined( 'ABSPATH' ) || exit;

class App extends AbstractApp {
	protected function __construct() {
		parent::__construct( ROOT_FILE, KEY );

		add_action( 'plugins_loaded', $this->init() );
		add_action( 'init', $this->load_textdomain() );
		register_activation_hook( ROOT_FILE, $this->activate() );
		register_deactivation_hook( ROOT_FILE, $this->deactivate() );
	}

	protected function init(): callable {
		return function (): void {
			if ( $this->requirement->validate() ) {
				return;
			}

			add_action( 'wp_enqueue_scripts', $this->enqueue_assets() );
		};
	}

	protected function load_textdomain(): callable {
		return function (): void {
			load_plugin_textdomain(
				'starter-plugin',
				false,
				$this->fs->get_path( 'lang' )
			);
		};
	}

	protected function enqueue_assets(): callable {
		return function (): void {
			$this->asset
				->enqueue_style( 'main' )
				->enqueue_script( 'main' );
		};
	}

	protected function activate(): callable {
		return function (): void {};
	}

	protected function deactivate(): callable {
		return function (): void {
			$this->admin_notice->reset();
		};
	}
}
