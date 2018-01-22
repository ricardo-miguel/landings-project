<?php
/**
 * Plugin Name: Lansub
 * Plugin URI: //digevo.com
 * Description: Gestión de landing pages.
 * Version: 0.3a
 * Author: <a href="//ricardomiguel.cl">Ricardo Miguel</a>.
 * License: EULA
 *
 * @package lansub
 */

/**
 * Avoid direct file access
 *
 * @since   0.1
 */
defined( 'ABSPATH' ) || die( 'No script kiddies, please!' );

/**
 * Set current version
 *
 * @since   0.1
 */
define( 'LANSUB_VERSION', '0.3 alpha' );

/**
 * Set common constants
 *
 * @since   0.1
 */
define( 'LANSUB_URL', plugin_dir_url( __FILE__ ) );
define( 'LANSUB_PATH', plugin_dir_path( __FILE__ ) );
define( 'LANSUB_NAMESPACE', 'Lansub' );

/**
 * Class loader function
 *
 * @param string $class Class name.
 * @return void
 */
function lansub_class_loader( $class ) {
	$namespace  = LANSUB_NAMESPACE . '\\';

	if ( strpos( $class, $namespace ) !== false ) {
		$class		= strtolower( str_replace( $namespace, '', $class ) );
		$path_array	= explode( '\\', $class );
		$file		= false; 

		if( is_array( $path_array ) ) {
			$dir_array	= array_slice( $path_array, 0, -1 );
			$file_path	= implode( DIRECTORY_SEPARATOR, $dir_array );
			$file_name	= DIRECTORY_SEPARATOR . 'class-' . end( $path_array ) . '.php';
			$file		= $file_path . $file_name;
		} else {
			$file		= DIRECTORY_SEPARATOR . 'class-' . $class . '.php';
		}

		$file	= LANSUB_PATH . 'includes' . DIRECTORY_SEPARATOR . $file;

		if( file_exists( $file ) ) {
			include $file;
		}
	}

}

spl_autoload_register( 'lansub_class_loader' );


/**
 * Initializes plugin
 *
 * @since   0.1
 * @return  void
 */
function lansub_init() {
	if( is_admin() ) {
		$admin = new Lansub\Admin\Core();
		$admin->init();
	}

	$lansub = new Lansub\Core();
	$lansub->init();
}

add_action( 'init', 'lansub_init' );
