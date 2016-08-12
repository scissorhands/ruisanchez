<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop,$ioa_helper,$ioa_meta_data;

$product_props = $ioa_meta_data['product_props'];

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );


// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

$second_thumb = get_post_meta(get_the_ID(),'sec_thumb',true);
// Extra post classes
$classes = array();
// Increase loop count
$woocommerce_loop['loop']++;
$second_thumb = get_post_meta(get_the_ID(),'sec_thumb',true);
// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

?>
<li <?php post_class( $classes ); ?>>
	<i class="ioa-front-icon ok-2icon- icon-cart-added"></i>
	<span class="cart-loader"></span>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	<div class="image">
		<?php woocommerce_template_loop_add_to_cart(); ?>
		<a class='product-data' href="<?php the_permalink(); ?>">

				<div class="main-thumb">
          <?php 

          $id = get_post_thumbnail_id(get_the_ID());
            $ar = wp_get_attachment_image_src( $id, array(9999,9999) );


          switch($product_props['product_image_resize'])
                  {
                    case "none" : echo "<img src='".$ar[0]."' alt='".get_the_title()."' />";  break;
                    case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case "default" :
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  }   

         ?>
        </div>
        <?php if($second_thumb!="") : ?>
        <div class="sec-thumb">
          <?php 
            
             switch($product_props['product_image_resize'])
                  {
                    case "none" : echo "<img src='".$second_thumb."' alt='".get_the_title()."' />";  break;
                    case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $second_thumb , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case "default" :
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $second_thumb , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  }

             ?>
        </div>
        <?php endif; ?>
		</a>
	</div>

		<p class="product-cats">
		<?php 
			$taxonomy = 'product_cat';
			$terms = get_the_terms( get_the_ID(), $taxonomy ); 
			$t = array();

			if($terms)
			foreach ($terms as $key => $obj) {
				$t[] = '<a href="'.get_term_link($obj->term_id,$taxonomy).'">'.$obj->name.'</a>';
			}


			echo join(" / ",$t);
		?></p>	
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>