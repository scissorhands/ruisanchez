
<?php
global $ioa_meta_data,$ioa_super_options,$post,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$ioa_helper;

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
$gallery_images = array();

if($ioa_options =="" )$ioa_options = array();
if(isset( $ioa_options['ioa_portfolio_data'] )) $gallery_images =  $ioa_options['ioa_portfolio_data'];

$h = 400; $w = 500;
?>   



<div class="single-portfolio-modelie" >
	

	<?php  if(isset($gallery_images) && trim($gallery_images) != "" && count($gallery_images) > 0  ) :  ?>
	
	<div class="single-model-images">
		<div class="modelie-container hoverable swiper-container" data-items='3'>
		<div class="modelie-posts-wrapper clearfix swiper-wrapper">
				<?php $i = 1; 
				$ar = explode(";",stripslashes($gallery_images));
				foreach ($ar as $key => $image) {
					if($image!="")
					{
						$g_opts = explode("[ioabre]",$image);
					 echo '<div class="swiper-slide hover-item">'.$ioa_helper->imageDisplay(array( "src" => $g_opts[0] , "height" =>$h , "width" => $w , "parent_wrap" => false ,'imageAttr' =>  '' , 'crop' => "hproportional" )).'';   
					  $ioa_helper->getHover(array( "image" => $g_opts[0] , 'format' => 'image' ) ); 
					 echo '</div>';
					}
				} ?>
		</div>
	</div>
	<div class="modelie-scrollbar-wrap">
						<div class="modelie-scrollbar"></div>
	</div>	
	</div>


    <?php else : 
		$ioa_meta_data['featured_media_type'] = 'image';
	 	get_template_part('templates/content-featured-media');

	 endif; ?>   	 

	<div class="<?php if($ioa_meta_data['layout']!="full") echo 'skeleton' ?> clearfix auto_align">
		<div class="mutual-content-wrap <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
			
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
			

			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
			
				<div class="clearfix">
						<?php $ioa_meta_data['rad_trigger'] = true; the_content(); ?>
				</div>

			
			<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">


				<div class="portfolio-navigation clearfix"  itemscope itemtype='http://schema.org/SiteNavigationElement'>
					<?php next_post_link('<span class="next" itemprop="url"> %link &rarr; </span>'); ?>
					<?php previous_post_link('<span class="previous" itemprop="url"> &larr; %link </span>'); ?>  
				</div>

			<?php get_template_part('templates/single-related-portfolio'); ?>
			</div>	

		
			<?php endwhile; endif;  ?>
			
		</div>
		<?php get_sidebar(); ?>
	</div>