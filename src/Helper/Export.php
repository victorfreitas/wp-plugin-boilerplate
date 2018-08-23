<?php
/**
 *
 * Helper for headers exports
 *
 * @package Boilerplate\Helper\Export
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Export {

	public static function xls( $name, $table ) {
		header( 'Content-type: application/x-msexcel; charset=UTF-8' );
		header( 'Content-Disposition: attachment; filename="' . $name . '.xls"' );
		header( 'Content-Description: PHP Generated Data' );

		echo wp_kses(
			mb_convert_encoding( $table, 'HTML-ENTITIES', 'utf-8' ),
			wp_kses_allowed_html( 'post' )
		);

		exit( 0 );
	}
}
