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
	 * @param string $key  Key.
	 * @return string
	 */
	public static function get_info( $key ) {
		static $info;

		if ( ! $info ) {
			$info['slug'] = get_template();
			$info['url']  = trailingslashit( get_template_directory_uri() );
			$info['path'] = trailingslashit( wp_normalize_path( get_template_directory() ) );

			if ( is_child_theme() ) {
				$info['version'] = wp_get_theme( wp_get_theme()->get( 'Template' ) )->get( 'Version' );
			} else {
				$info['version'] = wp_get_theme()->get( 'Version' );
			}

			// Child theme.
			$info['child_slug']    = get_stylesheet();
			$info['child_url']     = trailingslashit( get_stylesheet_directory_uri() );
			$info['child_path']    = trailingslashit( wp_normalize_path( get_stylesheet_directory() ) );
			$info['child_version'] = wp_get_theme()->get( 'Version' );
		}

		return $info[ $key ];
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
		 * Dynamically filters whether to short-circuit template part.
		 *
		 * @param bool   $disabled  Whether to short-circuit template part.
		 *                          Default false
		 * @param string $slug      Slug of template part.
		 * @param array  $args      Arguments passed to template part.
		 */
		$disabled = apply_filters( "aura_theme_template_part_disable_{$slug}", false, $slug, $args );

		/**
		 * Filters whether to short-circuit template part.
		 *
		 * @param bool   $disabled  Whether to short-circuit template part.
		 *                          Default false
		 * @param string $slug      Slug of template part.
		 * @param array  $args      Arguments passed to template part.
		 */
		$disabled = apply_filters( 'aura_theme_template_part_disable', $disabled, $slug, $args );

		// Do not proceed if template part is disabled.
		if ( true === $disabled ) {
			return;
		}

		/**
		 * Dynamically filters arguments passed to template part.
		 *
		 * @param array  $args  Arguments passed to template part.
		 * @param string $slug  Slug of template part.
		 */
		$args = apply_filters( "aura_theme_template_part_args_{$slug}", $args, $slug );

		/**
		 * Filters arguments passed to template part.
		 *
		 * @param array  $args  Arguments passed to template part.
		 * @param string $slug  Slug of template part.
		 */
		$args = apply_filters( 'aura_theme_template_part_args', $args, $slug );

		/**
		 * Dynamically fires before `get_template_part()` is called.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		do_action( "aura_theme_template_part_before_{$slug}", $slug, $args );

		/**
		 * Fires before `get_template_part()` is called.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		do_action( 'aura_theme_template_part_before', $slug, $args );

		get_template_part( "template-parts/{$slug}", null, $args );

		/**
		 * Dynamically fires after `get_template_part()` is called.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		do_action( "aura_theme_template_part_after_{$slug}", $slug, $args );

		/**
		 * Fires after `get_template_part()` is called.
		 *
		 * @param string $slug  Slug of template part.
		 * @param array  $args  Arguments passed to template part.
		 */
		do_action( 'aura_theme_template_part_after', $slug, $args );
	}
}
