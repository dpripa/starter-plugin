<?php

namespace MyPlugin\Core\Extension;

use ModPress_Framework\Entry as Framework;

defined( 'ABSPATH' ) || exit;

class Setting {
	private $core;
	private $context;
	private $shadow_context;
	private $storage;
	private $handler;
	private $args;

	private $default_args = array(
		'render_header_func' => null,
		'render_footer_func' => null,
		'submit_btn'         => 'Save changes',
		'error_notice'       => 'Something went wrong.',
		'success_notice'     => 'Changes saved.',
		'required_label'     => 'required',
	);

	public function __construct() {}

	public function init( Framework $framework, array $args = array() ): self {
		$core_class           = ( new \ReflectionClass( $framework ) )->getNamespaceName() . '\\Core';
		$this->core           = $core_class::get_instance( $framework->get_app_key() );
		$this->context        = new Context();
		$this->shadow_context = new Context();
		$this->storage        = new Storage( $framework, $this->core );
		$this->handler        = new Handler( $framework, $this->core );
		$this->args           = wp_parse_args( $args, $this->default_args );

		$this->pre_init();
		$this->init_page();

		return $this;
	}

	private function pre_init(): void {
		add_action(
			'admin_menu',
			function (): void {
				if ( is_callable( $this->args['render_header_func'] ) ) {
					$this->core->hook()->add_action( 'setting_header', $this->args['render_header_func'], 10, 3 );
				}

				if ( is_callable( $this->args['render_footer_func'] ) ) {
					$this->core->hook()->add_action( 'setting_footer', $this->args['render_footer_func'], 10, 3 );
				}
			},
			9
		);
	}

	private function init_page(): void {
		add_action(
			'admin_menu',
			function (): void {
				if ( ! $this->storage->is_page( $this->storage->get_active_page(), false ) ) {
					return;
				}

				$this->core->asset()
					->enqueue_script( ROOT_FILE, 'main', array( 'jquery' ) )
					->enqueue_style( ROOT_FILE, 'main' );

				$this->handler->init(
					$this->storage,
					$this->args['error_notice'],
					$this->args['success_notice']
				);
			}
		);
	}

	public function context(): Context {
		return $this->context;
	}

	public function add_page(
		string $page,
		?string $parent,
		string $nav_title,
		?string $title = null,
		?string $icon_url = null,
		?string $description = null,
		?int $position = null,
		string $capability = 'delete_posts'
	): self {
		if ( $this->storage->is_page( $page ) ) {
			throw new \Exception( "The \"$page\" page already exists" );
		}

		$this->shadow_context->remove();
		$this->shadow_context->add_page( $page );
		$this->storage->add_page(
			$page,
			$parent,
			$nav_title,
			$title,
			$icon_url,
			$description,
			$position,
			$capability,
			$this->args['submit_btn'],
			$this->handler->get_url()
		);

		return $this;
	}

	public function add_tab( string $tab, string $nav_title, ?string $title = null, ?string $description = null ): self {
		$page = $this->shadow_context->get_page();

		if ( empty( $page ) ) {
			throw new \Exception( "Need to add a page before adding the \"$tab\" tab" );
		}

		if ( $this->storage->is_tab( $tab, $page ) ) {
			throw new \Exception( "The \"$tab\" tab already exists" );
		}

		$this->shadow_context->add_tab( $tab );
		$this->shadow_context->add_sub_tab( null );
		$this->shadow_context->add_box( null );
		$this->storage->add_tab( $tab, $page, $nav_title, $title, $description );

		return $this;
	}

	public function add_sub_tab( string $sub_tab, string $nav_title, ?string $title = null, ?string $description = null ): self {
		$page         = $this->shadow_context->get_page();
		$tab          = $this->shadow_context->get_tab();
		$prev_sub_tab = $this->shadow_context->get_sub_tab();
		$box          = $this->shadow_context->get_box();

		if ( $box && empty( $prev_sub_tab ) ) {
			throw new \Exception( "Wrong position of the \"$sub_tab\" sub-tab in the structure. The parent \"$tab\" tab already has the direct child boxes" );
		}

		if ( empty( $tab ) ) {
			throw new \Exception( "Need to add a tab before adding the \"$sub_tab\" sub-tab" );
		}

		if ( $this->storage->is_sub_tab( $sub_tab, $tab, $page ) ) {
			throw new \Exception( "The \"$sub_tab\" sub-tab already exists" );
		}

		$this->shadow_context->add_sub_tab( $sub_tab );
		$this->shadow_context->add_box( null );
		$this->storage->add_sub_tab( $sub_tab, $tab, $page, $nav_title, $title, $description );

		return $this;
	}

