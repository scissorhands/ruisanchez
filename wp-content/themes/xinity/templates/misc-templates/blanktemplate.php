<?php
 /**
 * The Template for displaying Pages and registered Custom Templates.
 * Theme uses concept of Flexi Templates not dependent on custom type
 * slug to select template.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */


/**
 * Prepare Page Variables before HEADER Template.
 */

global $ioa_meta_data,$ioa_helper;
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
	 		case "none-full" :
	 		case 'image-parallex' : 
	 		case 'slider-manager' :
	 		case 'image-full' : $ioa_meta_data['gr'] = true; get_template_part('templates/content-featured-media'); break;
	 	}
	?>
	
	
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
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
			

			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
			
				<?php if(get_the_content()!="") : ?>
					<div class="page-content clearfix">
						<?php  the_content(); ?>
					</div>
				<?php endif; ?>
		
			<?php endwhile; endif;  ?>
		</div>
		<?php get_sidebar(); ?>
	</div>

