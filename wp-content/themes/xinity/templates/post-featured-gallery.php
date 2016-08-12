<?php
/**
 * Featured Gallery for Pages & Posts
 */
global $ioa_helper,$ioa_meta_data,$ioa_super_options;

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
if($ioa_options == "")
$ioa_options = array();
          

if(isset( $ioa_options['ioa_gallery_data'] )) $gallery_images =  $ioa_options['ioa_gallery_data'];
$cl = ''


?>

<div class="ioa-gallery seleneGallery " itemscope itemtype="http://schema.org/ImageGallery"  data-thumbnails="<?php if(!isset($ioa_meta_data['full_screen'])) echo 'true'; else echo 'false'; ?>" data-autoplay="false" data-effect_type="fade" data-caption="false" <?php if(isset($ioa_meta_data['full_screen'])) echo "data-fullscreen='true'" ?> data-arrow_control="true" data-duration="5" data-height="<?php  echo $ioa_meta_data['height']; ?>"  data-width="<?php echo $ioa_meta_data['width']; ?>" > 
                <div class="gallery-holder" style="height:<?php echo $ioa_meta_data['height']; ?>px;">
					<?php if(isset($gallery_images) && trim($gallery_images) != "" ) : $ar = explode(";",stripslashes($gallery_images));
						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("[ioabre]",$image);

							
						 ?>
						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>">
                      		<?php 

                      		if(!isset($ioa_meta_data['full_screen']))
                      		echo $ioa_helper->imageDisplay(array( "src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] )); 
                      		else
                      			echo "<img src='".$g_opts[0]."' alt='".$g_opts[2]."' />";

                      		if($post->post_type == 'product') :
                      		?> 
                      			<a href="<?php echo $g_opts[0] ?>" data-rel="prettyphoto[gallery-<?php echo get_the_ID(); ?>]" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
                     		 <?php endif; ?>

                     		 <div class="gallery-desc">
                         	 	<h2 itemprop='name'><?php echo $g_opts[3] ?></h2>
                         	 	<div itemprop='description' class="caption"><?php echo $g_opts[4] ?></div>
                         	 </div>  
                  		 </div>	
					<?php 
						endif;
					endforeach; endif; ?>
				</div>
			</div>