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

get_header(); 

?>
<!-- ** You can edit below this line - Edit the (footer.php) also! ** -->

<style>
section.page-top h2{
    border-bottom: 5px solid #CCCCCC;
    color: #FFFFFF;
    display: inline-block;
    font-weight: 200;
    line-height: 46px;
    margin: 0 0 -25px;
    min-height: 37px;
    padding: 0 0 17px;
    position: relative;
    font-size: 2.6em;
    border-bottom-color: #0088CC;

}
</style>
<!--Setting for Twenty Fourteen Theme - Edit/Replace/Delete -->
<div id="main-content" class="main-content">
<?php if ( is_front_page() && twentyfourteen_has_featured_posts() ) { get_template_part( 'featured-content' ); } ?>
<div id="primary" class="content-area">
<div id="content" class="site-content" role="main">
<section class="page-top">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
                <?php                    
                    if(function_exists('bcn_display')) {
                        bcn_display_list();
                    }  
                ?>
                </ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h2><?php the_title(); ?></h2>
			</div>
		</div>
	</div>
</section>
<!--End of Twenty Fourteen setting-->


<!-- ** You can edit above this line ** -->
