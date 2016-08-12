<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */


global $ioa_meta_data,$ioa_helper,$woocommerce;

$ioa_helper->getProductParameters();

$product_props = $ioa_meta_data['product_props'];
$ioa_meta_data['height'] = $product_props['_pr_height'];

$ioa_meta_data['height'] =  $product_props['_pr_height'];
$ioa_meta_data['width'] = 235;

get_header(); 

if(!isset($ioa_meta_data['featured_media_type'])) $ioa_meta_data['featured_media_type'] = 'none';

/**
 * Full Width Featured Media Items will appear here. 
 * Note the switches are for condition checking on featured media Full or Contained. 
 */
if(! post_password_required())  // Check if Page is password protected

	switch($ioa_meta_data['featured_media_type'])
	{
		case "slider-full" :
		case "slider-contained" :
		case "slideshow-contained" :
		case "none-full" :
		case 'image-parallex' : 
		case 'slider-manager' :
		case 'rev_slider' :
		case 'image-full' : $ioa_meta_data['gr'] = true; get_template_part('templates/content-featured-media'); break;
	}



	?>

		
		<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap woo-shop <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
			<?php  
				/**
				 * Featured Media Items contained by parent width will appear here. 
				 */
				if(! post_password_required()) // Check if Page is password protected
			 	switch($ioa_meta_data['featured_media_type'])
			 	{
			 		case 'slider' :
			 		case 'slideshow' :
			 		case 'video' :
			 		case 'proportional' :
			 		case 'none-contained' :
			 		case 'image' : get_template_part('templates/content-featured-media'); break;
			 	}
			?>
		
		<?php if(IOA_WOO_EXISTS) : ?>

		<?php  
			if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

			$args = array();
			if(isset($_GET['orderby']))
			{
 	 			$args = $woocommerce->query->get_catalog_ordering_args();
		 	}

		 	$opts = array_merge(array( 'post_type' => 'product','suppress_filters' => 0,  'posts_per_page' => $product_props['_product_item_limit'] , 'paged' => $paged) , $product_props['query_filter']);
		 	$opts = array_merge($opts,$args);
			query_posts($opts); 
		?>

		<?php if ( have_posts() ) : ?>

			<div class="shop-controls clearfix">
				<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			</div>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php woocommerce_get_template_part( 'templates/content-default-shop' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action('woocommerce_after_shop_loop');
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php else: ?>
			<h2><?php _e('Woo Commerce Plugin not activated','ioa'); ?></h2>
	<?php endif; ?>	
	
	</div>

		<?php  get_sidebar(); ?>
	</div>
	
