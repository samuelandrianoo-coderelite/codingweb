<?php //phpcs:ignore
/**
 * Theme functions and definitions.
 *
 * @package Blogvi
 * @author  Peregrine Themes
 * @since   1.0.0
 */

/**
 * Main Blogvi class.
 *
 * @since 1.0.0
 */
final class Blogvi {

	/**
	 * Singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogvi ) ) {
			self::$instance = new Blogvi();
			self::$instance->includes();
			// Hook now that all of the Blogvi stuff is loaded.
			do_action( 'blogvi_loaded' );
		}
		return self::$instance;
	}

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'blogvi_styles' ) );
	}

	/**
	 * Include files.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function includes() {
		require get_stylesheet_directory() . '/inc/customizer/default.php';
		require get_stylesheet_directory() . '/inc/customizer/customizer.php';
	}

	/**
	 * Recommended way to include parent theme styles.
	 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
	 */
	function blogvi_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
	}
}

/**
 * The function which returns the one Blogvi instance.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $blogvi = blogvi(); ?>
 *
 * @since 1.0.0
 * @return object
 */
function blogvi() {
	return Blogvi::instance();
}

blogvi();
