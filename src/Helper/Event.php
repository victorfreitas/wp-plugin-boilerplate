<?php
/**
 *
 * Helper for event stream
 *
 * @package Boilerplate\Helper\Event
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Event {

	public static function emit( $event, $data = '' ) {
		printf( "event: %s\ndata: %s\n\n", $event, $data ); // WPCS: XSS ok!
		self::flush();
	}

	public static function flush() {
		while ( ob_get_level() > 0 ) {
			ob_end_flush();
		}

		flush();
	}

	public static function headers() {
		header( "Content-Type: text/event-stream\n\n" );
		header( "Cache-Control: no-cache\n\n" );
		header( "X-Accel-Buffering: no\n\n" );
	}

	public static function set_max_execution() {
		// @codingStandardsIgnoreStart
		@set_time_limit( 0 );
		@ini_set( 'max_execution_time', 0 );
		@ini_set( 'memory_limit', -1 );
		// @codingStandardsIgnoreEnd
	}
}
