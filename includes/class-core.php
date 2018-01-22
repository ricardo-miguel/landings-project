<?php
/**
 * Lansub - < Core class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package lansub
 */

namespace Lansub;

/**
 * Core class
 * All needed actions and filters are settled here.
 */
class Core {

	/**
	 * Loads all needed components
	 *
	 * @since   0.1
	 * @return  void
	 */
	function init() {
		$connector = new Connector();
		$connector->init();
	}
}
