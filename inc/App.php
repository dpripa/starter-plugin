<?php

namespace MyPlugin;

use O0W7_1\Bootstrap;
use O0W7_1\Extension;

defined( 'ABSPATH' ) || exit;

final class App implements \O0W7_1\App {
	use Bootstrap;

	public $arr;
	public $env;
	public $str;
	public $url;
	public $admin_notice;
	public $form;
	public $fs;
	public $hook;
	public $asset;
	public $i18n;
	public $info;
	public $template;

	private function __construct( string $namespace, string $root_file ) {
		$this->init( $namespace, $root_file );

		$this->arr          = Extension\Arr::get_instance();
		$this->env          = Extension\Env::get_instance();
		$this->str          = Extension\Str::get_instance();
		$this->url          = Extension\Url::get_instance();
		$this->admin_notice = new Extension\AdminNotice( $this );
		$this->form         = new Extension\Form( $this, $this->url );
		$this->fs           = new Extension\FS( $this );
		$this->hook         = new Extension\Hook( $this );
		$this->asset        = new Extension\Asset( $this, $this->fs );
		$this->i18n         = new Extension\I18n( $this, $this->fs );
		$this->info         = new Extension\Info( $this, $this->fs );
		$this->template     = new Extension\Template( $this, $this->fs );
	}
}
