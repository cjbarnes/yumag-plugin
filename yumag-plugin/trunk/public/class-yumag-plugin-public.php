<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines two examples hooks for how to enqueue the public-facing stylesheet
 * and JavaScript.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Public extends YuMag_Plugin_Singleton {

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

		/*
		 * Action to attach more actions/filters to other plugins' hooks.
		 * Called on plugins loaded so that I can get the instances of classy
		 * plugins, for assembly of the callbacks.
		 */
		add_action( 'plugins_loaded', array( $this, 'define_third_party_hooks' ) );

		// Hook in to each query before it is run.
		add_action( 'pre_get_posts', array( $this, 'setup_notice_query' ) );

	}

	/**
	 * Attach more actions/filters to other plugins' hooks.
	 *
	 * @since 1.0.0
	 *
	 * @global WidontPartDeux $widont The Widont plugin.
	 */
	public function define_third_party_hooks() {

		global $widont;

		// Add "Widon't" widows/orphans prevention filter to other fields.
		if ( class_exists( 'WidontPartDeux' ) && method_exists( 'WidontPartDeux', 'widont' ) && isset( $widont ) ) {

			// Subtitle field from WP Subtitle plugin.
			add_filter( 'wps_subtitle', array( $widont, 'widont' ), 100 );

		}

	}

	/**
	 * Gets notice-related query vars from URL and adds them to the main query.
	 *
	 * @since 1.1.0
	 *
	 * @param WP_Query $query The working query object.
	 */
	public function setup_notice_query( $query ) {

		if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'yumag_notice' ) ) {
			return;
		}

		// Get user filters.
		$type = ( isset( $_GET['type'] ) )
			? urldecode( $_GET['type'] )
			: '';
		$department = ( isset( $_GET['department'] ) )
			? urldecode( $_GET['department'] )
			: '';
		$college = ( isset( $_GET['college'] ) )
			? urldecode( $_GET['college'] )
			: '';
		$class_of = ( isset( $_GET['class-of'] ) )
			? intval( $_GET['class-of'], 10 )
			: 0;

		// Check for valid Class Of date entry.
		if ( ( intval( date( 'Y' ), 10 ) < $class_of ) || ( 1962 > $class_of ) ) {
			$class_of = 0;
		}

		// Assemble meta query.
		$meta_query = array( 'relation' => 'AND' );
		if ( $department ) {
			$meta_query[] = array(
				'key' => 'wpcf-submission_department',
				'value' => esc_sql( $department ),
				'compare' => '='
			);
		}
		if ( $college ) {
			$meta_query[] = array(
				'key' => 'wpcf-submission_college',
				'value' => esc_sql( $college ),
				'compare' => '='
			);
		}
		if ( 0 !== $class_of ) {
			$meta_query[] = array(
				'key' => 'wpcf-submission_class_of',
				'value' => $class_of,
				'compare' => '='
			);
		}

		// Assemble taxonomy query.
		$tax_query = array();
		if ( $type && term_exists( $type, 'yumag_notice_type' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'yumag_notice_type',
				'field'    => 'slug',
				'terms'    => esc_sql( $type )
			);
		}


		// Add meta and taxonomy queries to the query object.
		$query->set( 'meta_query', $meta_query );
		$query->set( 'tax_query', $tax_query );

	}

	/**
	 * Output a Notices search filters form.
	 *
	 * Called by the theme.
	 *
	 * @since 1.1.0
	 */
	public function display_filters() {
		$path = $this->plugin->get_partials_path( 'public' );
		require $path . 'yumag-plugin-notices-filters.php';
	}

}
