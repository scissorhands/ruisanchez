<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_layout;


$ioa_meta_data['column'] =  'full';

$ioa_helper->getProductParameters();
$product_props = $ioa_meta_data['product_props'];

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
		case "slideshow-fullscreen" :
		case "none-full" :
		case 'image-parallex' : 
		case 'slider-manager' :
		case 'rev_slider' :
		case 'image-full' : $ioa_meta_data['gr'] = true; $ioa_meta_data['full_media'] = true; get_template_part('templates/content-featured-media'); break;
	}
?>

	
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap iso-parent portfolio-template product-maerya portfolio-maerya <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'].' has-sidebar';  ?>">

			<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">
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
			</div>
			<?php if(IOA_WOO_EXISTS) : ?>
       		<?php  
				if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

			 	
				
			 	$ioa_meta_data['item_per_rows'] = $product_props['_product_item_limit'];

				$ioa_meta_data['width'] = $ioa_layout['cols']['three_fourth'];
				$ioa_meta_data['height'] = $product_props['_pr_height'];
				if($ioa_meta_data['layout']!="full")
					$ioa_meta_data['width'] = 213;

			?>
			
				
			<div class="clearfix portfolio-maerya-wrap">
			<a href="" class="close-section ioa-front-icon cancel-3icon-"></a>
			<?php while(have_posts()) : the_post();  ?>
				<div class="one_fourth  layout_element ">
					<div class="maerya-portfolio-content clearfix"> <?php the_content(); ?></div>	
					<div class="dynamic-content"></div>
				</div>
			<?php endwhile; ?>

			<div class="three_fourth last clearfix layout_element ">
					<div class="maerya-list-wrap">
						<ul class="portfolio-maerya-list clearfix"  itemscope itemtype="http://schema.org/ItemList">

						 <?php 

					 		$ioa_meta_data['i']=0; 
					 		
					 		$opts = array_merge(array( 'post_type' => 'product','suppress_filters' => 0,  'posts_per_page' => $product_props['_product_item_limit'] , 'paged' => $paged) , $product_props['query_filter']);
							query_posts($opts); 

					 		if(have_posts()) :
					 		while (have_posts()) : the_post(); 
	   							 get_template_part('templates/content-product-maerya');  
   							endwhile; 
   							else : 
								echo '<li class="no-posts-found "><h4>'.__('Sorry no posts found','ioa').'</h4></li>';
							endif; ?>

					</ul>
					</div>
			</div>	
			</div>	

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
