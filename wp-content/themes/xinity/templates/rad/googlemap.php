<?php 
/**
 * Tabs Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];


$rad_attrs = array();
$an = '';
if( isset($w['visibility']) && $w['visibility']!='none')
{
	 $an = 'way-animated';
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';


$tab_data = array();
$tabs = array();

if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
	$tab_data = $w['rad_tab'];
	$tab_data = explode('[ioa_mod]',$tab_data);
	

	foreach ($tab_data as $key => $value) {
				
				if($value!="")
				{
					
					$mods = explode('[inp]', $value);	
					
					foreach($mods as $m)
					{
						
						if($m!="")
						{
							$te = (explode('[ioas]',$m));  
							if( count($te) == 1 ) $te = (explode(';',$m));  
							
							if(isset($te[1]))
							$inpval =   $te[1]  ; 
							
						}

						
					}
					//$ioa_helper->prettyPrint($inpval);

					$tabs[] = '"'.$inpval.'"';
				}	
		}
endif;			



 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class=" googlemap-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
		

		<div class="google_map rad_google_map clearfix " style="height:<?php echo $w['height'] ?>px" id="<?php echo 'map-'.$ioa_meta_data['widget']['id'] ?>"  data-zoom="<?php echo $w['map_zoom'] ?>" data-hue="<?php echo $w['map_color'] ?>" data-marker="<?php echo $w['map_marker'] ?>" >
      <textarea name="" id="" cols="30" rows="10"><?php echo join('[r_mp]',$tabs); ?></textarea>
    </div>
	
	</div>

</div>

<?php if(!isset($ioa_meta_data['google_inc'])) 
  {
    echo "<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?sensor=true'></script>";
    $ioa_meta_data['google_inc'] = true;
  }
 ?>
  

