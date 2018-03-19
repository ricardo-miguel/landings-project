<?php
/**
 * Landings - < Menu class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package landings
 */

namespace Landings\Admin;

use \Landings\Utils as Utils;

/**
 * [Admin] Menu class
 * Enables plugin admin menu and its pages.
 *
 * @since   0.2
 */
class Menu {

	/**
	 * Home page slug
	 *
	 * @since   0.2
	 * @var     string
	 */
	private $home;

	/**
	 * Class construct
	 *
	 * @since   0.2
	 * @return  void
	 */
	function __construct() {
		$this->home = LANDINGS_ADMIN_SLUG . '-home';
		$this->init();
	}

	/**
	 * Initializes menu relative actions.
	 *
	 * @since   0.2
	 * @return  void
	 */
	function init() {
		add_action( 'admin_bar_menu', array( $this, 'logo_bar_menu' ), 1 );
		add_action( 'admin_bar_menu', array( $this, 'custom_bar_menu' ), 90 );
		add_action( 'admin_menu', array( $this, 'build' ) );
	}

	/**
	 * Prepend plugin's logo at admin bar.
	 *
	 * @return void
	 */
	function logo_bar_menu() {
		global $wp_admin_bar;
		$wp_admin_bar->add_node(
			[
				'id'    => 'landings-project',
				'title' => '<img src="' . LANDINGS_URL . 'assets/public/logo_small.png" />',
				'href'  => '/',
				'meta'  => [
					'class' => 'landings-admin-bar',
				],
			]
		);
	}

	/**
	 * Modifies top bar nodes.
	 *
	 * @return void
	 */
	function custom_bar_menu() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_node( 'wp-logo' );
	}

	/**
	 * Build plugin menu and its sub-elements (if apply).
	 *
	 * @since   0.2
	 * @return  void
	 */
	public function build() {
		add_menu_page(
			__( 'General', 'landings' ),
			__( 'Landings Settings', 'landings' ),
			'edit_pages',
			$this->home,
			array( $this, 'home' ),
			'dashicons-admin-generic',
			75
		);
	}

	/**
	 * Admin home page
	 *
	 * @since   0.2
	 * @return  void
	 */
	public function home() {
		Utils::load_public_assets( 'fontawesome-all.min.css' );
		Utils::load_admin_assets( 'home.min.css' );
		Utils::load_admin_page(
			'home.html', array(
				'LOGO' => LANDINGS_URL . 'assets/public/logo.png',
			)
		);
	}
}
