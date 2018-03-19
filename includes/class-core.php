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
 * All base hooks are settled here.
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
	 * Class initializer
	 *
	 * @since   0.1
	 * @return  void
	 */
	private function init() {
		$this->landing_post_type();
		$this->general_hooks();

		new API\Actions();
	}

	/**
	 * Misc. hooks to be executed across the whole WordPress
	 *
	 * @since   0.3
	 * @return  void
	 */
	private function general_hooks() {
		add_action(
			'login_enqueue_scripts', function() {
				Utils::load_public_assets( 'login.min.css' );
			}
		);

		add_filter( 'manage_landing_posts_columns', [ $this, 'landing_post_columns' ] );
		add_action( 'manage_landing_posts_custom_column', [ $this, 'landing_post_columns_data' ], 10, 2 );
	}

	/**
	 * Landing's custom post type registration
	 *
	 * @since   0.3
	 * @return  void
	 */
	private function landing_post_type() {
		$name = 'landing';
		$labels = [
			'name'               => __( 'Landings', 'landings-project' ),
			'singular_name'      => __( 'Landing', 'landings-project' ),
			'not_found'          => __( 'No landings found.', 'landings-project' ),
			'not_found_in_trash' => __( 'No landings found in trash.', 'landings-project' ),
		];
		$args = [
			'labels'               => $labels,
			'description'          => __( 'Multipurpose landing page.', 'landings-project' ),
			'public'               => true,
			'hierarchical'         => false,
			'menu_position'        => 20,
			'menu_icon'            => Utils::svg64( LANDINGS_PATH . 'assets/public/symbol.svg' ),
			'supports'             => [ 'title', 'author', 'revisions' ],
			'register_meta_box_cb' => [ new Admin\Metaboxes(), 'init' ],
		];
		register_post_type( $name, $args );
	}

	/**
	 * Landing's custom post type listing columns
	 *
	 * @param   array $columns   Columns key collection.
	 * @return  array
	 */
	public function landing_post_columns( $columns ) {
		$date   = $columns['date'];
		unset( $columns['date'] );
		unset( $columns['author'] );

		$columns['landing_views']  = __( 'Views', 'landings-project' );
		$columns['landing_layout'] = __( 'Current Layout', 'landings-project' );

		$columns['date'] = $date;

		return $columns;
	}

	/**
	 * Landing's custom post type listing columns data
	 *
	 * @param   array $column    Column key.
	 * @param   int   $post_id   Custom post ID.
	 * @return  void
	 */
	public function landing_post_columns_data( $column, $post_id ) {
		switch ( $column ) {
			case 'landing_layout':
				$layout = $this->get_landing_layout( $post_id );
				if ( ! $layout ) {
					echo '<i>No data</i>';
				}
			break;
			case 'landing_views':
				$views = $this->get_landing_views( $post_id );
				if ( ! $views ) {
					echo '<i>No data</i>';
				}
				break;
		}
	}

	/**
	 * Get specified landing current layout
	 *
	 * @param   int $landing_id   Custom post ID.
	 * @return  string|array|bool
	 */
	private function get_landing_layout( $landing_id ) {
		return false;
	}

	/**
	 * Get specified landing views
	 *
	 * @param   int $landing_id   Custom post ID.
	 * @return  string|array|bool
	 */
	private function get_landing_views( $landing_id ) {
		return false;
	}
}
