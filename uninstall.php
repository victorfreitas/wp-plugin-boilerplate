<?php
/**
 *
 * Run before plugin complete uninstall
 *
 * @package uninstall.php
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit( 0 );
}

use Boilerplate\Model\Attachment;

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

Attachment::instance()->uninstall();
