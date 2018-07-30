<?php
/**
 *
 * Helper for general code formatting
 *
 * @package Boilerplate\Helper\Format
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Format {

	public static function date( $date, $format = 'd/m/Y' ) {
		return esc_html( date_i18n( $format, strtotime( $date ) ) );
	}

	public static function convert_date_for_sql( $date, $format = 'Y-m-d H:i' ) {
		return empty( $date ) ? false : self::convert_date( $date, $format, '/', '-' );
	}

	public static function convert_date_human( $date, $format = 'd/m/Y' ) {
		return empty( $date ) ? false : self::convert_date( $date, $format, false );
	}

	public static function convert_date( $date, $format = 'Y-m-d H:i', $search = '/', $replace = '-' ) {
		if ( $search && $replace ) {
			$date = str_replace( $search, $replace, $date );
		}

		return self::date( $date, $format );
	}

	public static function convert_float_for_sql( $value ) {
		$value = str_replace( '.', '', $value );

		return str_replace( ',', '.', $value );
	}

	public static function price( $price ) {
		return number_format( (float) $price, 2, ',', '.' );
	}

	public static function phone( $number ) {
		if ( strlen( $number ) < 10 ) {
			return preg_replace(
				'/(\d{1})?(\d{4})(\d{4})/',
				'$1 $2-$3',
				$number
			);
		}

		return preg_replace(
			[ '/[^\d]+/', '/(\d{2})(\d{1})?(\d{4})(\d{4})/' ],
			[ '', '($1) $2 $3-$4' ],
			$number
		);
	}

	public static function cpf( $number ) {
		if ( ! is_numeric( $number ) || strlen( $number ) < 11 ) {
			return $number;
		}

		return preg_replace(
			'/(\d{3})(\d{3})(\d{3})(\d{2})/',
			'$1.$2.$3-$4',
			$number
		);
	}

	public static function rg( $number ) {
		if ( ! is_numeric( $number ) || strlen( $number ) > 10 ) {
			return $number;
		}

		return preg_replace(
			'/(\d{2})(\d{3})(\d{3})(\d{1,2})/',
			'$1.$2.$3-$4',
			$number
		);
	}

	public static function cnpj( $number ) {
		return preg_replace(
			'/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
			'$1.$2.$3/$4-$5',
			$number
		);
	}

	public static function json_decode_quoted( $data, $is_assoc = true ) {
		return json_decode( str_replace( '&quot;', '"', $data ), $is_assoc );
	}
}
