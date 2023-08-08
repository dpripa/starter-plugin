<?php

namespace MyPlugin\Core\Extension\Setting;

use ModPress_Framework\Entry as Framework;
use ModPress_Framework\Core;

defined( 'ABSPATH' ) || exit;

class Tab {

	protected $framework;
	protected $core;
	protected $storage;

	protected $tab;
	protected $page;
	protected $nav_title;
	protected $title;
	protected $description;

	public function __construct(
		Framework $framework,
		Core $core,
		Storage $storage,
		string $tab,
		string $page,
		string $nav_title,
		?string $title,
		?string $description
	) {
		$this->framework   = $framework;
		$this->core        = $core;
		$this->storage     = $storage;
		$this->tab         = $tab;
		$this->page        = $page;
		$this->nav_title   = $nav_title;
		$this->title       = $title;
		$this->description = $description;

		add_action(
			'admin_menu',
			function (): void {
				$this->core->hook()->add_action( 'setting_page', array( $this, 'render' ) );
			},
			8
		);
	}

	public function get_nav_title(): string {
		return $this->nav_title;
	}

	public function get_url(): string {
		return add_query_arg(
			array(
				'page' => $this->storage->get_page_key( $this->page ),
				'tab'  => $this->tab,
			),
			$this->framework->url()->get_admin(
				$this->storage->get_page( $this->page )['base_url']
			)
		);
	}

	public function render( string $page ): void {
		if (
			$this->page !== $page ||
			! $this->storage->is_active_tab( $this->tab, $page )
		) {
			return;
		}
		?>
		<div class="c0r3-tab">
			<?php
			$this->render_nav();

			if ( $this->title ) {
				?>
				<h2><?php echo esc_html( $this->title ); ?></h2>
				<?php
			}

			if ( $this->description ) {
				?>
				<div class="c0r3-description">
					<?php echo wp_kses_post( $this->description ); ?>
				</div>
				<?php
			}

			$this->core->hook()->do_action( 'setting_tab', $this->tab, $page );
			?>
		</div>
		<?php
	}

	protected function render_nav(): void {
		$tabs = $this->storage->filter_children(
			$this->storage->get_page( $this->page )['children'],
			static::class
		);

		if ( count( $tabs ) < 2 ) {
			return;
		}
		?>
		<div class="c0r3-tab__nav nav-tab-wrapper">
			<?php
			foreach ( $tabs as $tab_key => $tab_data ) {
				/**
				 * @var self $tab
				 */
				$tab          = $tab_data['object'];
				$active_class = $this->storage->is_active_tab( $tab_key, $this->page ) ? 'nav-tab-active' : '';
				?>
				<a class="nav-tab <?php echo esc_attr( $active_class ); ?>" href="<?php echo esc_url( $tab->get_url() ); ?>">
					<?php echo esc_html( $tab->get_nav_title() ); ?>
				</a>
				<?php
			}

			$this->core->hook()->do_action( 'setting_tab_nav', $this->tab, $this->page );
			?>
		</div>
		<?php
	}
}
