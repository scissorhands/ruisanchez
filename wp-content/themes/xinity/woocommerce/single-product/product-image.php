<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $ioa_helper, $ioa_super_options , $ioa_meta_data ,$post,$ioa_layout,$woo_commerce; 

$post_ID = get_the_ID();

$ioa_meta_data['width'] = 510;

if($ioa_meta_data['layout']!="full") $ioa_meta_data['width'] = 350;

?>
<div class="featured-media-wrap">

	<?php  $ioa_meta_data['full_media'] = false;
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
			 		case 'image' :
			 		case 'zoomable' :  get_template_part('templates/content-featured-media'); break;
			 		case 'product_gallery' :  get_template_part('woocommerce/product-gallery'); break;
			 	}
	?>

	

</div>
