<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$inner_wrap_classes = '';
$rad_attrs = array();

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none")  $rad_attrs[] = 'data-waycheck="'.$w['visibility'].'"';
if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

$way = '';
if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") $way = 'way-animated';
$rad_attrs[] = 'class=" props-wrapper clearfix page-rad-component rad-component-spacing  '.$way.'"';
$tab_data = array();
$tabs = array();

if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
	$tab_data = $w['rad_tab'];
	$tab_data = explode('<titan_module>',$tab_data);
	

	foreach ($tab_data as $key => $value) {
				
				if($value!="")
				{
					$inpval = array();
					$mods = explode('<inp>', $value);	
					
					foreach($mods as $m)
					{
						
						if($m!="")
						{
							$te = (explode('<s>',$m));
							if( count($te) == 1 ) $te = (explode(';',$m));  
							$inpval[$te[0]] =   $te[1]  ; 
							
						}

						
					}
					//$ioa_helper->prettyPrint($inpval);

					$tabs[] = $inpval;
				}	
		}
endif;			

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="props-inner-wrap" >
		
		
		<?php 
			$i=0;  
			$shortcode = '[props width="'.$w['width'].'" height="'.$w['height'].'" ]' ;
			foreach ($tabs as  $prop) {
 					$shortcode .= '[prop left="'.$prop['p_left'].'" top="'.$prop['p_top'].'" delay="'.$prop['p_delay'].'" image="'.$prop['p_upload'].'" effect="'.$prop['p_animation'].'" ][/prop]';
 			} 
 			$shortcode .= '[/props]'; echo do_shortcode($shortcode); 
 			?>


	
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>