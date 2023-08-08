<?php

namespace MyPlugin\Core\Extension\Setting;

defined( 'ABSPATH' ) || exit;

class Control {

	protected static $control_classes = [
		'checkbox' => Control\Checkbox::class,
		'radio'    => Control\Radio::class,
		'select'   => Control\Select::class,
		'text'     => Control\Text::class,
		'number'   => Control\Text::class,
		'email'    => Control\Text::class,
		'tel'      => Control\Text::class,
		'textarea' => Control\Textarea::class,
	];

	public static function render(
		string $type,
		string $key,
		/* mixed */ $value,
		?string $title,
		array $args,
		string $required_label,
		?string $box = null,
		?string $sub_tab = null,
		?string $tab = null,
		?string $page = null
	): void {
		if ( in_array( $type, array_keys( static::$control_classes ), true ) ) {
			$control_classname = static::$control_classes[ $type ];

		} elseif ( class_exists( $type ) ) {
			$control_classname = $type;

		} else {
			$sub_tab_label = $sub_tab ? "sub-tab: <code>'$sub_tab'</code>," : '';
			$parent_label  = " Parent box: <code>'$box'</code>, $sub_tab_label tab: <code>'$tab'</code>, page: <code>'$page'</code>";

			throw new \Exception( "Undefined type \"$type\" of a setting control.$parent_label" );
		}

		if ( ! method_exists( $control_classname, 'render' ) ) {
			throw new \Exception( "Not found the static method \"render\" in the control class $control_classname" );
		}

		$title_method_exists = method_exists( $control_classname, 'render_title' );
		?>
		<tr class="c0r3-control">
			<?php if ( $title_method_exists ) { ?>
				<th class="c0r3-control__title" scope="row">
					<?php call_user_func( [ $control_classname, 'render_title' ], $type, $key, $title, $args, $required_label ); ?>
				</th>
			<?php } ?>
			<td class="c0r3-control__body" <?php echo $title_method_exists ? '' : 'colspan="2"'; ?>>
				<?php call_user_func( [ $control_classname, 'render' ], $type, $key, $value, $title, $args ); ?>
			</td>
		</tr>
		<?php
	}

	public static function render_custom(
		string $type,
		string $key,
		/* mixed */ $value,
		?string $title,
		array $args,
		string $required_label
	): void {
		?>
		<table class="form-table" role="presentation">
			<tbody>
			<?php static::render( $type, $key, $value, $title, $args, $required_label ); ?>
			</tbody>
		</table>
		<?php
	}
}
