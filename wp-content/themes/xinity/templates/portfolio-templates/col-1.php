<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$ioa_layout;
$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['column'] =  'full';

$ioa_helper->getPortfolioParameters();
$portfolio_props = $ioa_meta_data['portfolio_props'];

$cl = "portfolio-columns  one-column";
if(isset($_GET['view']) && $_GET['view'] == "list"  ) $cl = "portfolio-list";

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
	<div class="mutual-content-wrap  portfolio-template iso-parent <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'].' has-sidebar';  ?>">
		
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

   		<?php  
			if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

		 	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] , 'paged' => $paged) , $portfolio_props['query_filter']);
			query_posts($opts); 

			$ioa_meta_data['width'] = $ioa_layout['content_width'];
			$ioa_meta_data['height'] = $portfolio_props['_p_height'];
			if($ioa_meta_data['layout']!="full")
				$ioa_meta_data['width'] = $ioa_layout['sidebar_content_width'];
		?>
		
		
		<?php if(have_posts()) : ?>
		<div class="clearfix">
			<?php if($ioa_super_options[SN.'_portfolio_switch']!="false") get_template_part('templates/portfolio-view'); ?>
			<?php if($ioa_super_options[SN.'_portfolio_filter']!="false") get_template_part('templates/portfolio-filter'); ?>
		</div>
		<?php endif; ?>
			

		<div class=" <?php echo $cl ?> hoverable clearfix">
			<ul class="clearfix portfolio_posts greyscale-imgs  isotope" itemscope itemtype="http://schema.org/ItemList"   data-layout="<?php if($portfolio_props['portfolio_image_resize']=='proportional') echo 'masonry'; else echo 'cellsByRow' ?>" data-gutter="<?php if( $portfolio_props['portfolio_cols'] != "grid" ) echo 50; else echo 0; ?>">
				 <?php 
				 		
				 		$ioa_meta_data['i']=0; 

				 		$v = 'grid';
				 		if(isset($_GET['view']) && $_GET['view'] == "list"  ) $v = "list";

				 		if(have_posts()) :
				 		while (have_posts()) : the_post(); 	

				 		switch ($v) {
				 			case 'list': get_template_part('templates/portfolio-list');  break;
				 			case 'grid': default : get_template_part('templates/portfolio-cols');  break;
				 		}

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
		

	</div>
	
	<?php get_sidebar(); ?>

</div>
<?php  wp_reset_postdata();  ?>
	

