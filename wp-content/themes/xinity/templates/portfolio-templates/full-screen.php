<?php

global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['item_per_rows'] = 1;

$ioa_helper->getPortfolioParameters($id);
$portfolio_props = $ioa_meta_data['portfolio_props'];

$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] , 'paged' => $paged) , 
	$portfolio_props['query_filter']);
query_posts($opts); 

?>   


<div class="mutual-content-wrap ">

	<div class="full-screen-view-pane full-stretch" data-id="<?php echo get_the_ID() ?>" itemscope itemtype="http://schema.org/ImageGallery">
		<div class="ioa-gallery seleneGallery" data-effect_type="fade" data-width="1200" data-height="500" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-thumbnails="true" data-fullscreen="true" > 
            <div class="gallery-holder"> 
               	<?php   
               	if(have_posts()) :             	
				while(have_posts()) : the_post(); 
	

				if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  :
             	  $id = get_post_thumbnail_id();
	        	   $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
	         	  ?>   
            	
             	  <div class="gallery-item <?php echo $portfolio_props['portfolio_image_resize']; ?>" data-thumbnail="<?php $th = wp_get_attachment_image_src($id); echo $th[0]; ?>">

	               	<?php echo "<img src='". $ar[0]."' />";	?>
			        <a href="<?php echo $ar[0] ?>" rel="prettyphoto" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
		     		
		     		<div class="gallery-desc s-c-l">
		      			<h4 class="" <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h4>
		      			<div class="clearfix">
		      				<div class="caption">
					            <?php  if(  $portfolio_props['_portfolio_excerpt'] != "true") : ?>  
			                    <p>
			                      <?php
			                      if(!isset($portfolio_props['_portfolio_excerpt_limit'])) $portfolio_props['_portfolio_excerpt_limit'] = 150;	
			                      $content = get_the_content();
			                      $content = apply_filters('the_content', $content);
			                      $content = str_replace(']]>', ']]&gt;', $content);

			                      echo $ioa_helper->getShortenContent( 150,   $content); ?>
			                    </p>
			                   <?php else:  the_excerpt(); endif; ?>
                       		</div> 
		      			</div>
                  		<a href="<?php the_permalink(); ?>"  class="hover-link"><?php echo stripslashes($portfolio_props['_portfolio_more_label']) ?></a>  
              		</div>
              
                  </div>
              
             <?php endif; ?>
	<?php endwhile;
			else : 
				echo '<div class="no-posts-found skeleton auto_align"><h4>'.__('Sorry no posts found','ioa').'</h4></div>';
				
			endif;
	?> 
		 </div>
		</div>				
	
	</div>	
</div>
