<?php
/**
 * ShareLinks.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * ShareLinks.
 */
class ShareLinks {
	/**
	 * Get sites.
	 */
	public static function get_sites() {
		static $sites;

		if ( ! $sites ) {
			$sites = [
				'facebook'  => __( 'Facebook', 'aura-wp' ),
				'twitter'   => __( 'Twitter', 'aura-wp' ),
				'pinterest' => __( 'Pinterest', 'aura-wp' ),
				'linkedin'  => __( 'LinkedIn', 'aura-wp' ),
				'email'     => __( 'Email', 'aura-wp' ),
			];
		}

		return $sites;
	}

	/**
	 * Get share links.
	 *
	 * @param int $post_id  Post ID.
	 * @return array
	 */
	public static function get_links( $post_id = null ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		$url   = get_permalink( $post_id );
		$sites = array_keys( self::get_sites() );

		foreach ( $sites as $site ) {
			$links[ $site ] = call_user_func( [ __CLASS__, "get_{$site}_link" ], $url, $post_id );
		}

		return $links;
	}

	/**
	 * Get Facebook share link.
	 *
	 * @param  string $url  URL to be shared.
	 * @return string
	 */
	public static function get_facebook_link( $url ) {
		return "https://www.facebook.com/sharer.php?u={$url}";
	}

	/**
	 * Get Twitter share link.
	 *
	 * @param  string $url      URL to be shared.
	 * @param  int    $post_id  Post ID.
	 * @return string
	 */
	public static function get_twitter_link( $url, $post_id ) {
		$tweet = null;

		// Twitter Text.
		if ( intval( $post_id ) > 0 ) {
			$title = html_entity_decode( get_the_title( $post_id ) );

			$tweet = '&text=' . rawurlencode( $title );
		}

		return "https://twitter.com/share?{$tweet}&url={$url}";
	}

	/**
	 * Get Pinterest share link.
	 *
	 * @param  string $url      URL to be shared.
	 * @param  int    $post_id  Post ID.
	 * @return string
	 */
	public static function get_pinterest_link( $url, $post_id ) {
		$media = null;

		// Media.
		$thumb_url = get_the_post_thumbnail_url( $post_id, 'large' );

		if ( $thumb_url ) {
			$media = '&media=' . $thumb_url;
		}

		return "https://pinterest.com/pin/create/bookmarklet/?url={$url}{$media}";
	}

	/**
	 * Get LinkedIn share link.
	 *
	 * @param  string $url  URL to be shared.
	 * @return string
	 */
	public static function get_linkedin_link( $url ) {
		return "https://www.linkedin.com/shareArticle?mini=true&url={$url}";
	}

	/**
	 * Get Email share link.
	 *
	 * @param  string $url      URL to be shared.
	 * @param  int    $post_id  Post ID.
	 * @return string
	 */
	public static function get_email_link( $url, $post_id ) {
		$title = esc_html__( 'Share Link', 'aura-wp' );

		// Title.
		if ( intval( $post_id ) > 0 ) {
			$title = html_entity_decode( get_the_title( $post_id ) );
		}

		$subject = rawurlencode( $title );
		$body    = rawurlencode( "{$title}: {$url}" );

		return "mailto:?subject={$subject}&body={$body}";
	}
}
