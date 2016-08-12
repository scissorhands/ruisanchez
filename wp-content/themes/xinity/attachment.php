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
$ioa_helper->preparePage();


get_header(); 


?>   

	
	<div class="full skeleton clearfix auto_align">
		<div class="mutual-content-wrap ">
				


			<div class="skeleton clearfix auto_align">
			
				<div class="featured-wrap">
					<div class="single-image">
						<?php echo wp_get_attachment_image( get_the_ID(), array(1060,450) ); ?>
					</div>
				</div>
				
				<?php  the_content(); ?>
			
			</div>

					

		</div>
		
	</div>

	




<?php get_footer(); ?>
