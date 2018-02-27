<?php
/**
 * Landings Project - < Utils class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package landings
 */

namespace Landings;

/**
 * [Admin] Core class
 * Cross-wide static functions
 *
 * @since 0.1
 */
class Utils {

	/**
	 * Build a file path string
	 *
	 * @param   array $array   Ordered path to file.
	 * @return  string|bool    System file path.
	 */
	public static function path( $array = array() ) {
		if ( ! is_array( $array ) ) {
			return false;
		} else {
			$path  = LANDINGS_PATH;
			$path .= implode( DIRECTORY_SEPARATOR, $array );
			return $path;
		}
	}

	/**
	 * Check valid nonce for WordPress actions
	 *
	 * @param   string $action   Action name.
	 * @param   string $nonce    Nonce code.
	 * @return  bool
	 */
	public static function check_nonce( $action = '', $nonce = '' ) {
		$_action = ( isset( $_REQUEST['action'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : $action; // Input var okay.
		$_nonce  = ( isset( $_REQUEST['nonce'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : $nonce; // Input var okay.

		if ( empty( $_action ) || empty( $_nonce ) ) {
			return false;
		}

		return wp_verify_nonce( $_nonce, $_action );
	}

	/**
	 * Build HTML code with variables
	 * Any bracket reference in HTML code which are not defined
	 * by the array will be deleted.
	 *
	 * @since   0.2
	 * @param   string $html   HTML code.
	 * @param   array  $vars   Associative array with variable definitions.
	 * @return  string|bool    Parsed HTML code or FALSE if it fails.
	 */
	private function build_html( $html = '', $vars = array() ) {
		if ( empty( $html ) ) {
			return false;
		}

		if ( is_array( $vars ) && ! empty( $vars ) ) {
			foreach ( $vars as $key => $value ) {
				$replace = '{' . $key . '}';
				$html    = str_replace( $replace, $value, $html );
			}

			$html = preg_replace( '/\{(\S+)\}/', '', $html );
		}

		return $html;
	}

	/**
	 * Returns parsed HTML from given HTML string
	 *
	 * @since   0.2
	 * @param   string $html_string   HTML code as string.
	 * @param   array  $vars          Associative array containing variable key names and their definitions.
	 * @param   bool   $return        Whether result is returned (TRUE) or printed (FALSE). Default: false.
	 * @return  string|bool           Parsed HTML code or FALSE if it fails.
	 */
	public static function build_html_from_string( $html_string = '', $vars = array(), $return = false ) {
		$html_build = (new Utils())->build_html( $html_string, $vars );
		if ( $return ) {
			return $html_build;
		} else {
			echo esc_html( $html_build );
		}
	}

	/**
	 * Returns parsed HTML from given HTML file path or URI
	 *
	 * @since   0.2
	 * @param   string $html_path   HTML file path or URI.
	 * @param   array  $vars        Associative array containing variable key names and their definitions.
	 * @param   bool   $return      Whether result is returned (TRUE) or printed (FALSE). Default: false.
	 * @return  string|void|bool    Parsed HTML code or FALSE if it fails.
	 */
	public static function build_html_from_file( $html_path = '', $vars = array(), $return = false ) {
		$html_string = file_get_contents( $html_path );
		$html_build  = (new Utils())->build_html( $html_string, $vars );
		if ( $return ) {
			return $html_build;
		} else {
			echo wp_kses_post( $html_build );
		}
	}

	/**
	 * Get a file asset directory by its extension
	 *
	 * @param   string $extension   Extension name (e.g. css, js, svg and so on).
	 * @param   string $folder      Relative directory path from assets folder.
	 * @return  string              Directory name.
	 */
	protected static function get_asset_dir( $extension = '', $folder = '' ) {
		$hierarchy = array(
			'css'      => array( 'css', 'scss' ),
			'js'       => array( 'js', 'json' ),
			'webfonts' => array( 'eot', 'woff', 'woff2' ),
		);
		foreach ( $hierarchy as $dirname => $ext ) {
			if ( in_array( $extension, $ext, true ) ) {
				return ( ! empty( $folder ) ) ? $folder . '/' . $dirname : $dirname;
			}
		}
		return false;
	}

	/**
	 * Register and enqueue assets
	 *
	 * @param   string|array $assets   Asset filename or collection of filenames.
	 * @param   string       $folder   Relative directory path from assets folder.
	 * @return  void|bool
	 */
	protected static function load_assets( $assets = array(), $folder = '' ) {
		if ( empty( $assets ) ) {
			return false;
		} else {
			$assets = ( is_string( $assets ) ) ? array( $assets ) : $assets;
			foreach ( $assets as $asset ) {
				$file = explode( '.', $asset );
				if ( is_array( $file ) ) {
					$dir  = self::get_asset_dir( end( $file ), $folder );
					$slug = LANDINGS_ADMIN_SLUG . '-' . implode( '-', $file );
					$uri  = LANDINGS_URL . 'assets/' . $dir . '/' . $asset;
					if ( 'admin/css' === $dir || 'public/css' === $dir ) {
						wp_enqueue_style( $slug, $uri );
					}
					if ( 'admin/js' === $dir || 'public/js' === $dir ) {
						wp_enqueue_script( $slug, $uri, 'jquery' );
					}
				}
			}
		}
	}

	/**
	 * Register and enqueue public assets desired to be shown at front-end
	 *
	 * @param   string|array $assets   Asset filename or collection of filenames.
	 * @return  void|bool
	 */
	public static function load_public_assets( $assets = array() ) {
		return self::load_assets( $assets, 'public' );
	}

	/**
	 * Register and enqueue non-public assets desired to be shown at admin dashboard
	 *
	 * @param   string|array $assets   Asset filename or collection of filenames.
	 * @return  void|bool
	 */
	public static function load_admin_assets( $assets = array() ) {
		return self::load_assets( $assets, 'admin' );
	}

	/**
	 * Load a HTML file, including and parsing variables for dynamic output
	 *
	 * @param   string $page   HTML file name. May prepend relative path.
	 * @param   array  $vars    Collection of variables to be included within file.
	 * @return  void|bool
	 */
	public static function load_admin_page( $page = '', $vars = array() ) {
		if ( ! is_string( $page ) ) {
			return false;
		} else {
			self::build_html_from_file(
				self::path(
					array(
						'includes',
						'admin',
						'pages',
						$page,
					)
				),
				$vars
			);
		}
	}

	/**
	 * Include SVG graphic as base64 string
	 *
	 * @since   0.2
	 * @param   string $path   SVG path route.
	 * @return  string|bool
	 */
	public static function svg64( $path = '' ) {
		if ( empty( $path ) ) {
			return false;
		} else {
			if ( file_exists( $path ) ) {
				$base  = 'data:image/svg+xml;base64,';
				$base .= base64_encode( file_get_contents( $path ) );
				return $base;
			}
		}
	}
}
