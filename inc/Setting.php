<?php

namespace MyPlugin;

defined( 'ABSPATH' ) || exit;

final class Setting {
	public function __construct() {
		if ( app()->validate_setup( self::class ) ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'add_page' ) );
		// add_action('admin_init', [$this, 'add_settings']);
	}

	public function add_page(): void {
		add_submenu_page(
			'options-general.php',
			app()->i18n->__( 'title' ),
			app()->i18n->__( 'title' ),
			'manage_options',
			app()->get_key(),
			array( $this, 'render_page' )
		);
	}

	public function render_page(): void {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( app()->get_key() );
				do_settings_sections( app()->get_key() );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
