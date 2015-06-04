<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines two example hooks for how to enqueue the admin-specific stylesheet
 * and JavaScript.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Admin extends YuMag_Plugin_Singleton {

	/**
	 * Load sub-classes.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function load_dependencies() {

		$path = $this->plugin->get_plugin_path();

		// Include all other admin-functionality classes.
		//require_once $path . 'admin/class-yumag-plugin-user-fields.php';

		// Instantiate classes.
		//YuMag_Plugin_User_Fields::get_instance( $this->plugin );

	}

	/**
	 * Register all hooks for actions and filters in this class.
	 *
	 * Called on this class's construction by the parent class method
	 * `YuMag_Plugin_Singleton::__construct()`.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function define_hooks() {

		// Filter the hidden metaboxes on the Edit Post page.
		add_filter( 'default_hidden_meta_boxes', array( $this, 'show_excerpt_by_default' ), 10, 2 );

		// Alter query arguments for the Link dialog in the editor.
		add_filter( 'wp_link_query_args', array( $this, 'show_drafts_in_link_list' ) );

	}

	/**
	 * Filter which metaboxes should be hidden on the Edit Post page.
	 *
	 * @since 1.0.0
	 *
	 * @param array     $hidden List of metaboxes to hide by default.
	 * @param WP_Screen $screen The current screen object.
	 * @return array Revised list of hidden metaboxes.
	 */
	public function show_excerpt_by_default( $hidden, $screen ) {

		// Only on Post pages.
		if ( ! empty( $screen ) && ( 'post' === $screen->post_type ) ) {
			$hidden = array_diff( $hidden, array( 'postexcerpt' ) );
		}

		return $hidden;
	}

	/**
	 * Filter to allow easy linking to Draft or Pending posts, and to exclude
	 * things we shouldn't be linking to (e.g. Notices).
	 *
	 * @since 1.1.0
	 *
	 * @param array $query Arguments for the links-list WP_Query.
	 * @return array The modified query arguments.
	 */
	public function show_drafts_in_link_list( $query ) {

		// Exclude Notices from the link options.
		$key = array_search( 'yumag_notice', $query['post_type'] );
		if ( $key ) {
			unset( $query['post_type'][ $key ] );
		}

		// Include not-yet-published posts.
		$statuses = $query['post_status'];
		if ( ! is_array( $statuses ) ) {
			$statuses = array( $statuses );
		}
		$query['post_status'] = $statuses + array( 'draft', 'pending', 'future' );

		return $query;
	}

}
