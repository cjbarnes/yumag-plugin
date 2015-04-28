<?php

/**
 * The Image Credits functionality.
 *
 * @since 1.0.0
 *
 * @package YuMag_Plugin
 */

/**
 * The Image Credits functionality.
 *
 * Revised version of Adam Capriola's Image Credits plugin {@link http://adamcap.com/code/add-image-credit-fields-for-attachments-in-wordpress/}, which is
 * great but I couldn't get it to work so I've incorporated a tweaked version
 * here.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.0.0
 */
class YuMag_Plugin_Image_Credits extends YuMag_Plugin_Singleton {

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

		// Setup the admin fields for credits.
		add_filter( 'attachment_fields_to_edit', array( $this, 'add_fields' ), 10, 2 );
		add_filter( 'attachment_fields_to_save', array( $this, 'save_fields' ), 10 , 2 );

	}

	/**
	 * Add fields for image attribution to the media picker.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form_fields Array of form fields to display for images.
	 * @param WP_Post $post The current post object.
	 */
	public function add_fields( $form_fields, $post ) {

		$form_fields['yumag_credit_name'] = array(
			'label' => __( 'Credit Name', 'yumag_plugin' ),
			'input' => 'text',
			'value' => get_post_meta( $post->ID, '_wp_attachment_yumag_credit_name', true )
		);

		$form_fields['yumag_credit_url'] = array(
			'label' => __( 'Credit URL', 'yumag_plugin' ),
			'input' => 'text',
			'value' => get_post_meta( $post->ID, '_wp_attachment_yumag_credit_url', true )
		);

		return $form_fields;

	}

	/**
	 * Save fields for image attribution from the media picker.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Post $post The current post object.
	 * @param array $attachment Attachment fields.
	 */
	public function save_fields( $post, $attachment ) {

		if ( isset( $attachment['yumag_credit_name'] ) ) {
			$source_name = get_post_meta( $post['ID'], '_wp_attachment_yumag_credit_name', true );
			if ( $source_name != esc_attr( $attachment['yumag_credit_name'] ) ) {
				if ( empty( $attachment['yumag_credit_name'] ) )
					delete_post_meta( $post['ID'], '_wp_attachment_yumag_credit_name' );
				else
					update_post_meta( $post['ID'], '_wp_attachment_yumag_credit_name', esc_attr( $attachment['yumag_credit_name'] ) );
			}
		}

		if ( isset( $attachment['yumag_credit_url'] ) ) {
			$source_url = get_post_meta( $post['ID'], '_wp_attachment_yumag_credit_url', true );
			if ( $source_url != esc_url( $attachment['yumag_credit_url'] ) ) {
				if ( empty( $attachment['yumag_credit_url'] ) )
					delete_post_meta( $post['ID'], '_wp_attachment_yumag_credit_url' );
				else
					update_post_meta( $post['ID'], '_wp_attachment_yumag_credit_url', esc_url( $attachment['yumag_credit_url'] ) );
			}
		}

	}

	/**
	 * Get credits for all used images within an entry, including the featured
	 * image, and return as an associative array.
	 *
	 * @since 1.0.0
	 *
	 * @global WP_Post $post The current post object.
	 *
	 * @return array Array of image credits data.
	 */
	public function get_image_credits() {
		global $post;

		// Initialize variables.
		$results = array();
		$attachment_ids = array();
		$source_urls = array();

		// First find the featured image.
		if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $post->ID ) ) {
			$attachment_ids[] = get_post_thumbnail_id( $post->ID );
		}

		// Next find all instances of wp-image-[N] in the post content.
		if ( preg_match_all( '/(?:wp-image-)([0-9]+)/', $post->post_content, $matches ) ) {

			foreach ( $matches[1] as $id ) {

				// Prevent duplicates.
				if ( in_array( $id, $attachment_ids ) ) {
					continue;
				}

				$attachment_ids[] = $id;

			}

		}

		// Now go through all our attachments IDs and generate credits array.
		if ( ! empty( $attachment_ids ) ) {

			foreach ( $attachment_ids as $id ) {

				// Retrieve this image's data.
				$source_name = get_post_meta( $id, '_wp_attachment_yumag_credit_name', true );
				$source_url = get_post_meta( $id, '_wp_attachment_yumag_credit_url', true );

				// Check we aren't crediting the same source twice.
				if ( ! empty( $source_name ) && ! in_array( $source_url, $source_urls ) ) {

					$results[] = array(
						'name' => $source_name,
						'url' => $source_url
					);

					// This array is only used for checking for duplicates.
					$source_urls[] = $source_url;
				}

			}

		}

		return $results;
	}

	/**
	 * [the_image_credits description]
	 *
	 * @since 1.0.0
	 *
	 * @param string $before    HTML to go before the first item.
	 * @param string $separator HTML to go inbetween.
	 * @param string $after     HTML to go after the last item.
	 * @param bool   $echo      Whether to output the results. Default True.
	 * @return string|null The resulting HTML.
	 */
	public function the_image_credits( $before = '', $separator = ', ', $after = '', $echo = true ) {

		$links = array();
		$result = '';

		// Get the image credits data.
		$sources = $this->get_image_credits();
		if ( empty( $sources ) ) {
			return '';
		}

		// Assemble links for each credit.
		foreach ( $sources as $source ) {

			if ( ! empty( esc_url( $source['url'] ) ) ) {
				$links[] = sprintf( '<a class="yumag-image-credits-item" href="%1$s">%2$s</a>',
					esc_url( $source['url'] ),
					esc_html( $source['name'] )
				);
			} else {
				$links[] = sprintf( '<span class="yumag-image-credits-item">%s</span>',
					esc_html( $source['name'] )
				);
			}
		}

		// Convert array into string and add prefix/suffix.
		$result = implode( $separator, $links );
	    $result = $before . $result . $after;

	    // Output/return.
	    if ( $echo ) {
	        echo $result;
	        return null;
	    } else {
	        return $result;
	    }

	}

}
