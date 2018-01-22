<?php
/**
 * Lansub - < Connector class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package lansub
 */

namespace Lansub;

/**
 * Connector class
 * WordPress actions for the bridge between plugin itself and web service
 */
class Connector extends API {

	/**
	 * Initializes WordPress actions for API mirroring
	 *
	 * @return void
	 */
	function init() {
		add_action( 'wp_ajax_lansub_get_channels', array( $this, 'get_channels' ) );
		add_action( 'wp_ajax_nopriv_lansub_get_channels', array( $this, 'get_channels' ) );
	}

	/**
	 * GET /channels
	 * GET /channels/:id
	 * GET /channels/:code
	 *
	 * @return void
	 */
	public function get_channels() {
		$id		= $_GET['id'];
		$code	= $_GET['code'];

		if ( isset( $id ) ) {

		}

		$channels = $this->get( 'channels' );
		wp_send_json( $channels );
	}

}
