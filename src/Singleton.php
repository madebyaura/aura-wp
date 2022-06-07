<?php
/**
 * Singleton.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * Singleton.
 */
trait Singleton {
	/**
	 * Instance.
	 *
	 * @var object
	 */
	protected static $instance;

	/**
	 * Constructor.
	 *
	 * Needs to be private to avoid creation of parent instance from child class.
	 */
	final private function __construct() {}

	/**
	 * Restrict clone.
	 */
	final private function __clone() {}

	/**
	 * Restrict wakeup.
	 */
	final private function __wakeup() {}

	/**
	 * Get instance.
	 *
	 * Use static::$instance instead of self::$instance.
	 * self::$instance will always be parents class's static property
	 *
	 * @return self
	 */
	final public static function init() {
		if ( ! static::$instance instanceof static ) {
			static::$instance = new static();
		}

		return static::$instance;
	}
}
