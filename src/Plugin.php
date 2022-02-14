<?php
/**
 * Plugin.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * Plugin.
 */
class Plugin {
	/**
	 * Get plugin information.
	 *
	 * @param string $file  File path.
	 * @param string $id    ID.
	 * @return string
	 */
	public static function get_info( $file, $id ) {
		static $info;

		$slug = plugin_basename( dirname( $file ) );

		if ( ! isset( $info[ $slug ] ) ) {
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$info[ $slug ]['slug']    = $slug;
			$info[ $slug ]['url']     = plugin_dir_url( $file );
			$info[ $slug ]['path']    = wp_normalize_path( plugin_dir_path( $file ) );
			$info[ $slug ]['version'] = get_plugin_data( $info[ $slug ]['path'] . 'init.php' )['Version'];
		}

		return $info[ $slug ][ $id ];
	}
}
