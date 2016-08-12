<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 525;
$ioa_meta_data['column'] =  '';

$ioa_helper->getPortfolioParameters();
$portfolio_props = $ioa_meta_data['portfolio_props'];

$ioa_meta_data['height'] = 600;

$cl = "";


?>   


	<div class=" clearfix auto_align">
		<div class="mutual-content-wrap">

       		<?php  
				if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;

			 	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] , 'paged' => $paged) , $portfolio_props['query_filter']);
				query_posts($opts); 
			?>
			
	
			<div class=" <?php echo $cl ?> hoverable clearfix">
				

				<div class="modelie-container swiper-container" data-items='3'>
				  <div class="modelie-posts-wrapper clearfix swiper-wrapper">
				        <?php 
					 		
					 		$ioa_meta_data['i']=0; 


					 		if(have_posts()) :
					 		while (have_posts()) : the_post(); 	

					 			get_template_part('templates/modelie-cols');
					 		

   							endwhile;
   							else : 
   								echo ' <div class="no-posts-found">'.__('Sorry no posts found','ioa').'</div> ';
   							endif;	
   							
   						 ?>
   						 <a href="" data-id="<?php echo get_the_ID() ?>" class="add-more-modelie-items" data-load="<?php _e('Load More','ioa') ?>" data-loading="<?php _e('Loading','ioa') ?>" ><?php _e('Load More','ioa') ?></a>
				  </div>

				</div>
				<div class="modelie-scrollbar-wrap">
						<div class="modelie-scrollbar"></div>
				</div>	

			</div>

		</div>

	

