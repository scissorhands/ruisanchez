<?php

global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['width'] = 1060;

$ioa_helper->getProductParameters();
$product_props = $ioa_meta_data['product_props'];

$ioa_meta_data['height'] = $product_props['_pr_height'];

if($ioa_meta_data['layout']!="full")
	$ioa_meta_data['width'] = 740;

$ioa_helper->getProductParameters();
$product_props = $ioa_meta_data['product_props'];

?>   


<div class="skeleton clearfix auto_align">

	<div class="mutual-content-wrap portfolio-template portfolio-gallery <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout']." has-sidebar";  ?>">
		<?php if(IOA_WOO_EXISTS) : ?>
		<?php	
		if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
		$opts = array_merge(array( 'post_type' => 'product','suppress_filters' => 0,  'posts_per_page' => $product_props['_product_item_limit'] , 'paged' => $paged) , $product_props['query_filter']);
		query_posts($opts); 
			
			query_posts($opts); if(have_posts()) :?> 	

		<div class="product-gallery  clearfix">
			

		<div  itemscope itemtype="http://schema.org/ImageGallery" class="ioa-gallery seleneGallery" data-effect_type="fade" data-width="<?php echo $ioa_meta_data['width'] ?>" data-height="<?php echo $ioa_meta_data['height'] ?>" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-thumbnails="true" > 
                  <div class="gallery-holder"> 
                  	<?php

					while(have_posts()) : the_post(); 
						get_template_part('templates/content-product-gallery');
					endwhile;

					?> 
				   </div>
		</div>


		</div>	

		<?php else : 
				echo ' <div class="no-posts-found"><h4>'.__('Sorry no posts found','ioa').'</h4></div> ';
				
			endif; ?>

		
			<?php if(have_posts()) : ?>
			<div class="pagination_wrap clearfix">
				<?php wp_paginate(); ?>
				<?php wp_paginate_dropdown(); ?>
			</div>
			<?php endif; ?>
		<?php else: ?>
			<h2><?php _e('Woo Commerce Plugin not activated','ioa'); ?></h2>
	<?php endif; ?>		
	
	</div>

		<?php get_sidebar(); ?>
</div>
	<?php  wp_reset_postdata(); ?>
		
