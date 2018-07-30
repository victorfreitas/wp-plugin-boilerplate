<?php
/**
 *
 * Helper for general posts handler
 *
 * @package Boilerplate\Helper\Post
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

use WP_Query;

use Boilerplate\Model\Post as M_Post;

class Post {

	public static function get_current_id() {
		if ( Request::get( 'post' ) ) {
			return Request::get( 'post', false, 'absint' );
		}

		if ( Request::post( 'post_ID' ) ) {
			return Request::post( 'post_ID', false, 'absint' );
		}

		return absint( get_the_ID() );
	}

	public static function get_terms( $post, $taxonomy ) {
		$terms = get_the_terms( $post, $taxonomy );

		return is_array( $terms ) ? $terms : false;
	}

	public static function get_terms_field( $post, $taxonomy, $field ) {
		$terms = self::get_terms( $post, $taxonomy );

		if ( ! $terms ) {
			return false;
		}

		$list = [];

		foreach ( $terms as $term ) {
			if ( isset( $term->{$field} ) ) {
				$list[] = $term->{$field};
			}
		}

		return $list;
	}

	public static function get_permalink_by_slug( $slug, $post_type ) {
		$post = M_Post::instance()->get_by_slug( $slug, $post_type );

		return $post ? get_permalink( $post ) : false;
	}

	public static function get_query( $args = [], $defaults = [] ) {
		return new WP_Query( wp_parse_args( $args, $defaults ) );
	}
}
