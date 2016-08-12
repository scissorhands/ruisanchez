<?php 
/**
 * Featured Media for Posts
 */
global $ioa_helper, $ioa_super_options , $ioa_meta_data ,$post,$ioa_layout; 

$post_ID = get_the_ID();

$ioa_options = array();
$ioa_options = get_post_meta( $post_ID, 'ioa_options', true ); 

if( IOA_WOO_EXISTS && is_woocommerce() )
{
	if( is_shop() ) 
	{
		$post_ID = $ioa_meta_data['woo_id'];
		$ioa_options = get_post_meta($ioa_meta_data['woo_id'], 'ioa_options', true ); 
	}

}





$sm = ''; $fw ='';



if($ioa_options =="")
	$ioa_options = array();


	$flag= true;

?> 

<div class="featured-wrap <?php if(isset($ioa_options['show_title']) && $ioa_options['show_title'] == 'no') echo 'no-title '; if(isset($ioa_meta_data['full_media']) && $ioa_meta_data['full_media']) echo ' full-featured-media'; if($ioa_meta_data['featured_media_type']=='image' && !has_post_thumbnail()) echo 'no-post-thumb'; ?>  ">
<?php

if( $ioa_meta_data['featured_media_type'] == 'slider-manager' ) 
{
	$opts = get_post_meta($ioa_options['featured_media_slidermanager'],'options',true);
	$opts = $ioa_helper->getAssocMap($opts,'value');
	$sm = 'sm-'.$opts['slider_type'] ;
	$fw = $opts['full_width']; $flag = false;
	echo do_shortcode("[slider id='".$ioa_options['featured_media_slidermanager']."']");
}


if(function_exists('rev_slider_shortcode') && $ioa_meta_data['layered_media_type']!="none"  && $ioa_meta_data['layered_media_type']!="" &&  $ioa_meta_data['featured_media_type'] == 'rev_slider')
	{
		$flag = false;
		?> <div class='top-layered-slider '> <?php
		putRevSlider($ioa_meta_data['layered_media_type']);
		?> </div> <?php 	
		
	}


