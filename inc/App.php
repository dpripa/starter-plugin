<?php

namespace MyPlugin;

defined('ABSPATH') || exit;

final class App implements Core\App {
	use Core\Bootstrap;

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
	public $setting;

	private function __construct(string $namespace, string $root_file) {
		$this->init($namespace, $root_file);

		$this->arr = new Core\Extension\Arr();
		$this->env = new Core\Extension\Env();
		$this->str = new Core\Extension\Str();
		$this->url = new Core\Extension\Url();
		$this->admin_notice = new Core\Extension\AdminNotice($this);
		$this->form = new Core\Extension\Form($this, $this->url);
		$this->fs = new Core\Extension\FS($this);
		$this->hook = new Core\Extension\Hook($this);
		$this->asset = new Core\Extension\Asset($this, $this->fs);
		$this->i18n = new Core\Extension\I18n($this, $this->fs);
		$this->info = new Core\Extension\Info($this);
		$this->template = new Core\Extension\Template($this, $this->fs);
		$this->setting = new Core\Extension\Setting($this, $this->daemon, $this->asset, $this->url);
	}
}
