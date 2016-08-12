<?php
/**
 * Blog Column Template
 */

global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options;

$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 400;

$ioa_meta_data['crop'] = 'wproportional';

$ioa_helper->getBlogParameters();

$blog_props = $ioa_meta_data['blog_props'];
$ioa_meta_data['height'] = $blog_props['_bt_height'];

?>   

<div class=" full-blog-masonry clearfix blog-template " itemscope itemtype="http://schema.org/Blog">

	<div class="mutual-content-wrap iso-parent ">
		<?php  
			if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

		 	$opts = array_merge(array('posts_per_page' => $blog_props['_posts_item_limit'] ) , $blog_props['query_filter']);
			query_posts($opts); 
		?>
		
		
		<?php if($ioa_super_options[SN.'_blog_filter']!='false') : ?>	
			<div class="clearfix">
				<?php if(have_posts()) get_template_part('templates/blog-filter') ?>
			</div>
		<?php endif; ?>


		<div class="blog-column-posts hoverable masonry-block clearfix">
			<ul class="clearfix blog_posts  isotope"   data-layout="masonry" data-gutter="50">
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
		
		
		<div class="more-button">
			<a href="" data-id="<?php echo get_the_ID(); ?>" class="masonry-load-more ajax-load-more-button active"><span class="button-content">Load More</span>
	  			<span class="progress">
	    			<span class="inner-progress-bar"></span>
	  			</span>
	  		</a>
		</div>
	</div>
</div>
		