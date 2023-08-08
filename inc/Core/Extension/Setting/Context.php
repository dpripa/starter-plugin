<?php

namespace MyPlugin\Core\Extension\Setting;

defined( 'ABSPATH' ) || exit;

class Context {

	protected $page;
	protected $tab;
	protected $sub_tab;
	protected $box;

	public function add_page( ?string $page_or_sub_page ): void {
		$this->page = $page_or_sub_page;
	}

	public function add_tab( ?string $tab ): void {
		$this->tab = $tab;
	}

	public function add_sub_tab( ?string $sub_tab ): void {
		$this->sub_tab = $sub_tab;
	}

	public function add_box( ?string $box ): void {
		$this->box = $box;
	}

	public function add( string $page, ?string $tab = null, ?string $sub_tab = null, ?string $box = null ): void {
		$this->add_page( $page );
		$this->add_tab( $tab );
		$this->add_sub_tab( $sub_tab );
		$this->add_box( $box );
	}

	public function remove(): void {
		$this->page    = null;
		$this->tab     = null;
		$this->sub_tab = null;
		$this->box     = null;
	}

	public function get_page(): ?string {
		return $this->page;
	}

	public function get_tab(): ?string {
		return $this->tab;
	}

	public function get_sub_tab(): ?string {
		return $this->sub_tab;
	}

	public function get_box(): ?string {
		return $this->box;
	}
}
