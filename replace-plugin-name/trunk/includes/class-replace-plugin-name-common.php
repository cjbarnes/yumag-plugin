<?php

/**
 * The functionality of the plugin that's shared between dashboard and public
 *
 * @since 1.0.0
 *
 * @package Replace_Plugin_Name
 */

/**
 * The functionality of the plugin that's shared between dashboard and public.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class Replace_Plugin_Name_Common extends Replace_Plugin_Name_Singleton {

	/**
	 * Load the required dependencies for the admin area.
	 *
	 * This is an example of how to load additional classes beyond the basic
	 * Admin, Public, and Common classes. Each class that extends
	 * `Replace_Plugin_Name_Singleton` calls this method when it is first
	 * constructed.
	 *
	 * Called on this class's construction by the parent class method
	 * `Replace_Plugin_Name_Singleton::__construct()`.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function load_dependencies() {

		$path = $this->plugin->get_plugin_path();

		// Include all other common-functionality classes.
		require_once $path . 'includes/class-replace-plugin-name-example.php';

		/*
		 * Instantiate classes. The Singleton classes’ constructors expect the
		 * Replace_Plugin_Name class to be passed in as an argument.
		 */
		Replace_Plugin_Name_Example::get_instance( $this->plugin );

	}

}
