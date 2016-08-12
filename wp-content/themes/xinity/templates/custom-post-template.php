<?php

global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options;
$ioa_meta_data['item_per_rows'] = 3;

$ioa_meta_data['column'] =  'full';
$cl = "portfolio-columns  four-column";

$custom_post_type = $custom_query_filter =   $ioa_custom_posts_item_limit = $ioa_meta_data['custom_enable_thumbnail'] = '';
$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="") $ioa_options = array();
        
if( isset($ioa_options['custom_post_type']) ) $custom_post_type =  $ioa_options['custom_post_type'];
if( isset($ioa_options['custom_query_filter']) ) $custom_query_filter =  $ioa_options['custom_query_filter'];
if( isset($ioa_options['custom_posts_item_limit']) ) $ioa_custom_posts_item_limit =  $ioa_options['custom_posts_item_limit'];
if( isset($ioa_options['custom_enable_thumbnail']) ) $ioa_meta_data['custom_enable_thumbnail'] = $ioa_options['custom_enable_thumbnail'];

if($custom_query_filter!="")
		{
			$gen = array(); $custom_tax = array();
			$custom_query_filter = explode("&",$custom_query_filter);
			foreach ($custom_query_filter as  $para) {
				$p = explode("=", $para); 

					
				if($p[0]=="tax_query")
		        {
		        	$vals = explode("|",$p[1]); 	
		        	$custom_tax[] = array(
		        			'taxonomy' => $vals[0],
							'field' => 'id',
							'terms' => explode(",", $vals[1])

		        		);
		        }
		        else if($para!="") $gen[$p[0]] = $p[1];	
				
			}
			$gen["tax_query"] = $custom_tax;
			$custom_query_filter = $gen;
		}
		else $custom_query_filter = array();


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
	 		case 'image-full' : $ioa_meta_data['gr'] = true; get_template_part('templates/content-featured-media'); break;
	 	}
	?>

<div class="skeleton clearfix auto_align">
	<div class="mutual-content-wrap portfolio-template <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
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

		<?php 
		$opts = array_merge(array( 'post_type' => $custom_post_type,  'posts_per_page' => $ioa_custom_posts_item_limit , 'paged' => $paged) , $custom_query_filter );
			query_posts($opts); 
		 ?>

		 <div class=" <?php echo $cl ?> hoverable  clearfix">
			<ul class="clearfix portfolio_posts isotope" itemscope itemtype="http://schema.org/ItemList" data-layout="masonry" data-gutter="50">
				 <?php 
				 
				 		$ioa_meta_data['width'] = 227;
						$ioa_meta_data['height'] = 250;
				 		
				 		$ioa_meta_data['i']=0; 

				 		if(have_posts()) :
				 		while (have_posts()) : the_post(); 	

				 		get_template_part('templates/custom-cols');  

							endwhile; 
							else : 
								echo ' <li class="no-posts-found"><h4>'.__('Sorry no posts found','ioa').'</h4></li> ';
								
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


