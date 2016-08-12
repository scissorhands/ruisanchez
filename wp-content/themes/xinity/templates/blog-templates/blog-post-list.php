<?php
/**
 * Blog Column Template
 */

global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options;

$ioa_meta_data['item_per_rows'] = 1;

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
	}	?>

<div class="skeleton clearfix auto_align " itemscope itemtype="http://schema.org/Blog">

<div class="mutual-content-wrap blog-template iso-parent <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout']; else echo 'full-layout';  ?>">

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
	 	$opts = array_merge(array('posts_per_page' => $blog_props['_posts_item_limit'] , 'paged' => $paged) , $blog_props['query_filter']);
		query_posts($opts); 

		$ioa_meta_data['width'] = 350;
		if($ioa_meta_data['layout']=="full") $ioa_meta_data['width'] = 530;

		$ioa_meta_data['height'] = $blog_props['_bt_height'];
	?>
			
			
	<?php if($ioa_super_options[SN.'_blog_filter']!='false') : ?>	
		<div class="clearfix">
			<?php if(have_posts()) get_template_part('templates/blog-filter') ?>
		</div>
	<?php endif; ?>


	<div class="blog-list-posts hoverable clearfix">
		<ul class="clearfix blog_posts isotope " data-layout="masonry" data-gutter="40">
			 <?php 
			 		
			 		$ioa_meta_data['i']=0; 
			 		if(have_posts()) :
			 			while (have_posts()) : the_post(); 
								get_template_part('templates/post-blog-list');  
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
<?php get_sidebar();  wp_reset_postdata(); ?>
</div>
