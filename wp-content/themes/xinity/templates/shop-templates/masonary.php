<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 3;
$ioa_meta_data['width'] = 600;
$ioa_meta_data['column'] =  'full';

$ioa_helper->getProductParameters();
$product_props = $ioa_meta_data['product_props'];
$ioa_meta_data['height'] = $product_props['_pr_height'];

$cl = "portfolio-masonry";


?>   

	
<div class=" clearfix auto_align">
	<div class="mutual-content-wrap iso-parent portfolio-masonry-template portfolio-template">
		<?php if(IOA_WOO_EXISTS) : ?>
   		<?php  
			if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

		 	$opts = array_merge(array( 'post_type' => 'product','suppress_filters' => 0,  'posts_per_page' => $product_props['_product_item_limit'] , 'paged' => $paged) , $product_props['query_filter']);
			query_posts($opts); 
		?>
		

		<?php if(have_posts()) : ?>
		<div class="clearfix top-portfolio-nav">
			<?php if($ioa_super_options[SN.'_product_filter']!="false") get_template_part('templates/product-filter'); ?>
		</div>
		<?php endif; ?>
		

		<div class=" <?php echo $cl ?> hoverable no-canvas clearfix">
			<ul class="clearfix portfolio_posts woo_product isotope" itemscope itemtype="http://schema.org/ItemList" data-layout="masonry" data-gutter="0">
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
		<?php  wp_reset_postdata(); 
 ?>
		<a href="" class="product-masonry-load-more" data-id="<?php echo get_the_ID() ?>"> <span class="button-content">Load More</span>
  <span class="progress">
    <span class="inner-progress-bar"></span>
  </span></a>

  <?php else: ?>
			<h2><?php _e('Woo Commerce Plugin not activated','ioa'); ?></h2>
	<?php endif; ?>	
		

	</div>

</div>
	
	

