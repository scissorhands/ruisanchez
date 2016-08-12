<?php 
/**
 * gallery Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
if($w['visibility']!='none')
{
	 $an = 'way-animated';
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';

if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
	$w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>

	<div class="gallery-inner-wrap">
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
	
		
		<div class="gallery-data "  itemscope itemtype="http://schema.org/ImageGallery" >
			
			<div class="ioa-gallery seleneGallery " data-effect_type="fade" data-thumbnails="<?php echo $w['bullets'] ?>" data-autoplay="<?php echo $w['autoplay'] ?>" data-caption="<?php echo $w['captions'] ?>" data-arrow_control="<?php echo $w['arrow_control'] ?>" data-duration="<?php echo $w['duration'] ?>" data-height="<?php if(isset($w['height'])) echo $w['height']; else '300'; ?>"  data-width="<?php if(isset($w['width'])) echo $w['width']; else '450'; ?>" > 
                <div class="gallery-holder">
					<?php if(isset($w['gallery_images']) && trim($w['gallery_images']) != "" ) : $ar = explode(";",stripslashes($w['gallery_images']));
						

						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("<<",$image);
							if(trim($g_opts[0])!="") :
 						 ?>
						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>">
                      		
                      		<?php 
                      		
                      		switch ($w['image_resize']) {
                      			case 'default': echo $ioa_helper->imageDisplay(array( "src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $w['width'] , "height" => $w['height'] )); break;
                      			case 'hard' : echo $ioa_helper->imageDisplay(array( "crop" => "hproportional" , "src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $w['width'] , "height" => $w['height'] )); break;
                      			case 'none' : 
                      			default:
                      				echo "<img src='".$g_opts[0]."' alt='".$g_opts[2]."' />";
                      				break;
                      		}
                      		 ?> 


                     		 <div class="gallery-desc">
                         	 	<h2 itemprop="name"><?php echo $g_opts[3] ?></h2>
                         	 	<div class="caption" itemprop="description"><?php echo $g_opts[4] ?></div>
                         	 </div> 
							
							<?php 
							if($w['lightbox'] == 'true') :
							 ?>
							<a href="<?php echo $g_opts[0] ?>" title='<?php echo $g_opts[3]; ?>' data-rel="prettyphoto[<?php echo $ioa_meta_data['widget']['id'] ?>]" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a> 
						<?php endif; ?>

                  		 </div>	
					<?php 
						endif; endif;
					endforeach; endif; ?>
				</div>

			</div>

		</div>

		
	</div>
</div>

