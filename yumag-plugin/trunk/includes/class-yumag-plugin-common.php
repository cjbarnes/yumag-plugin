<?php

/**
 * The functionality of the plugin that's shared between dashboard and public
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin
 */

/**
 * The functionality of the plugin that's shared between dashboard and public.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Common extends YuMag_Plugin_Singleton {

	/**
	 * Load the required dependencies for the admin area.
	 *
	 * Called on this class's construction by the parent class method
	 * `YuMag_Plugin_Singleton::__construct()`.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function load_dependencies() {

		$path = $this->plugin->get_plugin_path();

		// Include all other common-functionality classes.
		require_once $path . 'includes/class-yumag-plugin-notices.php';
		require_once $path . 'includes/class-yumag-plugin-image-credits.php';

		/*
		 * Instantiate classes. The Singleton classes’ constructors expect the
		 * YuMag_Plugin class to be passed in as an argument.
		 */
		YuMag_Plugin_Notices::get_instance( $this->plugin );
		YuMag_Plugin_Image_Credits::get_instance( $this->plugin );

	}

}
