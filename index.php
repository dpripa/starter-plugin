<?php
/**
 * Plugin Name: OmgPlugin
 * Plugin URI: https://omgpress.com
 * Description: The WordPress Plugin
 * Version: 1.0.0
 * Text Domain: my-plugin
 * Author: Developer
 * Author URI: https://wordpress.org
 * Requires PHP: 7.4.0
 * Requires at least: 5.0.0
 */
namespace OmgPlugin;

use Exception;

defined( 'ABSPATH' ) || exit;

const KEY       = 'omgplugin';
const ROOT_FILE = __FILE__;

$autoload = __DIR__ . '/vendor/autoload.php';

if ( ! file_exists( $autoload ) ) {
	throw new Exception( 'Autoloader not exists' );
}

require_once $autoload;

new Setup();
