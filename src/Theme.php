<?php
/**
 * Theme.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * Theme.
 */
class Theme {
	/**
	 * Get theme information.
	 *
	 * @param string $id    Option ID.
	 * @param string $type  Theme type.
	 * @return string
	 */
	public static function get_info( $id, $type = 'parent' ) {
		static $info;

		$type = 'child' === $type ?: 'parent';

		// Parent theme.
		if ( 'parent' === $type && isset( $info['parent'] ) ) {
			$info['parent']['slug']    = get_template();
			$info['parent']['url']     = trailingslashit( get_template_directory_uri() );
			$info['parent']['path']    = trailingslashit( wp_normalize_path( get_template_directory() ) );
			$info['parent']['version'] = is_child_theme() ? wp_get_theme( wp_get_theme()->get( 'Template' ) )->get( 'Version' ) : wp_get_theme()->get( 'Version' );
		}

		// Child theme.
		if ( 'child' === $type && isset( $info['child'] ) ) {
			$info['child']['slug']    = get_stylesheet();
			$info['child']['url']     = trailingslashit( get_stylesheet_directory_uri() );
			$info['child']['path']    = trailingslashit( wp_normalize_path( get_stylesheet_directory() ) );
			$info['child']['version'] = wp_get_theme()->get( 'Version' );
		}

		return $info[ $type ][ $id ];
	}

	/**
	 * Wrapper for `get_template_part()`.
	 *
	 * Adds hooks to
	 *
	 * @param string $slug  Slug of template part.
	 * @param array  $args  Optional. Arguments passed to template part.
	 */
	public static function get_template_part( $slug, $args = [] ) {
		/**
		 * Filter status of template part.
		 *
		 * @param bool   $status  Status of template part.
		 * @param string $slug    Slug of template part.
		 * @param array  $args    Arguments passed to template part.
		 */
		$status = apply_filters( 'aura_wp_template_part_status', true, $slug, $args );

		// Do not proceed if status of template part is not true.
		if ( true !== $status ) {
			return;
		}

		/**
		 * Filter slug of template part.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		$slug = apply_filters( 'aura_wp_template_part_slug', $slug, $args );

		/**
		 * Filter arguments passed to template part.
		 *
		 * @param array  $args  Arguments passed to template part.
		 * @param string $slug  Slug of template part.
		 */
		$args = apply_filters( 'aura_wp_template_part_args', $args, $slug );

		/**
		 * Fires before `get_template_part()` is called.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		do_action( 'aura_wp_template_part_before', $slug, $args );

		get_template_part( "template-parts/{$slug}", null, $args );

		/**
		 * Fires after `get_template_part()` is called.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		do_action( 'aura_wp_template_part_after', $slug, $args );
	}
}
