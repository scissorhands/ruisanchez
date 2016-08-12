<?php
/**
 * Blog Column Template
 */

global $ioa_helper,$ioa_meta_data,$post,$ioa_super_options;

$ioa_helper->preparePage();

get_header(); 


$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 1060;
$ioa_meta_data['height'] = $ioa_super_options[SN.'_bt_height'];
$ioa_meta_data['layout'] = 'right-sidebar';
$ioa_meta_data['sidebar'] = $ioa_super_options[SN.'_category_sidebar'];

if($ioa_meta_data['layout']!="full")
{

	$ioa_meta_data['width'] = 740;
}

$ioa_helper->getBlogParameters();

$blog_props = $ioa_meta_data['blog_props'];
 
?>

	
	<div class="skeleton clearfix auto_align">

		

		<div class="mutual-content-wrap iso-parent blog-template  <?php if($ioa_meta_data['layout']!="full") echo 'has-sidebar has-'.$ioa_meta_data['layout'];  ?>">


			<div class="blog-column-posts hoverable clearfix">
				<ul class="clearfix blog_posts  ">
					 <?php 
					 		
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

<?php get_footer(); ?>