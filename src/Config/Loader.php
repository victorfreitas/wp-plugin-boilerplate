<?php
/**
 *
 * Loader for instances of controllers and application abstraction
 *
 * @package Boilerplate\Config\Loader
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use Boilerplate\Helper\Utils;

abstract class Loader {

	protected function __construct() {
		add_action( 'init', [ $this, 'load_textdomain' ] );
		$this->setup();
	}

	protected function setup() {

	}

	protected function enqueue_scripts() {
		Scripts::instance();
	}

	public function load_textdomain() {
		load_plugin_textdomain( static::SLUG, false, Utils::plugin_rel_path( 'i18n/languages' ) );
	}

	public function init_controllers( $controllers ) {
		foreach ( $controllers as $controller ) {
			$this->instance_controller( sprintf( '%s\Controller\%s', $this->namespace, $controller ) );
		}
	}

	private function instance_controller( $class ) {
		if ( class_exists( $class ) ) {
			new $class();
		}
	}

	public static function get_plugin_file() {
		return BOILERPLATE_PLUGIN_FILE;
	}
}
