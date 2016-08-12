
<?php
global $ioa_helper,$ioa_meta_data,$ioa_super_options,$post,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="") $ioa_options = array();
if(isset( $ioa_options['ioa_portfolio_data'] )) $gallery_images =  $ioa_options['ioa_portfolio_data'];

?>   

	<?php  if(isset($gallery_images) && trim($gallery_images) != "" && count($gallery_images) > 0  ) :  ?>
		<div class="single-full-screen-view-pane full-stretch" data-id="<?php echo get_the_ID() ?>">
						
			
			<div class="spfs-gallery seleneGallery ioa-gallery" data-thumbnails="true" data-autoplay="false" data-effect_type="fade" data-caption="false" data-fullscreen='true' data-arrow_control="true" data-duration="5" data-height="<?php  echo $ioa_meta_data['height']; ?>"  data-width="<?php echo $ioa_meta_data['width']; ?>"   > 
                     <div class="gallery-holder">
					<?php 
					$ar = explode(";",stripslashes($gallery_images));
						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("[ioabre]",$image);

							
						 ?>
						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>">
                      		<?php echo "<img src='".$g_opts[0]."'/>"; ?> 
                  		 </div>	
					<?php 
						endif;
					endforeach; ?>
				</div></div> 

		
		</div>

	<?php else : 
	$ioa_meta_data['featured_media_type'] = 'image-full';
	$ioa_meta_data['adaptive_height'] = 'true';
	 get_template_part('templates/content-featured-media');

	 endif;  ?>

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


