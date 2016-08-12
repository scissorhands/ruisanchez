
<?php
global $ioa_meta_data,$ioa_super_options,$post,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$ioa_helper;

$ioa_meta_data['layout'] = "full";

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options =="" )$ioa_options = array();
?>   


	<?php  
	 	switch($ioa_meta_data['featured_media_type'])
	 	{
	 		case "slider-full" :
	 		case "slider-contained" :
	 		case "slideshow-contained" :
	 		case "none-full" :
	 		case 'image-parallex' : 
	 		case 'image-full' : get_template_part('templates/content-featured-media'); break;
	 	}
	?>
         

<div class="skeleton clearfix auto_align">

	

	<div class="mutual-content-wrap <?php if($ioa_meta_data['layout']!="full" && $ioa_meta_data['layout']!="below-title" && $ioa_meta_data['layout']!="above-footer") echo 'has-'.$ioa_meta_data['layout'];  ?>">
     
		
		<div class="clearfix">
			<div class="one_half side-featured-media layout_element">
				 <?php  
				 $ioa_meta_data['width'] = 505;
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

				<?php if(isset($ioa_options['ioa_portfolio_data']) && $ioa_options['ioa_portfolio_data']!="" ) :  ?>
			<div class="extra-portfolio-items clearfix">
				<ul class="isotope hoverable no-canvas" data-layout="masonry" data-gutter="0" >
					<?php $i = 1; 
					$images = explode(";",stripslashes($ioa_options['ioa_portfolio_data'])); 
					foreach ($images as $key => $image) {
						if($image!="")
						{
							$g_opts = explode("[ioabre]",$image);

						 echo '<li class="iso-item hover-item">'.$ioa_helper->imageDisplay(array( "src" => $g_opts[0] , "height" => 400 , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,'imageAttr' =>  ' ' , 'crop' => "wproportional" ));   
						   $ioa_helper->getHover(array( "image" => $g_opts[0] , 'format' => 'image' , 'title' => $g_opts[3] ) );
						  echo '</li>';   
						}
					} ?>
				</ul>	
			</div>
			<?php endif; ?>
	
			</div>

			<div class="single-portfolio-content page-content side-single-portfolio-content one_half layout_element last">
		<?php  if(have_posts()): while(have_posts()) : the_post(); ?>
				<h1 class="custom-title"><?php the_title(); ?></h1>
				<?php get_template_part( 'templates/content', get_post_format() ); ?>
		

		<?php endwhile; endif; ?>
		</div>

		</div>
		

		
		
		<div class="portfolio-navigation clearfix" itemscope itemtype='http://schema.org/SiteNavigationElement'>
			<?php next_post_link('<span class="next" itemprop="url"> %link &rarr; </span>'); ?>
			<?php previous_post_link('<span class="previous" itemprop="url"> &larr; %link </span>'); ?>  
		</div>

		<?php get_template_part('templates/single-related-portfolio'); ?>

	</div>
</div>

