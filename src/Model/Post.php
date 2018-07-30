<?php
/**
 *
 * Model for posts handler
 *
 * @package Boilerplate\Model\Post
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Post {

	private static $_instance = null;

	public function get_by_slug( $slug, $post_type ) {
		global $wpdb;

		$cache_key = sanitize_key( $post_type . $slug );
		$posted    = wp_cache_get( $cache_key, 'get_post_by_slug' );

		if ( false !== $posted ) {
			return $posted;
		}

		$post_id = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT `ID`
				 FROM `{$wpdb->posts}`
				 WHERE `post_name` = %s
				   AND `post_type` = %s
				 LIMIT 1
				",
				$slug,
				$post_type
			)
		);

		if ( ! $post_id ) {
			return false;
		}

		$posted = get_post( $post_id );

		wp_cache_set( $cache_key, $posted, 'get_post_by_slug' );

		return $posted;
	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}
