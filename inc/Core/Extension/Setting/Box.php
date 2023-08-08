<?php

namespace MyPlugin\Core\Extension\Setting;

use ModPress_Framework\Entry as Framework;
use ModPress_Framework\Core;

defined( 'ABSPATH' ) || exit;

class Box {

	protected $core;
	protected $storage;

	protected $box;
	protected $sub_tab;
	protected $tab;
	protected $page;
	protected $title;
	protected $description;

	public function __construct(
		Core $core,
		Storage $storage,
		string $box,
		?string $sub_tab,
		string $tab,
		string $page,
		?string $title,
		?string $description
	) {
		$this->core        = $core;
		$this->storage     = $storage;
		$this->box         = $box;
		$this->sub_tab     = $sub_tab;
		$this->tab         = $tab;
		$this->page        = $page;
		$this->title       = $title;
		$this->description = $description;

		add_action(
			'admin_menu',
			function (): void {
				if ( $this->sub_tab ) {
					$this->core->hook()->add_action( 'setting_sub_tab', array( $this, 'render_in_sub_tab' ), 10, 3 );

				} else {
					$this->core->hook()->add_action( 'setting_tab', array( $this, 'render_in_tab' ), 10, 2 );
				}
			},
			6
		);
	}

	public function render_in_sub_tab( string $sub_tab, string $tab, string $page ): void {
		if (
			$this->sub_tab !== $sub_tab ||
			$this->tab !== $tab ||
			$this->page !== $page
		) {
			return;
		}

		$this->render( $sub_tab, $tab, $page );
	}

	public function render_in_tab( string $tab, string $page ): void {
		if (
			$this->tab !== $tab ||
			$this->page !== $page
		) {
			return;
		}

		$this->render( null, $tab, $page );
	}

	protected function render( ?string $sub_tab, string $tab, string $page ): void {
		?>
		<table class="c0r3-box form-table" role="presentation">
			<tbody>
			<?php
			if ( $this->title ) {
				?>
				<h3><?php echo esc_html( $this->title ); ?></h3>
				<?php
			}

			if ( $this->description ) {
				?>
				<div class="c0r3-description">
					<?php echo wp_kses_post( $this->description ); ?>
				</div>
				<?php
			}

			$this->core->hook()->do_action( 'setting_box', $this->box, $sub_tab, $tab, $page );
			?>
			</tbody>
		</table>
		<?php
	}
}
