<?php
/**
 * Blogvi Admin class. Blogvi related pages in WP Dashboard.
 *
 * @package Blogvi
 * @author  Peregrine Themes <peregrinethemes@gmail.com>
 * @since   1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blogvi Admin Class.
 *
 * @since 1.0.0
 * @package Blogvi
 */
final class Blogvi_Customizer {

	/**
	 * Singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Main Blogvi Admin Instance.
	 *
	 * @since 1.0.0
	 * @return Blogvi_Customizer
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogvi_Customizer ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

		// Init Blogvi admin.
		add_action( 'init', array( $this, 'includes' ) );

		// Blogvi Admin loaded.
		do_action( 'Blogvi_Customizer_loaded' );
	}

	/**
	 * Include files.
	 *
	 * @since 1.0.0
	 */
	public function includes() {

		require_once get_stylesheet_directory() . '/inc/customizer/settings/index.php';
		require_once get_stylesheet_directory() . '/inc/customizer/default.php';
	}

}

/**
 * The function which returns the one Blogvi_Customizer instance.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $Blogvi_Customizer = Blogvi_Customizer(); ?>
 *
 * @since 1.0.0
 * @return object
 */
function Blogvi_Customizer() {
	return Blogvi_Customizer::instance();
}

Blogvi_Customizer();
