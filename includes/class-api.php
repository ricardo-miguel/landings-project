<?php
/**
 * Lansub - < API class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package lansub
 */

namespace Lansub;

/**
 * API class
 * Sort of bridge between plugin itself and web service
 */
class API {

	/**
	 * API URI
	 *
	 * @var string
	 */
	protected $service;

	/**
	 * Common request headers
	 *
	 * @var array
	 */
	protected $headers;

	/**
	 * Class constructor
	 */
	function __construct() {
		$this->service = get_option( 'lansub_api_uri' );
		$this->headers = array(
			'cache-control' => 'no-cache',
			'x-api-key'     => get_option( 'lansub_api_key' ),
			'Content-Type'  => 'application/json; charset=utf-8',
		);
	}

	/**
	 * Send a GET request and retrieve its response
	 *
	 * @param    string  $action    API action to be executed.
	 * @param    boolean $json      Whether return JSON void or object.
	 * @return   void|object
	 */
	public function get( $action = '', $json = true ) {
		$output = $this->request( $action );

		if ( $json ) {
			wp_send_json( $output );
		} else {
			return json_decode( $output );
		}
	}

	/**
	 * Send a POST request and retrieve its response
	 *
	 * @param    string  $action    API action to be executed.
	 * @param    array   $fields    Associative data collection to be sent.
	 * @param    boolean $json      Whether return JSON void or object.
	 * @return   void|object
	 */
	public function post( $action = '', $fields = array(), $json = true ) {
		$output = $this->request( $action, 'POST', $fields );

		if ( $json ) {
			wp_send_json( $output );
		} else {
			return json_decode( $output );
		}
	}

	/**
	 * HTTP request abstract
	 *
	 * @param    string $action    API action to be executed.
	 * @param    string $verb      Request method: GET, HEAD, POST, PUT, DELETE, CONNECT, OPTIONS and TRACE.
	 * @param    array  $fields    Data collection for allowed methods.
	 * @return   string            Request response.
	 */
	protected function request( $action = '', $verb = 'GET', $fields = array() ) {
		$url        = ( substr( $this->service, -1 ) === '/' ) ? $this->service . $action : $this->service . '/' . $action;

		$request    = wp_remote_request(
			$url,
			array(
				'method'    => $verb,
				'headers'   => $this->headers,
				'body'      => $fields,
			)
		);

		if ( is_wp_error() ) {
			return $request;
		}

		return json_decode( $request['body'] );
	}
}
