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
$ioa_meta_data['full_media'] = false;
/**
 * Select Template or fallback to page.
 */

//echo $ioa_meta_data['ioa_custom_template'];

switch($ioa_meta_data['ioa_custom_template'])
{
	
	case 'ioa-template-blog-one-column' : get_template_part('templates/blog-templates/blog-column'); break;
	case 'ioa-template-blog-list' : get_template_part('templates/blog-templates/blog-post-list'); break;
	case 'ioa-template-blog-grid' : get_template_part('templates/blog-templates/blog-two-column'); break;
 	case 'ioa-template-full-width-blog-masonary' : get_template_part('templates/blog-templates/full-masonry'); break;
	case 'ioa-template-blog-timeline' : get_template_part('templates/blog-templates/timeline'); break;

	case 'ioa-template-portfolio-one-column' : get_template_part('templates/portfolio-templates/col-1'); break;
	case 'ioa-template-portfolio-two-column' : get_template_part('templates/portfolio-templates/col-2'); break;
	case 'ioa-template-portfolio-three-column' : get_template_part('templates/portfolio-templates/col-3'); break;
	case 'ioa-template-portfolio-ajax-column' : get_template_part('templates/portfolio-templates/ajax'); break;
	case 'ioa-template-portfolio-four-column' : get_template_part('templates/portfolio-templates/col-4'); break;
	case 'ioa-template-portfolio-five-column' : get_template_part('templates/portfolio-templates/col-5'); break; 
	case 'ioa-template-portfolio-full-screen-gallery' : get_template_part('templates/portfolio-templates/full-screen'); break;
	case 'ioa-template-portfolio-product-gallery' : get_template_part('templates/portfolio-templates/product-gallery'); break;
	case 'ioa-template-portfolio-modelie' : get_template_part('templates/portfolio-templates/modelie'); break;
	case 'ioa-template-portfolio-masonry' : get_template_part('templates/portfolio-templates/masonary'); break;
	case 'ioa-template-portfolio-list' : get_template_part('templates/portfolio-templates/list'); break;
	case 'ioa-template-portfolio-maerya' : get_template_part('templates/portfolio-templates/maerya'); break;

	case 'ioa-template-shop-maerya' : get_template_part('templates/shop-templates/maerya'); break;
	case 'ioa-template-shop-masonry' : get_template_part('templates/shop-templates/masonary'); break;
	case 'ioa-template-shop-default' : get_template_part('templates/shop-templates/default-shop'); break;
	case 'ioa-template-shop-two-columns' : get_template_part('templates/shop-templates/col-2'); break;
	case 'ioa-template-shop-three-columns' : get_template_part('templates/shop-templates/col-3'); break;
	case 'ioa-template-shop-four-columns' : get_template_part('templates/shop-templates/col-4'); break;
	case 'ioa-template-shop-five-columns' : get_template_part('templates/shop-templates/col-5'); break;
	case 'ioa-template-shop-gallery' : get_template_part('templates/shop-templates/product-gallery'); break;

	case 'ioa-template-contact-page' : get_template_part('templates/misc-templates/contact-1'); break;
	case 'ioa-template-contact-full-screen-page' : get_template_part('templates/misc-templates/contact-full'); break;
	case 'ioa-template-blank-page' : get_template_part('templates/misc-templates/blanktemplate'); break;
	case 'ioa-template-sitemap' : get_template_part('templates/misc-templates/sitemap'); break;
	case 'ioa-template-custom-post-template' : get_template_part('templates/custom-post-template'); break;
	case 'default' :
	default :

	if(!isset($ioa_meta_data['featured_media_type'])) $ioa_meta_data['featured_media_type'] = 'none';
	if(!isset($ioa_meta_data['sidebar'])) $ioa_meta_data['sidebar'] = 'Blog Sidebar';
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
			 		case 'none' : break;
			 		case 'slider' :
			 		case 'slideshow' :
			 		case 'video' :
			 		case 'proportional' :
			 		case 'none-contained' :
			 		case 'image' : get_template_part('templates/content-featured-media'); break;
			 	}
			?>
			</div>
			
			<?php
			
			   if(have_posts()): while(have_posts()) : the_post(); ?>
					
						<?php $ioa_meta_data['rad_trigger'] = true; the_content(); ?>
					
				<?php endwhile;   endif;  ?>
			
			<div class="<?php if($ioa_meta_data['layout']=="full") echo 'skeleton' ?> clearfix auto_align">			
				<?php if( $ioa_super_options[SN.'_page_comments'] =="true" ) comments_template(); ?>
			</div>

		</div>
		<?php get_sidebar(); ?>
	</div>

<?php  } ?>
<?php get_footer(); ?>
