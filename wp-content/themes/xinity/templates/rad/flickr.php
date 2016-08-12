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

if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
	$w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>

	<div class="flickr-inner-wrap">
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; 
	
		
		$username = $w['username'];
	    $api_key = $w['api_key'];
		$nos = $w['nos'];



		

		 if($api_key == "") { echo '<h4> No API KEY ADDED </h4>'; } else {

		 $images = get_transient(SN."_".$username."fp");	
		 include(HPATH."/lib/phpFlickr.php");	
		 	
		 $f = new phpFlickr($api_key);
		 if(!$images) :

		  
		  	$person = $f->people_findByUsername($username);
		  	$photos_url = $f->urls_getUserPhotos($person['id']);
		 	$photos = $f->people_getPublicPhotos($person['id'], NULL, NULL, 16);
		 	$images = (array)$photos['photos']['photo'];
			set_transient(SN."_".$username."fp",$images,60 * 60 * 24 * 7);

		endif;


			?>
		    
		    <div class="flickr-pictures clearfix">
		        <?php
				$i=0;
		         foreach ($images as $photo) {

				  if($i>=$nos) break;

				  $theImageSrc = $f->buildPhotoURL($photo, "thumbnail");
				  $lb = $f->buildPhotoURL($photo, "large");

		    	  echo "<a href='".($lb)."' class=' chain-link' data-rel='prettyPhoto[pp_gal]' title='$photo[title]' ><img src='".($theImageSrc)."' alt='' title='' /></a>";
				  $i++;
		  		}

			?>
       		 </div>
        <?php } ?>

		
	</div>
</div>

