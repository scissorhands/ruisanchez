<?php 
/**
 * Thumbnails Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
if($w['visibility']!='none')
{
	 $an = 'way-animated';
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}

if( isset($w['chainability']) && $w['chainability']!='none' )
{
  $an .= ' chain-animated chain-'.$w['chainability'];
  $rad_attrs[] = 'data-chain="'.$w['chainability'].'"';
}

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>

	<div class="thumbnail-inner-wrap">
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
	
		
		<ul class="thumnails-data clearfix"  itemscope itemtype="http://schema.org/ImageGallery" >
					<?php if(isset($w['gallery_images']) && trim($w['gallery_images']) != "" ) : $ar = explode(";",stripslashes($w['gallery_images']));
						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("<<",$image);
							if(trim($g_opts[0])!="") :
 						 ?>
						 <li class="gallery-item chain-link">
                      		
                      		<?php  echo $ioa_helper->imageDisplay(array( "src" =>$g_opts[0] , 'imageAttr' =>  ' ' , "width" => $w['th_width'] , "height" => $w['th_height'] , "lightbox" => true , 'gallery' => $ioa_meta_data['widget']['id'] )); ?> 

                  		 </li>	
					<?php 
						endif; endif;
					endforeach; 
					endif; ?>
		</ul>

		
	</div>
</div>

