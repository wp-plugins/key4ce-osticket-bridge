<?php 
/**
 * This is the header template that displays in all pages.
 * 
 * Please note: this is the WordPress constructed page layout for theme 
 * (Twenty_Fourteen) and you maybe using a different theme.
 * 
 * You can look in your theme's main folder for the (page.php) file 
 * and copy over the following below with it's header's div's
 *
 * key4ce-osticket-bridge uses (Twenty_Fourteen) theme for all testing..
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<!-- ** You can edit below this line - Edit the (footer.php) also! ** -->


<!--Setting for Twenty Fourteen Theme - Edit/Replace/Delete -->
<div id="main-content" class="main-content">
<?php if ( is_front_page() && twentyfourteen_has_featured_posts() ) { get_template_part( 'featured-content' ); } ?>
<div id="primary" class="content-area">
<div id="content" class="site-content" role="main">
<!--End of Twenty Fourteen setting-->


<!-- ** You can edit above this line ** -->