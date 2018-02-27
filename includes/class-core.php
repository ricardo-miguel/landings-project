<?php
/**
 * Landings Project - < Core class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package landings
 */

namespace Landings;

/**
 * Core class
 * All needed actions and filters are settled here.
 * 
 * @since 0.1
 */
class Core {

	/**
	 * Class construct
	 * 
	 * @since   0.1
	 * @return  void
	 */
	function __construct() {
		$this->init();
	}

	/**
	 * Loads all needed components
	 *
	 * @since   0.1
	 * @return  void
	 */
	private function init() {
		$this->landing_post_type();
		$this->general_hooks();

		$connector = new Connector();
		$connector->init();
	}

	/**
	 * Misc. hooks to be executed across the whole WordPress
	 *
	 * @since   0.3
	 * @return  void
	 */
	private function general_hooks() {
		add_action( 'login_enqueue_scripts', function() {
			Utils::load_public_assets( 'login.min.css' );
		} );
	}

	/**
	 * Landing's custom post type registration
	 *
	 * @since   0.3
	 * @return  void
	 */
	private function landing_post_type() {
		register_post_type( 
			'landing',
			array(
				'labels' => array(
					'name' => __( 'Landings', 'landings' ),
					'singular_name' => __( 'Landing', 'landings' )
				),
				'description' => __( 'Multipurpose landing page.', 'landings' ),
				'public' => true,
				'menu_position' => 4,
				'menu_icon' => Utils::svg64( LANDINGS_PATH . 'assets/public/symbol.svg' )
			) 
		);
	}
}
