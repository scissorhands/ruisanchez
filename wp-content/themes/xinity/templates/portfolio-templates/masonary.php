<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 3;
$ioa_meta_data['width'] = 600;
$ioa_meta_data['column'] =  'full';

$ioa_helper->getPortfolioParameters();
$portfolio_props = $ioa_meta_data['portfolio_props'];

$ioa_meta_data['height'] = $portfolio_props['_p_height'];

$cl = "portfolio-masonry";


?>   

	
<div class=" clearfix auto_align">
	<div class="mutual-content-wrap iso-parent portfolio-masonry-template portfolio-template">

   		<?php  
			if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

		 	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] , 'paged' => $paged) , $portfolio_props['query_filter']);
			query_posts($opts); 
		?>
		
		
		<?php if(have_posts()) : ?>
		<div class="clearfix top-portfolio-nav">
			<?php if($ioa_super_options[SN.'_portfolio_filter']!="false") get_template_part('templates/portfolio-filter'); ?>
		</div>
		<?php endif; ?>
			

		<div class=" <?php echo $cl ?> hoverable clearfix">
			<ul class="clearfix portfolio_posts  isotope" itemscope itemtype="http://schema.org/ItemList" data-layout="masonry" data-gutter="0">
				 <?php 
				 		
				 		$ioa_meta_data['i']=0; 

				 		if(have_posts()) :
				 		while (have_posts()) : the_post(); 	

				 		 get_template_part('templates/portfolio-cols');

							endwhile;
							else : 
								echo ' <li class="no-posts-found">'.__('Sorry no posts found','ioa').'</li> ';
							endif;	
							
							 ?>
			</ul>	
		</div>
		<?php  wp_reset_query(); 
 ?>
		<a href="" class="portfolio-masonry-load-more ajax-load-more-button" data-id="<?php echo get_the_ID() ?>"> <span class="button-content">Load More</span>
  <span class="progress">
    <span class="inner-progress-bar"></span>
  </span></a>
		

	</div>

</div>
	
	

