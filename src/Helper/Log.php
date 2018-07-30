<?php
/**
 *
 * Helper for creating logs for debug
 *
 * @package Boilerplate\Helper\Log
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Boilerplate\Config\App;

class Log {

	public static function debug( $message ) {
		return self::instance()->debug( $message );
	}

	public static function instance( $name = 'debug' ) {
		$logger  = new Logger( 'debugger' );
		$handler = new StreamHandler(
			App::plugin_dir_path( "logs/{$name}.log" ),
			Logger::DEBUG
		);

		return $logger->pushHandler( $handler );
	}

	public static function push( $message ) {
		if ( ! is_array( $message ) ) {
			return self::debug( $message );
		}

		foreach ( $message as $key => $value ) :
			if ( is_array( $value ) ) {
				self::push( $value );
				continue;
			}

			self::debug( "{$key}: {$value}" );
		endforeach;
	}
}
