<?php
/**
 * Landings Project - < Admin Core class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package landings
 */

namespace Landings\Admin;

use \Landings\Utils as Utils;

/**
 * [Admin] Core class
 * All needed actions and filters are settled here.
 *
 * @since 0.1
 */
class Core {

	/**
	 * Class construct
	 *
	 * @since 0.1
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
	function init() {
		$this->general_admin_hooks();
		// TODO: EVERYTHING.
		new Menu();
	}

	/**
	 * Misc. hooks to be executed across dashboard
	 *
	 * @return void
	 */
	function general_admin_hooks() {
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
		wp_admin_css_color(
			'landings',
			__( 'Landings Project', 'landings' ),
			LANDINGS_URL . 'assets/admin/css/scheme/colors.min.css',
			array( '#222222', '#6a5bb4', '#CCCCCC', '#F0F0F0' ),
			array(
				'base' => '#F0F0F0',
				'focus' => '#F0F0F0',
				'current' => '#F0F0F0',
			)
		);
	}

}
