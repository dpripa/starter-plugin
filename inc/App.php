<?php
namespace StarterPlugin;

use StarterPlugin\OmgCore\OmgApp;

defined( 'ABSPATH' ) || exit;

class App extends OmgApp {
	protected function __construct() {
		parent::__construct( ROOT_FILE, KEY );

		add_action( 'init', $this->load_textdomain() );
		add_action( 'plugins_loaded', $this->init() );
		register_activation_hook( ROOT_FILE, $this->activate() );
		register_deactivation_hook( ROOT_FILE, $this->deactivate() );
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

	protected function init(): callable {
		return function (): void {
			add_action( 'wp_enqueue_scripts', $this->enqueue_assets() );
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
