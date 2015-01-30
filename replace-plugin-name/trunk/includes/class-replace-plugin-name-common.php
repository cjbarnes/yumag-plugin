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
	 *
	 * Register the JavaScript shared between the dashboard and the public side
	 * of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Replace_Plugin_Name_Common_Loader as all of the hooks are
		 * defined in that particular class.
		 *
		 * The Replace_Plugin_Name_Common_Loader will then create the
		 * relationship between the defined hooks and the functions defined in
		 * this class.
		 */

		$plugin = Replace_Plugin_Name::get_instance();

		wp_enqueue_script(
			$plugin->get_plugin_name(),
			plugin_dir_url( __FILE__ ) . 'js/replace-plugin-name-common.js',
			array( 'jquery' ),
			$plugin->get_version(),
			false
		);

	}

}
