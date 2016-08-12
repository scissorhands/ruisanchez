<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$woocommerce,$product,$ioa_layout;
$ioa_meta_data['item_per_rows'] = 4;
$ioa_meta_data['column'] =  'full';

$ioa_helper->getProductParameters();
$product_props = $ioa_meta_data['product_props'];


$cl = "portfolio-columns  four-column";

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
	<div class="mutual-content-wrap portfolio-template iso-parent <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'].' has-sidebar';  ?>">
		
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
			$args = array();
			if(isset($_GET['orderby']))
			{
 	 			$args = $woocommerce->query->get_catalog_ordering_args();
		 	}		

		

		 	$opts = array_merge(array( 'post_type' => 'product','suppress_filters' => 0,  'posts_per_page' => $product_props['_product_item_limit'] , 'paged' => $paged) , $product_props['query_filter']);
		 	$opts = array_merge($opts,$args);
			query_posts($opts); 

			$ioa_meta_data['width'] = $ioa_layout['cols']['one_fourth'];
			$ioa_meta_data['height'] = $product_props['_pr_height'];

			if($ioa_meta_data['layout']!="full")
				$ioa_meta_data['width'] = $ioa_layout['sidebar_cols']['one_fourth'];

		?>
		
		<?php if(have_posts()) : ?>
		<div class="clearfix top-portfolio-nav">
			<?php if($ioa_super_options[SN.'_product_filter']!="false") get_template_part('templates/product-filter'); ?>
			<?php woocommerce_catalog_ordering(); ?>
		</div>
		<?php endif; ?>


			

		<div class=" <?php echo $cl ?> hoverable no-canvas clearfix">
			<ul class="clearfix portfolio_posts effectable  isotope" itemscope itemtype="http://schema.org/ItemList"  data-layout="masonry" data-gutter="50">
				 <?php 
				 		
				 		$ioa_meta_data['i']=0; 

				 		if(have_posts()) :
				 			while (have_posts()) : the_post(); 	
 								get_template_part('templates/product-cols');

							endwhile;
						else : 
							echo ' <li class="no-posts-found">'.__('Sorry no posts found','ioa').'</li> ';
						endif;	
							
							 ?>
			</ul>	
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
<?php  wp_reset_postdata();  ?>
	

