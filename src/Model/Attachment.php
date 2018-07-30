<?php
/**
 *
 * Model attachments uploads process
 *
 * @package Boilerplate\Model\Attachment
 * @author  Victor Freitas
 * @since   0.1.0
 * @link    https://github.com/victorfreitas
 */

namespace Boilerplate\Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class Attachment {

	private static $_instance = null;

	protected $post_id = 0;

	public $table;

	const VERSION = '0.1.0';

	public function __construct( $post_id = 0 ) {
		$this->set_post_id( $post_id );
		$this->set_table();
	}

	protected function set_post_id( $post_id ) {
		$this->post_id = absint( $post_id );
	}

	public function get_post_id() {
		return $this->post_id;
	}

	protected function set_table() {
		global $wpdb;
		$this->table = $wpdb->prefix . 'custom_attachment_upload_references';
	}

	public function upload_from_url( $url, $title = '' ) {
		$url           = esc_url( $url );
		$attachment_id = $this->reference_exists( $url );

		if ( $attachment_id ) {
			return $attachment_id;
		}

		unset( $attachment_id );

		$bits = $this->request_bits( $url );

		if ( empty( $bits ) ) {
			return 0;
		}

		$filename = pathinfo( $url, PATHINFO_BASENAME );
		$upload   = wp_upload_bits( $filename, '', $bits );

		if ( ! empty( $upload['error'] ) ) {
			return 0;
		}

		$this->includes();

		$title         = $this->parse_title( $url, $title );
		$attachment_id = $this->insert_attachment( $upload, $title );
		$metadata      = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );

		wp_update_attachment_metadata( $attachment_id, $metadata );

		$this->add_source( $url, $attachment_id );

		return $attachment_id;
	}

	public function includes( $is_media_upload = false ) {
		if ( ! function_exists( 'wp_crop_image' ) ) {
			require_once ABSPATH . 'wp-admin/includes/image.php';
		}

		if ( ! is_admin() && $is_media_upload ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			require_once ABSPATH . 'wp-admin/includes/media.php';
		}
	}

	public function reference_exists( $url ) {
		global $wpdb;

		// @codingStandardsIgnoreStart
		$attachment_id = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT `attachment_id`
				 FROM `{$this->table}`
				 WHERE `source` = %s
				 LIMIT 1
				",
				$url
			)
		);
		// @codingStandardsIgnoreEnd

		return $attachment_id;
	}

	public function request_bits( $url ) {
		$response = wp_safe_remote_get( $url, [ 'timeout' => 60 ] );

		return wp_remote_retrieve_body( $response );
	}

	public function parse_title( $url, $title ) {
		if ( $title ) {
			return $title;
		}

		return pathinfo( $url, PATHINFO_FILENAME );
	}

	public function insert_attachment( $upload, $title ) {
		$info = wp_check_filetype( $upload['file'] );
		$args = [
			'post_mime_type' => $info['type'],
			'guid'           => $upload['url'],
			'post_title'     => $title,
			'post_parent'    => $this->get_post_id(),
		];

		return wp_insert_attachment( $args, $upload['file'] );
	}

	public function add_source( $url, $attachment_id ) {
		global $wpdb;

		$wpdb->insert(
			$this->table,
			[
				'post_id'       => $this->get_post_id(),
				'attachment_id' => $attachment_id,
				'source'        => $url,
			],
			[
				'%d',
				'%d',
				'%s',
			]
		);
	}

	public function media_upload( $name ) {
		// phpcs:ignore WordPress.VIP.SuperGlobalInputUsage.AccessDetected
		if ( empty( $_FILES[ $name ]['tmp_name'] ) ) {
			return false;
		}

		$this->includes( true );

		$id = media_handle_upload( $name, $this->get_post_id() );

		return is_wp_error( $id ) ? false : $id;
	}

	public function get_option_key() {
		return $this->table . '_db_version';
	}

	public function create_table() {
		global $wpdb;

		if ( self::VERSION === get_option( $this->get_option_key() ) ) {
			return;
		}

		$charset = $wpdb->get_charset_collate();
		$sql     = "CREATE TABLE {$this->table} (
			`id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`post_id` bigint(20) NOT NULL,
			`attachment_id` bigint(20) NOT NULL,
			`source` varchar(255) NOT NULL,
			key `post_id` (`post_id`),
			key `source` (`source`)
		) {$charset} ENGINE = InnoDB;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );
		update_option( $this->get_option_key(), self::VERSION );
	}

	public function uninstall() {
		global $wpdb;

		/* Remove option table db version */
		delete_option( $this->get_option_key() );

		/* Remove custom table attachment upload references */
		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.SchemaChange, WordPress.WP.PreparedSQL.NotPrepared, WordPress.VIP.DirectDatabaseQuery.NoCaching
		$wpdb->query( "DROP TABLE IF EXISTS {$this->table}" );
	}

	public static function instance( $post_id = 0 ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $post_id );
		}

		return self::$_instance;
	}
}
