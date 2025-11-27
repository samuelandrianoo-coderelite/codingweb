<?php
/**
 * The template for displaying header layout 5.
 *
 * @package     Blogvi
 * @author      Peregrine Themes
 * @since       1.0.0
 */

?>

<div class="bloglo-container bloglo-header-container">

	<?php
	bloglo_header_logo_template();
	?>

	<span class="bloglo-header-element bloglo-mobile-nav">
		<?php bloglo_hamburger( bloglo_option( 'main_nav_mobile_label' ), 'bloglo-primary-nav' ); ?>
		<?php bloglo_main_navigation_template(); ?>
	</span>

	<?php
	bloglo_main_navigation_template();
	do_action( 'bloglo_header_widget_location', array( 'left', 'right' ) );
	?>

</div><!-- END .bloglo-container -->
