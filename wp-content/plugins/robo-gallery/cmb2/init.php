<?php
/**
 * Bootstraps the CMB2 process
 *
 * @category  WordPress_Plugin
 * @package   CMB2
 * @author    WebDevStudios
 * @license   GPL-2.0+
 * @link      http://webdevstudios.com
 */
 if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'CMB2_Bootstrap_206', false ) ) {

	/**
	 * Handles checking for and loading the newest version of CMB2
	 *
	 * @since  2.0.0
	 *
	 * @category  WordPress_Plugin
	 * @package   CMB2
	 * @author    WebDevStudios
	 * @license   GPL-2.0+
	 * @link      http://webdevstudios.com
	 */
	class CMB2_Bootstrap_206 {

		/**
		 * Current version number
		 * @var   string
		 * @since 1.0.0
		 */
		const VERSION = '2.0.6';

		/**
		 * Current version hook priority.
		 * Will decrement with each release
		 *
		 * @var   int
		 * @since 2.0.0
		 */
		const PRIORITY = 9993;

		/**
		 * Single instance of the CMB2_Bootstrap_206 object
		 *
		 * @var CMB2_Bootstrap_206
		 */
		public static $single_instance = null;

		/**
		 * Creates/returns the single instance CMB2_Bootstrap_206 object
		 *
		 * @since  2.0.0
		 * @return CMB2_Bootstrap_206 Single instance object
		 */
		public static function initiate() {
			if ( null === self::$single_instance ) {
				self::$single_instance = new self();
			}
			return self::$single_instance;
		}

		/**
		 * Starts the version checking process.
		 * Creates CMB2_LOADED definition for early detection by other scripts
		 *
		 * Hooks CMB2 inclusion to the init hook on a high priority which decrements
		 * (increasing the priority) with each version release.
		 *
		 * @since 2.0.0
		 */
		private function __construct() {
			/**
			 * A constant you can use to check if CMB2 is loaded
			 * for your plugins/themes with CMB2 dependency
			 */
			if ( ! defined( 'CMB2_LOADED' ) ) {
				define( 'CMB2_LOADED', true );
			}
			add_action( 'init', array( $this, 'include_cmb' ), self::PRIORITY );
		}

		/**
		 * A final check if CMB2 exists before kicking off our CMB2 loading.
		 * CMB2_VERSION and CMB2_DIR constants are set at this point.
		 *
		 * @since  2.0.0
		 */
		public function include_cmb() {
			if ( class_exists( 'CMB2', false ) ) {
				return;
			}

			if ( ! defined( 'CMB2_VERSION' ) ) {
				define( 'CMB2_VERSION', self::VERSION );
			}

			if ( ! defined( 'CMB2_DIR' ) ) {
				define( 'CMB2_DIR', trailingslashit( dirname( __FILE__ ) ) );
			}

			$this->l10ni18n();

			// Include helper functions
			require_once 'includes/helper-functions.php';

			// Now kick off the class autoloader
			spl_autoload_register( 'cmb2_autoload_classes' );

			// Kick the whole thing off
			require_once 'bootstrap.php';
		}

		/**
		 * Registers CMB2 text domain path
		 * @since  2.0.0
		 */
		public function l10ni18n() {
			$loaded = load_plugin_textdomain( 'cmb2', false, '/languages/' );
			if ( ! $loaded ) {
				$loaded = load_muplugin_textdomain( 'cmb2', '/languages/' );
			}
			if ( ! $loaded ) {
				$loaded = load_theme_textdomain( 'cmb2', '/languages/' );
			}

			if ( ! $loaded ) {
				$locale = apply_filters( 'plugin_locale', get_locale(), 'cmb2' );
				$mofile = dirname( __FILE__ ) . '/languages/cmb2-' . $locale . '.mo';
				load_textdomain( 'cmb2', $mofile );
			}
		}

	}

	// Make it so...
	CMB2_Bootstrap_206::initiate();

}
