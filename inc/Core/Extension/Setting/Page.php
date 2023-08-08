<?php

namespace MyPlugin\Core\Extension\Setting;

use ModPress_Framework\Entry as Framework;
use ModPress_Framework\Core;

defined( 'ABSPATH' ) || exit;

class Page {

	protected $framework;
	protected $core;
	protected $storage;

	protected $page;
	protected $parent;
	protected $key;
	protected $nav_title;
	protected $title;
	protected $icon_url;
	protected $description;
	protected $position;
	protected $capability;
	protected $submit_btn;
	protected $handler_url;

	public function __construct(
		Framework $framework,
		Core $core,
		Storage $storage,
		string $page,
		?string $parent,
		string $nav_title,
		?string $title,
		?string $icon_url,
		?string $description,
		?int $position,
		string $capability,
		?string $submit_btn,
		string $handler_url
	) {
		$this->framework   = $framework;
		$this->core        = $core;
		$this->storage     = $storage;
		$this->page        = $page;
		$this->parent      = $storage->is_page( $parent ) ?
			$storage->get_page_key( $parent ) :
			$parent;
		$this->key         = $storage->get_page_key( $page );
		$this->nav_title   = $nav_title;
		$this->title       = $title;
		$this->icon_url    = $icon_url;
		$this->description = $description;
		$this->position    = $position;
		$this->capability  = $capability;
		$this->submit_btn  = $submit_btn;
		$this->handler_url = $handler_url;

		add_action(
			'admin_menu',
			function (): void {
				if ( $this->parent ) {
					add_submenu_page(
						$this->parent,
						$this->title ?? $this->nav_title,
						$this->nav_title,
						$this->capability,
						$this->key,
						array( $this, 'render' ),
						$this->position
					);

				} else {
					add_menu_page(
						$this->title ?? $this->nav_title,
						$this->nav_title,
						$this->capability,
						$this->key,
						array( $this, 'render' ),
						$this->icon_url ?? '',
						$this->position
					);
				}
			},
			9
		);
	}

	public function get_url(): string {
		return add_query_arg(
			array(
				'page' => $this->storage->get_page_key( $this->page ),
			),
			$this->framework->url()->get_admin(
				$this->storage->get_page( $this->page )['base_url']
			)
		);
	}

	public function render(): void {
		$active_sub_tab  = $this->storage->get_active_sub_tab();
		$active_tab      = $this->storage->get_active_tab();
		$active_page     = $this->storage->get_active_page( true );
		$layout_classes  = 'c0r3-page';
		$layout_classes .= ' ' . $this->framework->get_app_key( 'page', '-' );
		$layout_classes .= ' ' . $this->framework->get_app_key( 'page-' . $this->page, '-' );

		?>
		<form class="<?php echo esc_attr( $layout_classes ); ?>" action="<?php echo esc_attr( esc_url( $this->handler_url ) ); ?>" method="post">
			<?php
			wp_nonce_field( $this->key, "{$this->key}_nonce" );

			$this->core->hook()->do_action( 'setting_header', $active_sub_tab, $active_tab, $active_page );
			?>
			<div class="c0r3-notices"></div>
			<?php if ( $this->title ) { ?>
				<h1><?php echo esc_html( $this->title ); ?></h1>
				<?php
			}

			if ( $this->description ) {
				?>
				<div class="c0r3-description">
					<?php echo wp_kses_post( $this->description ); ?>
				</div>
			<?php } ?>
			<div class="c0r3-page__body">
				<?php
				$this->core->hook()->do_action( 'setting_page', $this->page );

				if ( $this->storage->has_setting( $this->page, $active_tab, $active_sub_tab ) ) {
					Submit_Btn::render( $this->submit_btn );
				}
				?>
			</div>
			<?php $this->core->hook()->do_action( 'setting_footer', $active_sub_tab, $active_tab, $active_page ); ?>
		</form>
		<?php
	}
}
