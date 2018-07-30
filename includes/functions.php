<?php
/**
 *
 * Functions loaded
 *
 * @package includes\functions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

function boilerplate_admin_notice( $message, $type = 'error' ) {
?>
	<div class="<?php echo esc_attr( $type ); ?> notice is-dismissible">
		<p>
			<strong><?php esc_html_e( 'Boilerplate plugin: ', 'boilerplate' ); ?></strong>

			<?php echo $message; // wpcs: XSS ok! ?>
		</p>
	</div>
<?php
}

function boilerplate_php_version_wrong() {
	/* translators: %s: phpversion() */
	boilerplate_admin_notice( sprintf( esc_html__( 'Your PHP version (%s) is not supported. Required is 5.3+', 'boilerplate' ), phpversion() ) );
}

function boilerplate_vendor_not_found() {
	boilerplate_admin_notice( wp_kses( __( 'Please install plugin dependencies. Use <code>composer install</code>', 'boilerplate' ), [ 'code' => true ] ) );
}