	public function add_box( string $box, ?string $title = null, ?string $description = null ): self {
		$page    = $this->shadow_context->get_page();
		$tab     = $this->shadow_context->get_tab();
		$sub_tab = $this->shadow_context->get_sub_tab();

		if ( empty( $tab ) && empty( $sub_tab ) ) {
			throw new \Exception( "Need to add a tab or sub-tab before adding the \"$box\" box" );
		}

		if ( $this->storage->is_box( $box, $sub_tab, $tab, $page ) ) {
			throw new \Exception( "The \"$box\" box already exists" );
		}

		$this->shadow_context->add_box( $box );
		$this->storage->add_box( $box, $sub_tab, $tab, $page, $title, $description );

		return $this;
	}

	public function add( string $setting, string $type, ?string $title, array $args = array() ): self {
		$page    = $this->shadow_context->get_page();
		$tab     = $this->shadow_context->get_tab();
		$sub_tab = $this->shadow_context->get_sub_tab();
		$box     = $this->shadow_context->get_box();

		if ( empty( $box ) ) {
			throw new \Exception( "Need to add a box before adding the \"$setting\" setting" );
		}

		if ( $this->storage->is_setting( $setting, $box, $sub_tab, $tab, $page ) ) {
			throw new \Exception( "The \"$setting\" setting already exists" );
		}

		$this->storage->add_setting(
			$setting,
			$type,
			$box,
			$sub_tab,
			$tab,
			$page,
			$title,
			$args,
			$this->args['required_label']
		);

		return $this;
	}

	public function add_content( string $content, callable $render_content, ?callable $custom_handler = null ): self {
		$page    = $this->shadow_context->get_page();
		$tab     = $this->shadow_context->get_tab();
		$sub_tab = $this->shadow_context->get_sub_tab();
		$box     = $this->shadow_context->get_box();

		if ( empty( $page ) ) {
			throw new \Exception( "Need to add at least a page before adding the \"$content\" content" );
		}

		if ( $this->storage->is_content( $content, $box, $sub_tab, $tab, $page ) ) {
			throw new \Exception( "The \"$content\" content already exists" );
		}

		$this->storage->add_content(
			$content,
			$box,
			$sub_tab,
			$tab,
			$page,
			$render_content,
			$custom_handler
		);

		return $this;
	}

	public function add_tab_nav_item( callable $render_item ): self {
		$this->core->hook()->add_action( 'setting_tab_nav', $render_item, 10, 2 );

		return $this;
	}

	public function get(
		string $setting,
		?string $box = null,
		?string $sub_tab = null,
		?string $tab = null,
		?string $page = null
	) /* mixed */ {
		if ( empty( $box ) ) {
			$box = $this->context->get_box();
		}

		if ( empty( $sub_tab ) ) {
			$sub_tab = $this->context->get_sub_tab();
		}

		if ( empty( $tab ) ) {
			$tab = $this->context->get_tab();
		}

		if ( empty( $page ) ) {
			$page = $this->context->get_page();
		}

		if ( ! $this->storage->is_setting( $setting, $box, $sub_tab, $tab, $page ) ) {
			$sub_tab_label = $sub_tab ? "sub-tab: \"$sub_tab\"," : '';

			throw new \Exception( "The \"$setting\" setting doesn't exists. Parent box: \"$box\", $sub_tab_label tab: \"$tab\", page: \"$page\"" );
		}

		$setting_data = $this->storage->get_setting(
			$setting,
			$box,
			$sub_tab,
			$tab,
			$page
		);

		return $setting_data['object']->get();
	}

	public function get_page_key( string $page ): string {
		return $this->storage->get_page_key( $page );
	}

	public function get_url( string $page, ?string $tab = null, ?string $sub_tab = null ): string {
		if ( ! $this->storage->is_page( $page ) ) {
			throw new \Exception( "The \"$page\" page not exists" );
		}

		if ( $sub_tab && $this->storage->is_sub_tab( $sub_tab, $tab, $page ) ) {
			return $this->storage->get_sub_tab( $sub_tab, $tab, $page )['object']->get_url();
		}

		if ( $tab && $this->storage->is_tab( $tab, $page ) ) {
			return $this->storage->get_tab( $tab, $page )['object']->get_url();
		}

		return $this->storage->get_page( $page )['object']->get_url();
	}

	public function render_control( string $type, string $key, /* mixed */ $value, ?string $title, array $args = array() ): self {
		Control::render_custom( $type, $key, $value, $title, $args, $this->args['required_label'] );

		return $this;
	}

	public function render_submit_btn( ?string $btn_title = null ): self {
		Submit_Btn::render( $btn_title ?? $this->args['submit_btn'] );

		return $this;
	}
}
