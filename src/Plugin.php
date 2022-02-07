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

		if ( ! $info ) {
			$info['slug'] = plugin_basename( dirname( $file ) );
			$info['url']  = plugin_dir_url( $file );
			$info['path'] = wp_normalize_path( plugin_dir_path( $file ) );

			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$info['version'] = get_plugin_data( $info['path'] . 'init.php' )['Version'];
		}

		return $info[ $id ];
	}
}
