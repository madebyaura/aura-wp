<?php
/**
 * Utilities.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * Utilities.
 */
class Utils {
	/**
	 * Remove invalid characters from a string, and replace underscores,
	 * whitespace, forward slash, and back slash characters with dashes.
	 *
	 * @param  string $string  String that needs to dashified.
	 * @return string $string
	 */
	public static function dashify( $string ) {
		// Remove whitespace from the front and end, and lowercase all characters.
		$string = strtolower( trim( $string ) );

		// Remove all characters other than alphabets, numbers, dash, underscore,
		// whitespace, forward slash, and back slash.
		$string = preg_replace( '/[^a-z0-9-_\s\/\\\]/', '', $string );

		// Replace dash, underscore, whitespace, forward slash, and back slash
		// characters with dashes.
		$string = preg_replace( '/[-_\s\/\\\]+/', '-', $string );

		return $string;
	}

	/**
	 * Run all elements of an array through dashify().
	 *
	 * @param  array $array  Array to be dashified.
	 * @return array
	 */
	public static function dashify_array( $array ) {
		return array_map( __CLASS__ . '::dashify', $array );
	}

	/**
	 * Remove invalid characters from a string, and replace dash, whitespace,
	 * forward slash, and back slash characters with underscores.
	 *
	 * @param  string $string  String that needs to be underscorified.
	 * @return string $string
	 */
	public static function underscorify( $string ) {
		// Remove whitespace from the front and end, and lowercase all characters.
		$string = strtolower( trim( $string ) );

		// Remove all characters other than alphabets, numbers, dash, underscore,
		// whitespace, forward slash, and back slash.
		$string = preg_replace( '/[^a-z0-9-_\s\/\\\]/', '', $string );

		// Replace dash, underscore, whitespace, forward slash, and back slash
		// characters with underscores.
		$string = preg_replace( '/[-_\s\/\\\]+/', '_', $string );

		return $string;
	}

	/**
	 * Run all elements of an array through underscorify().
	 *
	 * @param  array $array  Array to be underscorify.
	 * @return array
	 */
	public static function underscorify_array( $array ) {
		return array_map( __CLASS__ . '::underscorify', $array );
	}

	/**
	 * Get file content.
	 *
	 * @param  string $file_path  File path.
	 * @return string
	 */
	public static function get_file_content( $file_path ) {
		// Early exit if file doesn't exist.
		if ( ! file_exists( $file_path ) ) {
			return '';
		}

		// Return file contents using output butter.
		ob_start();
			include_once $file_path;
		return ob_get_clean();
	}

	/**
	 * Check if a plugin is active.
	 *
	 * @param  string $plugin_base_file  Base plugin path.
	 * @return bool
	 */
	public static function is_plugin_active( $plugin_base_file ) {
		// Do not proceed if the base file of the plugin does not exist.
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_base_file ) ) {
			return false;
		}

		// This filed is required in order to make is_plugin_active in front end.
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		// Check if the plugin is active.
		return is_plugin_active( $plugin_base_file );
	}

	/**
	 * Get widget's css class name using it PHP class name.
	 *
	 * @param  string $class_name  Widget class name.
	 * @return string $class_name  CSS class name.
	 */
	public static function get_widget_css_class( $class_name ) {
		// Early exit if class name is empty.
		if ( ! $class_name ) {
			return;
		}

		// Change string to lower case.
		$class_name = strtolower( $class_name );

		// Replace backslashes with dashes.
		$class_name = str_replace( '\\', '-', $class_name );

		// Dashify class name.
		$class_name = self::dashify( $class_name );

		return $class_name;
	}
}
