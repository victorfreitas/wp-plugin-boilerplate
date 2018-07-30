<?php
/**
 *
 * Enqueue script handlers
 *
 * @package Boilerplate\Config\Scripts
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Config;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use Boilerplate\Helper\Utils;

class Scripts {

	private static $_instance = null;

	protected $type;

	protected function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'front' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin' ] );
	}

	public function front() {
		$this->set_type( 'front' );
		$this->add();
	}

	public function admin() {
		$this->set_type( 'admin' );
		$this->add();
	}

	protected function set_type( $type ) {
		$this->type = $type;
	}

	protected function add( $deps_css = [], $deps_js = [], $localize = [] ) {
		$this->style( $deps_css );
		$this->script( $deps_js );
		$this->localize( $localize );
	}

	protected function style( $deps = [] ) {
		if ( false === $deps ) {
			return;
		}

		$path = $this->get_path( 'css' );

		wp_enqueue_style(
			$this->get_handle( 'style' ),
			Utils::plugins_url( $path ),
			$deps,
			Utils::filemtime( $path )
		);
	}

	protected function script( $deps = [] ) {
		if ( false === $deps ) {
			return;
		}

		$deps = array_merge( [ 'jquery' ], $deps );
		$path = $this->get_path( 'js' );

		wp_enqueue_script(
			$this->get_handle( 'script' ),
			Utils::plugins_url( $path ),
			$deps,
			Utils::filemtime( $path ),
			true
		);
	}

	protected function localize( $deps = [] ) {
		if ( false === $deps ) {
			return;
		}

		$deps = array_merge(
			[ 'ajaxUrl' => esc_url( admin_url( 'admin-ajax.php' ) ) ],
			$deps
		);

		wp_localize_script(
			$this->get_handle( 'script' ),
			'boilerplateGlobalVars',
			$deps
		);
	}

	protected function get_handle( $name ) {
		return sprintf( '%s-%s-%s', App::SLUG, $this->type, $name );
	}

	protected function get_path( $ext ) {
		return sprintf( 'assets/dist/%s.bundle.%s', $this->type, $ext );
	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}
