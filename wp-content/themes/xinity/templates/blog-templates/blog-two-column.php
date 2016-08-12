<?php
/**
 * Blog Column Template
 */

global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options;

$ioa_meta_data['item_per_rows'] = 2;

$ioa_helper->getBlogParameters();
$blog_props = $ioa_meta_data['blog_props'];
?>   

<div class="skeleton clearfix auto_align" itemscope itemtype="http://schema.org/Blog">

	<div class="mutual-content-wrap blog-template iso-parent <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
		
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
		?>
		
		
		<?php if($ioa_super_options[SN.'_blog_filter']!='false') : ?>	
		<div class="clearfix">
			<?php if(have_posts()) get_template_part('templates/blog-filter') ?>
		</div>
	<?php endif; ?>


		<div class="blog-column-posts blog-two-columns hoverable clearfix">
			<ul class="clearfix blog_posts isotope "   data-layout="masonry" data-gutter="50">
				 <?php 
				 		
				 		$ioa_meta_data['width'] = 530;
						$ioa_meta_data['height'] = $blog_props['_bt_height'];

						if($ioa_meta_data['layout']!="full")
							$ioa_meta_data['width'] = 345;

				 		$ioa_meta_data['i']=0; 
				 		if(have_posts()) :
				 			while (have_posts()) : the_post(); 
									get_template_part('templates/post-blog-column');  
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

