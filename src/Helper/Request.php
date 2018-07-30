<?php
/**
 *
 * Helper for requests process
 *
 * @package Boilerplate\Helper\Request
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Request {

	public static function filter_input( $type, $name, $default, $callable = 'rm_tags' ) {
		$req = filter_input_array( $type );

		if ( empty( $req[ $name ] ) ) {
			return $default;
		}

		return self::call( $callable, $req[ $name ] );
	}

	public static function post( $name, $default = '', $callable = 'rm_tags' ) {
		return self::filter_input( INPUT_POST, $name, $default, $callable );
	}

	public static function get( $name, $default = '', $callable = 'rm_tags' ) {
		return self::filter_input( INPUT_GET, $name, $default, $callable );
	}

	public static function cookie( $name, $default = '', $callable = 'rm_tags' ) {
		return self::filter_input( INPUT_COOKIE, $name, $default, $callable );
	}

	public static function server( $key, $default = '', $callable = 'rm_tags' ) {
		return self::filter_input( INPUT_SERVER, strtoupper( $key ), $default, $callable );
	}

	public static function verify_nonce_post( $name, $action ) {
		return wp_verify_nonce( self::post( $name, false ), $action );
	}

	public static function call( $callable, $value ) {
		if ( ! is_callable( $callable ) ) {
			return self::default_call( $callable, $value );
		}

		if ( is_array( $value ) ) {
			return array_map( $callable, $value );
		}

		return call_user_func( $callable, $value );
	}

	public static function default_call( $callable, $value ) {
		if ( false === $callable ) {
			return $value;
		}

		return Utils::rm_tags( $value, true );
	}

	public static function is_ajax() {
		return ( strtolower( self::server( 'HTTP_X_REQUESTED_WITH' ) ) === 'xmlhttprequest' );
	}

	public static function json_encode( $value ) {
		return wp_json_encode( $value, JSON_HEX_APOS );
	}

	public static function get_raw_data( $assoc = true ) {
		if ( version_compare( phpversion(), '5.6', '>=' ) ) {
			return self::get_body( $assoc );
		}

		global $HTTP_RAW_POST_DATA;

		return json_decode( $HTTP_RAW_POST_DATA, $assoc );
	}

	public static function get_body( $assoc ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions, WordPress.VIP.RestrictedFunctions
		$body = file_get_contents( 'php://input' );

		return json_decode( $body, $assoc );
	}

	public static function get_header( $name ) {
		return self::server( "http_{$name}" );
	}
}
