<?php
/**
 *
 * General configurations of the application
 *
 * @package Boilerplate\Config\App
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use Boilerplate\Model\Attachment;

class App extends Loader {

	private static $_instance = null;

	public $namespace = 'Boilerplate';

	const VERSION = '0.2.1';

	const SLUG = 'boilerplate';

	public function setup() {
		$this->enqueue_scripts();
		$this->init_controllers( [] );
	}

	public function activate() {
		Attachment::instance()->create_table();
	}

	public function deactivate() {

	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}
