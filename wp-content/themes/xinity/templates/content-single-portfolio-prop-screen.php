
<?php
global $ioa_helper,$ioa_meta_data,$ioa_super_options,$post,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="") $ioa_options = array();
if(isset( $ioa_options['ioa_portfolio_data'] )) $gallery_images =  $ioa_options['ioa_portfolio_data'];

?>   



<div class="page-wrapper <?php echo $post->post_type ?>"  itemscope itemtype='http://schema.org/WebPage'>
	
	<?php  if(isset($gallery_images) && trim($gallery_images) != "" && count($gallery_images) > 0  ) :  ?>
		<div class="single-prop-screen-view-pane full-stretch" data-id="<?php echo get_the_ID() ?>">
						
		
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
	</div>