if(function_exists('lsSliders') && $ioa_meta_data['klayered_media_type']!="none"  && $ioa_meta_data['klayered_media_type']!=""  &&  $ioa_meta_data['featured_media_type'] == 'layered_slider')
	{
		$flag = false;
		?> <div class='top-layered-slider '> <?php
		echo do_shortcode('[layerslider id="'.$ioa_meta_data['klayered_media_type'].'"]');
		?> </div> <?php 	
	}

 

	if($flag)
 switch($ioa_meta_data['featured_media_type'])
		    {
		    	case 'slider-manager' : 

		    		echo do_shortcode("[slider id='".$ioa_options['featured_media_slidermanager']."']");

		    	break;

		    	case 'zoomable' : ?> 
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :

								$id = get_post_thumbnail_id($post_ID);
							    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );

						 ?>
							
							<div class="single-image zoomable clearfix" data-src="<?php echo $ar[0] ?>">
								<?php

								
								echo $ioa_helper->imageDisplay( array( "src"=> $ar[0] ,"height" =>  $ioa_meta_data['height'] , "width" =>  $ioa_meta_data['width'] , "parent_wrap" => false ) );   
							 	?> 
							 	<i class="zoom-icon ioa-front-icon search-3icon-"></i>
							</div>
					 		
						<?php  endif;  ?>		
		


		    	<?php break;
		    	

		    	case 'image' : ?> 
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) : ?>
							
							<div class="single-image clearfix">
								<?php

								$id = get_post_thumbnail_id($post_ID);
							    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );

								echo $ioa_helper->imageDisplay( array( "src"=> $ar[0] ,"height" =>  $ioa_meta_data['height'] , "width" =>  $ioa_meta_data['width'] , "parent_wrap" => false ) );   
							 	?> 
							</div>
					 		
						<?php  endif;  ?>		
		


		    	<?php break;

		    	case 'image-full' : 
		    	   if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
		    	   	$pr ='';
		    		if($ioa_meta_data['adaptive_height']=='true') 
		    			{
		    				$ioa_meta_data['height'] = "auto";
		    				$pr ='adaptive_height'; 
		    			}
		    		else $ioa_meta_data['height'] = $ioa_meta_data['height'].'px;';
					$id = get_post_thumbnail_id($post_ID);
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );

				    if($ioa_meta_data['background_image']!="")
				    {
				    	$ioa_meta_data['background_image'] = 'background-image:url('.$ioa_meta_data['background_image'].')';
				    }

		    		echo "<div class='full-width-image-wrap $pr ' style='".$ioa_meta_data['background_image'].";max-height:".$ioa_meta_data['height']."'  itemscope itemtype='http://schema.org/ImageObject'><img itemprop='url' height='".$ioa_meta_data['height']."' width='100%' src='".$ar[0]."' alt='featured image' /></div>";
		    		endif;
		    	   break;

		    	case 'image-parallex' :  
		    		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
		    		$id = get_post_thumbnail_id($post_ID);
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    		echo "<div class='full-width-image-wrap image-parallex ' style='height:".$ioa_meta_data['height']."px;background:url(".$ar[0].") left top no-repeat;background-attachment:fixed;background-size:cover'></div>";
		    		endif;
		    		break;	  
		    	
		    	case 'none-contained' :
		    		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
					$id = get_post_thumbnail_id($post_ID);
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    		echo "<div class='contained-image-wrap' itemscope itemtype='http://schema.org/ImageObject'><img itemprop='image' src='".$ar[0]."' alt='featured image' /></div>";  
		    		endif;
					 break;

				case 'proportional' :	 ?> 
						<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>
							
							<div class="single-image clearfix">
								<?php

								$id = get_post_thumbnail_id($post_ID);
							    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
								echo $ioa_helper->imageDisplay( array( "crop" => "wproportional", "src"=> $ar[0] ,"height" =>  $ioa_meta_data['height'] , "width" =>  $ioa_meta_data['width'] , "parent_wrap" => false ) );   
							 	?> 
							</div>
					 		
						<?php  endif;  		
		 
						break;
		    	case  "none-full" : 
					
		    	    if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
					$id = get_post_thumbnail_id($post_ID);
				    $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		    		echo "<div class='top-image-wrap' style='background-image:url(".$ioa_meta_data['background_image'].");' itemscope itemtype='http://schema.org/ImageObject'><img itemprop='image' src='".$ar[0]."' alt='featured image' /></div>";  
					endif;	
					 break;

				case  "slideshow" : ?> <div class="featured-gallery"> <?php  get_template_part("templates/post-featured-gallery"); ?> </div> <?php break;
				case  "slideshow-contained" : ?> <div class="featured-gallery featured-gallery-contained"> <?php $ioa_meta_data['width'] = $ioa_layout['content_width'];  get_template_part("templates/post-featured-gallery"); ?> </div> <?php break;

				case  "slideshow-fullscreen" : ?> <div class="featured-gallery featured-gallery-fullscreen"> 
							<?php   
									$ioa_meta_data['width'] = $ioa_layout['content_width']; 
									$ioa_meta_data['full_screen'] = true;  
									get_template_part("templates/post-featured-gallery"); 
							?> </div> <?php break;

				case  "slider" : ?> <div class="featured-slider"> <?php  get_template_part("templates/post-featured-slider"); ?> </div> <?php break;
				case  "slider-contained" : ?> <div class="featured-slider featured-slider-contained"> <?php $ioa_meta_data['width'] = $ioa_layout['content_width'];  get_template_part("templates/post-featured-slider"); ?> </div> <?php break;
				case  "slider-full" : ?> <div class="featured-slider featured-slider-full "  style='background-image:url(<?php echo $ioa_meta_data['background_image'] ?>);'> <?php $ioa_meta_data['full_width'] = true;  get_template_part("templates/post-featured-slider"); ?> </div> <?php break;


				case  "video" : ?>
					  <div class="video single-video">
                                   <?php $video =   $ioa_meta_data['featured_video'];  
                                   echo wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height'])); ?>
                               </div>  
					 <?php break;	 

		    	default : 
		    		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :
	  	    		    the_post_thumbnail(array($ioa_layout['content_width'],450));
  	    		    endif;
  	    	       break;
		    }


?>
</div>