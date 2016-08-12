<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $ioa_helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$taxonomy = 'product_cat';
$terms = get_the_terms( get_the_ID(), $taxonomy ); 
$t = array();

if($terms)
foreach ($terms as $key => $obj) {
	$t[] = '<a href="'.get_term_link($obj->term_id,$taxonomy).'">'.$obj->name.'</a>';
}

$taxonomy = 'product_tag';
$tags = get_the_terms( get_the_ID(), $taxonomy ); 
$ta = array();

if($tags)
foreach ($tags as $key => $obj) {
	$ta[] = '<a href="'.get_term_link($obj->term_id,$taxonomy).'">'.$obj->name.'</a>';
}




?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="clearfix">


		<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary page-content entry-summary">
		

		<div class="single-product-navigation clearfix">
			<span><i class='ioa-front-icon left-circled2icon-'></i> <?php _e('Back To ','ioa') ?><a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ) ?>" class="back-to-shop"> <?php _e('Shop','ioa') ?> </a></span>

			<div class="product-navigation clearfix"  itemscope itemtype='http://schema.org/SiteNavigationElement'>
				<?php next_post_link('<span class="next" itemprop="url"> %link </span>','&rarr;'); ?>
				<?php previous_post_link('<span class="previous" itemprop="url"> %link </span>',' &larr;'); ?>  
			</div>

		</div>
		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>

		<div class="product-meta">
			<ul>
				<?php if($terms) : ?> <li><strong><?php _e('Categories','ioa') ?> - </strong><?php echo join(" , ",$t) ?></li> <?php endif; ?>
				<?php if($terms) : ?> <li><strong><?php _e('Tags','ioa') ?> - </strong><?php echo join(" , ",$ta) ?></li> <?php endif; ?>
			</ul>
		</div>
		

	</div><!-- .summary -->

	</div>

	<div class="product-share-area clearfix">
		<ul>
			<li>
				<a href="https://twitter.com/share/?url=<?php echo urlencode(get_permalink());  ?>&amp;text=<?php echo get_the_title().' '.urlencode(get_permalink()) ?>" target="_BLANK">
					<i class='ioa-front-icon twitter-1icon-'></i>
					<span><?php _e('Tweet this Product','ioa'); ?></span>
				</a>
			</li>

			<li>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink());  ?>" target="_BLANK" >
					<i class='ioa-front-icon facebook-1icon-'></i>
					<span><?php _e('Share on Facebook','ioa'); ?></span>
				</a>
			</li>

			<li>
				<a href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink());  ?>" target="_BLANK">
					<i class='ioa-front-icon gplus-1icon-'></i>
					<span><?php _e('Share on Google+','ioa'); ?></span>
				</a>
			</li>

			<li>
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink());  ?>&amp;media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') )); ?>&amp;description=<?php echo strip_tags(get_the_excerpt()) ?>" target="_BLANK">
					<i class='ioa-front-icon pinterest-1icon-'></i>
					<span><?php _e('Pin this Product','ioa'); ?></span>
				</a>
			</li>
		</ul>

	</div>


	<?php
	/**
	 * woocommerce_after_single_product_summary hook
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_output_related_products - 20
	 */
	
	do_action( 'woocommerce_after_single_product_summary' );
	?>

	
	<div class="related-product-wrap clearfix">
		<?php echo do_shortcode('[related_products posts_per_page="4" columns="4"]'); ?>
	</div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>