<?php
/**
 * Landings Project - < Metaboxes class >
 * This is a built-in script, please do not
 * modify if is not really necessary.
 *
 * @package landings
 */

namespace Landings\Admin;

use \Landings\Utils as Utils;

/**
 * Metaboxes class
 * All needed actions and filters are settled here.
 *
 * @since 0.3
 */
class Metaboxes {

	/**
	 * Initializes custom meta boxes
	 *
	 * @return void
	 */
	function init() {
		add_meta_box( 'layout', __( 'Layout', 'landings-project' ), [ $this, 'layout' ], 'landing', 'normal', 'high' );
	}

	/**
	 * Display layout metabox
	 *
	 * @param   int $post   Custom post type ID.
	 * @return  void
	 */
	public function layout( $post ) {
		Utils::build_html_from_file( Utils::path( [ 'includes', 'templates', 'metaboxes', 'layout.html' ] ) );
	}

}
