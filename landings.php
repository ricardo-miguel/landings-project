<?php
/**
 * Plugin Name: Landings Project
 * Plugin URI: //digevo.com
 * Description: Landing pages builder. Formerly known as Digevo Landings.
 * Version: 0.3 alpha
 * Author: <a href="//ricardomiguel.cl">Ricardo Miguel</a>.
 * License: EULA
 *
 * @package landings
 */

/**
 * Avoid direct file access
 *
 * @since   0.1
 */
defined( 'ABSPATH' ) || die( 'Don\'t try so hard!' );

/**
 * Set current version
 *
 * @since   0.1
 */
define( 'LANDINGS_VERSION', '0.3 alpha' );

/**
 * Set common constants
 *
 * @since   0.1
 */
define( 'LANDINGS_URL', plugin_dir_url( __FILE__ ) );
define( 'LANDINGS_PATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR );
define( 'LANDINGS_NAMESPACE', 'Landings' );
define( 'LANDINGS_ADMIN_SLUG', 'landings' );

/**
 * Class loader function
 *
 * @since   0.1
 * @param   string $class Class name.
 * @return  void
 */
function landings_class_loader( $class ) {
	$namespace  = LANDINGS_NAMESPACE . '\\';

	if ( strpos( $class, $namespace ) !== false ) {
		$class      = strtolower( str_replace( $namespace, '', $class ) );
		$path_array = explode( '\\', $class );
		$file       = false;

		if ( count( $path_array ) > 1 ) {
			$dir_array  = array_slice( $path_array, 0, -1 );
			$file_path  = implode( DIRECTORY_SEPARATOR, $dir_array );
			$file_name  = DIRECTORY_SEPARATOR . 'class-' . end( $path_array ) . '.php';
			$file       = DIRECTORY_SEPARATOR . $file_path . $file_name;
		} else {
			$file       = DIRECTORY_SEPARATOR . 'class-' . $class . '.php';
		}

		$file   = LANDINGS_PATH . 'includes' . $file;

		if ( file_exists( $file ) ) {
			include $file;
		}
	}
}

spl_autoload_register( 'landings_class_loader' );


/**
 * Initializes plugin
 *
 * @since   0.1
 * @return  void
 */
function landings_init() {
	new Landings\Core();
	if ( is_admin() ) {
		new Landings\Admin\Core();
	}
}

add_action( 'init', 'landings_init' );
