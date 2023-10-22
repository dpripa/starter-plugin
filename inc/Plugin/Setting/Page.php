<?php
namespace MainPlugin\Plugin\Setting;

use const MainPlugin\KEY;

defined( 'ABSPATH' ) || exit;

class Page {
	public static function add(
		string $key,
		?string $parent,
		array $items,
		string $nav_title,
		?string $title = null,
		?string $icon_url = null,
		?string $description = null,
		?int $position = null,
		string $capability = 'delete_posts'
	): void {
		add_action(
			'admin_menu',
			function () use (
				$key,
				$parent,
				$items,
				$nav_title,
				$title,
				$icon_url,
				$description,
				$position,
				$capability
			): void {
				if ( $parent ) {
					add_submenu_page(
						$parent,
						$title ?? $nav_title,
						$nav_title,
						$capability,
						KEY . "_$key",
						static::render( $items, $key ),
						$position
					);

				} else {
					add_menu_page(
						$title ?? $nav_title,
						$nav_title,
						$capability,
						KEY . "_$key",
						static::render( $items, $key ),
						$icon_url ?? '',
						$position
					);
				}
			}
		);
	}

	protected static function render( array $items, string $key ): callable {
		return function () use ( $items, $key ): void {
			?>
			<div class="mnp-setting-page <?php echo esc_attr( "mnp-setting-page-$key" ); ?>">
				<?php $items(); ?>
			</div>
			<?php
		};
	}
}
