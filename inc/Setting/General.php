<?php
namespace MainPlugin\Setting;

use MainPlugin\Plugin\Setting\Page;
use MainPlugin\Plugin\Setting\Tab;
use MainPlugin\Plugin\Setting\SubTab;
use MainPlugin\Plugin\Setting\Box;
use MainPlugin\Plugin\Setting\Setting;
use const MainPlugin\KEY;

defined( 'ABSPATH' ) || exit;

class General {
	public function __construct() {
		Page::add(
			'general',
			null,
			$this->get_page_items(),
			__( 'General', KEY )
		);
	}

	private function get_page_items(): array {
		return array(
			Tab::add(
				'tab_1',
				$this->get_tab_1_items(),
				__( 'Tab #1', KEY )
			),
			Tab::add(
				'tab_2',
				$this->get_tab_2_items(),
				__( 'Tab #2', KEY )
			),
		);
	}

	private function get_tab_1_items(): array {
		return array();
	}

	private function get_tab_2_items(): array {
		return array();
	}
}
