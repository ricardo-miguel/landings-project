<?php
/**
 * Landings Project - < Connector class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package landings
 */

namespace Landings;

/**
 * Connector class
 * WordPress actions for the bridge between plugin itself and web service
 */
class Connector extends API {

	/**
	 * Class construct
	 * 
	 * @since 0.1
	 */
	function __construct() {
		$this->init();
	}

	/**
	 * Initializes WordPress actions for API mirroring
	 *
	 * @return void
	 */
	function init() {
		add_action( 'wp_ajax_landings_get_channels', array( $this, 'get_channels' ) );
		add_action( 'wp_ajax_nopriv_landings_get_channels', array( $this, 'get_channels' ) );
	}

	/**
	 * GET /channels
	 * GET /channels/:id
	 * GET /channels/:code
	 *
	 * @return void
	 */
	public function get_channels() {
		$nonce = wp_create_nonce( 'landings_get_channels' );
		if ( Utils::check_nonce( 'landings_get_channels', $nonce ) ) {
			$id       = ( array_key_exists( 'id', $_GET ) ) ? wp_unslash( $_GET['id'] ) : false;
			$code     = ( array_key_exists( 'code', $_GET ) ) ? wp_unslash( $_GET['code'] ) : false;
			$channels = $this->get( 'channels' );
			wp_send_json( $channels );
		}
		wp_send_json( false );
	}

}
