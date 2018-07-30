<?php
/**
 *
 * Helper for ajax handlers
 *
 * @package Boilerplate\Helper\Ajax
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Ajax {

	public static function error_server_json( $code, $message = 'Generic Message Error', $echo = true ) {
		return self::handle_server_json( $code, 'error', $message, $echo );
	}

	public static function success_server_json( $code, $message = 'Generic Message Success', $echo = true ) {
		return self::handle_server_json( $code, 'success', $message, $echo );
	}

	public static function handle_server_json( $code, $status, $message, $echo = true ) {
		$response = wp_json_encode(
			[
				'code'    => $code,
				'status'  => $status,
				'message' => $message,
			]
		);

		if ( ! $echo ) {
			return $response;
		}

		echo $response; // WPCS: XSS ok!
	}
}
