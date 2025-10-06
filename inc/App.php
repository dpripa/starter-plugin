<?php
namespace StarterPlugin;

use StarterPlugin\OmgCore\Core;
use StarterPlugin\OmgCore\Dependency;
use StarterPlugin\OmgCore\Logger;

defined( 'ABSPATH' ) || exit;

class App extends Core {
	protected function __construct() {
		parent::__construct( ROOT_FILE, KEY );
	}

	protected function init(): callable {
		return function (): void {
			parent::init()();
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

	protected function get_core_i18n(): callable {
		return function (): array {
			return array(
				Dependency::class => array(
					'notice_title_required_singular'      => __( 'The <b>%1$s</b> plugin%2$s is <b>required</b> for the <b>%3$s</b> features to function.', 'starter-plugin' ),
					'notice_title_optional_singular'      => __( 'The <b>%1$s</b> plugin%2$s is <b>recommended</b> for the all <b>%3$s</b> features to function.', 'starter-plugin' ),
					'notice_title_required_plural'        => __( 'The following plugins are <b>required</b> for the <b>%s"/b> features to function:', 'starter-plugin' ),
					'notice_title_optional_plural'        => __( 'The following plugins are <b>recommended</b> for the all <b>%s</b> features to function:', 'starter-plugin' ),
					'notice_item_not_installed'           => __( 'not installed', 'starter-plugin' ),
					'notice_item_undefiled_installation_url' => __( 'not installed, can\'t be installed automatically', 'starter-plugin' ),
					'notice_btn_activate'                 => __( 'Activate', 'starter-plugin' ),
					'notice_btn_install_and_activate'     => __( 'Install and activate', 'starter-plugin' ),
					'notice_btn_activate_only_required'   => __( 'Activate only required', 'starter-plugin' ),
					'notice_btn_install_and_activate_only_required' => __( 'Install and activate only required', 'starter-plugin' ),
					'notice_success_activate'             => __( 'Required plugin(s) activated.', 'starter-plugin' ),
					'notice_success_install_and_activate' => __( 'Required plugin(s) installed and activated.', 'starter-plugin' ),
					'notice_error_install'                => __( 'The "%1$s" plugin can\'t be installed automatically. Please install it manually.', 'starter-plugin' ),
				),
				Logger::class     => array(
					'notice_delete_log_error'         => __( 'An error occurred while trying to delete %s log file(s).', 'starter-plugin' ),
					'notice_delete_log_all_success'   => __( 'All %s log files have been successfully deleted.', 'starter-plugin' ),
					'notice_delete_log_group_success' => __( 'The %1$s %2$s log file has been successfully deleted.', 'starter-plugin' ),
				),
			);
		};
	}
}
