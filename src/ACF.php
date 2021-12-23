<?php
/**
 * ACF.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * ACF.
 */
class ACF {
	/**
	 * Get ACF field value.
	 * Return default value, if ACF is not activated.
	 * Prevent fatal errors, if ACF is not activated.
	 *
	 * To get theme option value, pass 'option' as a parameter for $group.
	 *
	 * @param  string $prefix  Prefix.
	 * @param  string $group    Group.
	 * @param  string $key      Key.
	 * @param  int    $post_id  Post ID.
	 * @param  mixed  $default  Fallback value.
	 * @return mixed  $value
	 */
	public static function get_field( $prefix, $group, $key, $post_id = null, $default = null ) {
		$value = null;
		$key   = sanitize_key( $key );
		$id    = sanitize_key( "{$prefix}_{$group}_{$key}" );

		if ( function_exists( 'get_field' ) ) {
			if ( 'option' === $group ) {
				$value = get_field( $id, 'option' );
			} else {
				$value = get_field( $id, $post_id );
			}
		}

		if ( null === $value ) {
			$value = $default;
		}

		return $value;
	}

	/**
	 * Get ACF repeater item by id.
	 *
	 * @param  string $group    group.
	 * @param  string $key      Key.
	 * @param  string $item_id  Repeater item ID.
	 * @param  string $post_id  Post ID.
	 * @return mixed
	 */
	public static function get_repeater_item_by_id( $group, $key, $item_id, $post_id = null ) {
		$value = null;
		$items = self::get_field( $group, $key, $post_id );

		foreach ( $items as $item ) {
			if ( $item_id === $item['id'] ) {
				$value = $item;

				break;
			}
		}

		return $value;
	}

	/**
	 * Echo ACF admin css.
	 */
	public static function echo_admin_css() {
		?>
		<style type="text/css">
			/* -----------------------------------------------------------------------
			 * Group.
			 * -------------------------------------------------------------------- */
			.acf-field-group:not(.aura-no-styles) > .acf-label {
				background-color: #333;
				color: #fff;
				margin-bottom: 0;
				padding: 10px 12px;
			}

			.acf-field-group:not(.aura-no-styles) > .acf-label > label {
				margin-bottom: 0;
			}

			.acf-field-group:not(.aura-no-styles) > .acf-input > .acf-fields {
				border-color: #333;
			}

			/* -----------------------------------------------------------------------
			 * Repeater.
			 * -------------------------------------------------------------------- */
			.aura-acf-repeater .acf-repeater .acf-row-handle {
				position: relative;
			}

			.aura-acf-repeater .acf-repeater .acf-row-handle span {
				background-color: #333;
				color: #fff;
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				padding-block: 10px 12px;
			}

			.aura-acf-repeater .acf-repeater > .acf-table > tbody > tr > .acf-fields > .acf-field:first-of-type > .acf-label {
				background-color: #333;
				color: #fff;
				padding: 10px 15px;
				margin-top: -15px;
				margin-inline: -12px;
			}

			.aura-acf-repeater .acf-repeater > .acf-table > tbody > tr > .acf-fields > .acf-field:first-of-type > .acf-label > label {
				margin-bottom: 0;
			}
		</style>
		<?php
	}
}
