<?php
/**
 *
 * Clean boilerplate plugin starter
 *
 * @package Boilerplate
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 * @license GPL-3.0+
 *
 * @wordpress-plugin
 * Plugin Name: Boilerplate
 * Plugin URI:  https://github.com/victorfreitas
 * Description: Boilerplate with webpack
 * Version:     0.2.0
 * Author:      Victor Freitas
 * Author URI:  https://github.com/victorfreitas
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: boilerplate
 * Domain Path: /i18n/languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

require_once dirname( __FILE__ ) . '/includes/functions.php';

if ( version_compare( phpversion(), '5.3', '<' ) ) {
	add_action( 'admin_notices', 'boilerplate_php_version_wrong' );
	return;
}

if ( ! file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	add_action( 'admin_notices', 'boilerplate_vendor_not_found' );
	return;
}

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

if ( ! defined( 'BOILERPLATE_PLUGIN_FILE' ) ) {
	define( 'BOILERPLATE_PLUGIN_FILE', __FILE__ );
}

$app = Boilerplate\Config\App::instance();

do_action( 'boilerplate_init', $app );

register_activation_hook( __FILE__, [ $app, 'activate' ] );
register_deactivation_hook( __FILE__, [ $app, 'deactivate' ] );
