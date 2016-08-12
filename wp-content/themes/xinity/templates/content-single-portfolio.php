<?php
/**
 * Single Portfolio 
 */
global $ioa_meta_data,$ioa_super_options,$post,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$ioa_helper;

/**
 * Single Portfolio Template
 */


/**
 * Prepare Page Variables before HEADER Template.
 */
$ioa_helper->preparePage();

get_header(); 

/**
 * Select Template or fallback to page.
 */

switch ($ioa_meta_data['ioa_custom_template']) {
	case 'full-screen': get_template_part('templates/content-single-portfolio-full-screen'); break;
	case 'full-screen-porportional': get_template_part('templates/content-single-portfolio-prop-screen'); break;
	case 'model': get_template_part('templates/content-single-portfolio-model'); break;
	case 'side': get_template_part('templates/content-single-portfolio-side'); break;
	case 'default' :
	default :

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );

if($ioa_options =="")
  $ioa_options = array();

$w = 335;
$h = 400;

if($ioa_meta_data['layout']!="full") 
{
	$w = 230; $h = 300;
}
?>   


<?php

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
	 	}
	?>
	
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

			<?php if(isset($ioa_options['ioa_portfolio_data']) && $ioa_options['ioa_portfolio_data']!="" ) :  ?>
			<div class="extra-portfolio-items clearfix">
				<h3>More Project Images</h3>
				<ul class="isotope hoverable no-canvas"   data-layout="masonry" data-gutter="25">
					<?php $i = 1; 
					$images = explode(";",stripslashes($ioa_options['ioa_portfolio_data'])); 
					foreach ($images as $key => $image) {
						if($image!="")
						{
							$g_opts = explode("[ioabre]",$image);
							
						 echo '<li class="iso-item hover-item">'.$ioa_helper->imageDisplay(array( "src" => $g_opts[0] , "height" =>$h , "width" => $w , "parent_wrap" => false ,'imageAttr' =>  '' , 'crop' => "wproportional" ));
						  $ioa_helper->getHover(array( "image" => $g_opts[0] , 'format' => 'image' ) );
						  echo '</li>';   
						}
					} ?>
				</ul>	
			</div>
			<?php endif; ?>

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

<?php  } ?>


