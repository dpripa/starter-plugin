<?php
/**
 * Plugin Name: Starter Plugin
 * Plugin URI: https://omgpress.com/starter?type=plugin
 * Description: The WordPress plugin
 * Version: 1.0.0
 * Text Domain: starter-plugin
 * Author: OMG!PRESS
 * Author URI: https://omgpress.com
 * Requires PHP: 7.4.0
 * Requires at least: 5.0.0
 */
namespace StarterPlugin;

use Exception;

defined( 'ABSPATH' ) || exit;

const KEY       = 'starter_plugin';
const ROOT_FILE = __FILE__;

$autoload = __DIR__ . '/lib/vendor/scoper-autoload.php';

if ( ! file_exists( $autoload ) ) {
	throw new Exception( 'Autoloader not exists' );
}

require_once $autoload;

function app(): App {
	return App::get_instance();
}

app();
