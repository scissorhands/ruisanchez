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

/**
 * Select Template or fallback to page.
 */
//echo $ioa_meta_data['ioa_custom_template'];

if($post->post_type==$ioa_portfolio_slug) :
	 get_template_part('templates/content-single-portfolio');
else :

$ioa_meta_data['full_media'] = false;
?>   


<?php

		/**
		 * Full Width Featured Media Items will appear here. 
		 * Note the switches are for condition checking on featured media Full or Contained. 
		 */
		if(! post_password_required() && $ioa_super_options[SN.'_featured_image']!='false')  // Check if Page is password protected

	 	switch($ioa_meta_data['featured_media_type'])
	 	{
	 		case "slider-full" :
	 		case "slider-contained" :
	 		case "slideshow-fullscreen" :
	 		case "slideshow-contained" :
	 		case "none-full" :
	 		case 'image-parallex' : 
	 		case 'slider-manager' :
	 		case 'rev_slider' :
	 		case 'image-full' : $ioa_meta_data['gr'] = true; $ioa_meta_data['full_media'] = true; get_template_part('templates/content-featured-media'); break;
	 	}


	?>

	<div class="<?php if($ioa_meta_data['layout']!="full") echo 'skeleton';  if($ioa_meta_data['full_media']) echo ' has_full_media'; ?> clearfix auto_align">
		<div class="mutual-content-wrap <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
			
			<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">
			<?php  
				/**
				 * Featured Media Items contained by parent width will appear here. 
				 */
				if(! post_password_required() && $ioa_super_options[SN.'_featured_image']!='false' ) // Check if Page is password protected
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
			
			
			<?php   if(! post_password_required() && $ioa_super_options[SN.'_meta_s']!='false' &&  $post->post_type == 'post' ) : ?>

					<div class="meta-info clearfix">
						<div class="clearfix inner-meta-info">
							<?php echo do_shortcode(stripslashes($ioa_super_options[SN.'_single_meta'])); ?>
						</div>
					</div>
			<?php  endif; ?>
			
			</div>

			<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
			
					<div class="clearfix <?php if($post->post_type!='post') echo 'skeleton auto_align page-content' ?>">
						<?php if($post->post_type=='post')$ioa_meta_data['rad_trigger'] = true; the_content(); ?>
					</div>
					<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">
						<?php wp_link_pages(); ?>
					</div>
		
			<?php endwhile; endif;  ?>


			<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton'; ?> clearfix auto_align">

			<?php if($ioa_super_options[SN."_author_bio"]!="false" && $post->post_type == 'post' && ! post_password_required() ) : ?>
			
		    <div id="authorbox" class="clearfix " >  
		      	<div class="author-avatar">
		      	      <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); }?>  
		      	</div>
		      	<div class="authortext">   
		      		<h3 class="custom-font"><?php _e('About ','ioa'); the_author_meta('first_name'); ?></h3>
		      		<p><?php the_author_meta('description'); ?></p>  
		      	</div>  
		    </div>
			<?php endif; ?>

			<?php if($ioa_super_options[SN."_popular"]!="false" && $post->post_type == 'post' && ! post_password_required() )  get_template_part('templates/single-related-posts'); ?>

			
			<?php if($post->post_type == 'post' && ! post_password_required() ) : ?>
				
				<?php if($ioa_super_options[SN."_fb_comments"]!="false") : ?>
				<div class="fb_comments_template">

					<div id="fb-root"></div>
					<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=165111413574616";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

					<div class="fb-comments" data-href="<?php the_permalink();?>" data-num-posts="2" data-width="<?php echo $ioa_meta_data['width'] ?>" data-height="80" <?php if(isset($_SESSION['vskin']) && $_SESSION['vskin'] == 'dark' ) echo 'data-colorscheme="dark"'; ?> ></div>
				</div>
				<?php endif; ?>
				<?php  comments_template(); ?>
     		<?php endif; ?>		
			


			</div>

		</div>
		<?php get_sidebar(); ?>
	</div>

<?php  endif; ?>


<?php get_footer(); ?>
