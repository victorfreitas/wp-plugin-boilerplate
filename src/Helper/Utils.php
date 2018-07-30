<?php
/**
 *
 * Helper for general utilities
 *
 * @package Boilerplate\Helper\Utils
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use Boilerplate\Config\App;

class Utils {

	public static function plugin_dir_path( $path ) {
		return plugin_dir_path( App::get_plugin_file() ) . $path;
	}

	public static function plugin_rel_path( $path ) {
		return dirname( plugin_basename( App::get_plugin_file() ) ) . '/' . $path;
	}

	public static function plugins_url( $path ) {
		return plugins_url( $path, App::get_plugin_file() );
	}

	public static function filemtime( $path ) {
		return filemtime( self::plugin_dir_path( $path ) );
	}

	public static function rm_tags( $value, $remove_breaks = false ) {
		if ( empty( $value ) || is_object( $value ) ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			return array_map( __METHOD__, $value );
		}

		return wp_strip_all_tags( $value, $remove_breaks );
	}

	public static function esc_html( $value ) {
		if ( empty( $value ) || is_object( $value ) ) {
			return $value;
		}

		if ( is_array( $value ) ) {
			return array_map( __METHOD__, $value );
		}

		return esc_html( $value );
	}

	public static function get_value( $list, $key, $default = '' ) {
		return self::has_key( $list, $key ) ? $list[ $key ] : $default;
	}

	public static function selected( $selected, $current ) {
		if ( ! is_array( $current ) ) {
			return selected( $selected, $current, false );
		}

		return in_array( $selected, $current, true ) ? 'selected="selected"' : '';
	}

	public static function indexof( $value, $search ) {
		return ( false !== strpos( $value, $search ) );
	}

	public static function get_current_host() {
		return wp_parse_url( home_url(), PHP_URL_HOST );
	}

	public static function has_key( $list, $key ) {
		return ( array_key_exists( $key, $list ) && $list[ $key ] );
	}

	public static function get_ipinfo() {
		$response = wp_safe_remote_get(
			'https://ipinfo.io/json',
			[ 'httpversion' => '1.1' ]
		);

		return json_decode( wp_remote_retrieve_body( $response ) );
	}
}
