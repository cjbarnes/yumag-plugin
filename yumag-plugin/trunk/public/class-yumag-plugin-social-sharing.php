<?php

/**
 * Adds social media sharing links to posts.
 *
 * @since 1.2.0
 *
 * @package YuMag_Plugin/public
 */

/**
 * Adds social media sharing links to posts.
 *
 * Uses the Singleton pattern.
 *
 * @since 1.2.0
 */
class YuMag_Plugin_Social_Sharing extends YuMag_Plugin_Singleton {

	/**
	 * Register all hooks for actions and filters in this class.
	 *
	 * Called on this class's construction by the parent class method
	 * `YuMag_Plugin_Singleton::__construct()`.
	 *
	 * @since 1.2.0
	 * @access protected
	 */
	protected function define_hooks() {

		add_filter( 'the_content', array( $this, 'output_social_sharing_links' ) );

	}

	/**
	 * Filter post content to append social media sharing links.
	 *
	 * @since 1.2.0
	 *
	 * @param string $content The post content.
	 * @return string Post content with links added.
	 */
	public function output_social_sharing_links( $content ) {

		if ( is_single() && is_main_query() ) {

			// Assemble the sharing URLs.
			$link = urlencode( get_permalink() );
			$facebook_app_id = '1656633561227375';
			$hashtags = 'yumag';
			$twitter_name = 'YorkAlumni';
			$title = get_the_title();
			$facebook_url = sprintf( 'https://www.facebook.com/dialog/share?app_id=%2$s&display=page&href=%1$s',
				$link,
				$facebook_app_id
			);
			$twitter_url = sprintf( 'https://twitter.com/share?url=%1$s&text=%2$s&via=%3$s&hashtags=%4$s',
				$link,
				$title,
				$twitter_name,
				$hashtags
			);
			$linkedin_url = sprintf( 'http://www.linkedin.com/shareArticle?url=%1$s&title=%2$s',
				$link,
				$title
			);

			// Output on the page.
			$link_template = '<li><a class="yumag-social-sharing-%4$s" href="%1$s" title="%3$s">%2$s</a></li>';
			$new_content = sprintf( '<h4>%s</h4><ul>',
				__( 'Share:', 'yumag' )
			);
			$new_content .= sprintf( $link_template,
				$facebook_url,
				__( 'Facebook', 'yumag-plugin' ),
				__( 'Share on Facebook', 'yumag-plugin' ),
				'facebook'
			);
			$new_content .= sprintf( $link_template,
				$twitter_url,
				__( 'Twitter', 'yumag-plugin' ),
				__( 'Share on Twitter', 'yumag-plugin' ),
				'twitter'
			);
			$new_content .= sprintf( $link_template,
				$linkedin_url,
				__( 'LinkedIn', 'yumag-plugin' ),
				__( 'Share on LinkedIn', 'yumag-plugin' ),
				'linkedin'
			);
			$new_content .= '</ul>';

			$content .= '<div class="yumag-social-sharing">' . $new_content . '</div>';
		}

		return $content;
	}

}
