<?php
/**
 * PageTitle.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * PageTitle.
 */
class PageTitle {
	/**
	 * Get title.
	 *
	 * @return string $title
	 */
	public static function get_title() {
		$title = '';

		if (
			is_home() ||
			is_singular( 'post' ) ||
			is_category() ||
			is_tag()
		) {
			$title = self::get_blog_title();

		} elseif (
			is_post_type_archive( 'product' ) ||
			is_singular( 'product' ) ||
			is_tax( [ 'product_cat', 'product_tag' ] )
		) {
			$title = self::get_shop_title();

		} elseif ( is_singular( 'page' ) ) {
			$title = get_the_title();

		} elseif ( is_singular() ) {
			$post_type = get_queried_object()->post_type;
			$title     = get_post_type_object( $post_type )->label;

		} elseif ( is_post_type_archive() ) {
			$title = get_queried_object()->labels->name;

		} else {
			$title = get_the_title();
		}

		$title = $title ?: get_the_title();

		return apply_filters( 'aura_wp_page_title', $title );
	}

	/**
	 * Get blog title.
	 *
	 * @return string $title
	 */
	public static function get_blog_title() {
		$title   = __( 'Blog', 'aura-wp' );
		$page_id = get_option( 'page_for_posts' );

		if ( 'page' === get_option( 'show_on_front' ) && $page_id ) {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		}

		return apply_filters( 'aura_wp_page_title_blog', $title );
	}

	/**
	 * Get shop title.
	 *
	 * @return string $title
	 */
	public static function get_shop_title() {
		$title   = __( 'Shop', 'aura-wp' );
		$page_id = get_option( 'woocommerce_shop_page_id' );

		if ( $page_id ) {
			$title = get_the_title( $page_id );
		}

		return apply_filters( 'aura_wp_page_title_shop', $title );
	}
}
