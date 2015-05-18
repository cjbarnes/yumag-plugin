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

}
