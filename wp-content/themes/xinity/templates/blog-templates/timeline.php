<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options;


$ioa_meta_data['item_per_rows'] = 2;


$ioa_helper->getBlogParameters();
$blog_props = $ioa_meta_data['blog_props'];

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

	<div class="mutual-content-wrap blog-template <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
		<div class="timeline-posts hoverable clearfix">

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
				 	$ioa_meta_data['width'] = 330;
					$ioa_meta_data['height'] = $ioa_super_options[SN.'_bt_height'];	

				 	get_template_part('templates/post-blog-timeline');  
					?>
		</div>
	</div>
	<?php get_sidebar();  wp_reset_postdata(); ?>
</div>
