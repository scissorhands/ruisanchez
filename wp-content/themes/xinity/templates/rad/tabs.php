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
					$inpval = array('id' => uniqid('ioa_tab_'));
					$mods = explode('[inp]', $value);	
					
					foreach($mods as $m)
					{
						
						if($m!="")
						{
							$te = (explode('[ioas]',$m));  
							if( count($te) == 1 ) $te = (explode(';',$m));  
							
							if(isset($te[1]))
							$inpval[$te[0]] =   $te[1]  ; 
							
						}

						
					}
					//$ioa_helper->prettyPrint($inpval);

					$tabs[] = $inpval;
				}	
		}
endif;			

if( ! isset($w['tab_orientation'])) $w['tab_orientation'] = "left";



 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class=" tabs-align-<?php echo $w['tab_orientation']; ?> tabs-style-<?php echo $w['tab_style']; ?> tabs-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
		

		<div class="ioa_tabs clearfix ">
  		
		<?php if( $w['tab_orientation']!="bottom") : ?>
  			<ul class='clearfix'>
    
 				<?php $i=0; foreach ($tabs as  $tab) {
  				$icon = '';
  				if(isset($tab['tab_icon'])) 
  					$icon = "<i class='icon ".$tab['tab_icon']."'></i>";

 					echo '<li class="ui-state-default ui-corner-top "><a itemprop="name" href="#'.$tab['id'].'" >'.$icon.' '.stripslashes($tab['tab_title']).'</a></li>';
 				} ?>
 			</ul>
 		<?php endif; ?>
		
		<?php $i=0; foreach ($tabs as  $tab) {
 					echo '<div class="clearfix ui-tabs-panel nested" id="'.$tab['id'].'" itemprop="description">'.$ioa_helper->format($tab['tab_text']).'</div>';
 				
 			} ?>

		<?php if( $w['tab_orientation']=="bottom") : ?>
  			<ul class='clearfix'>
    
 				<?php $i=0; foreach ($tabs as  $tab) {
 					$icon = '';
  				if(isset($tab['tab_icon'])) 
  					$icon = "<i class='icon ".$tab['tab_icon']."'></i>";
  				
 					echo '<li class="ui-state-default ui-corner-top "><a itemprop="name" href="#'.$tab['id'].'" >'.$icon.' '.stripslashes($tab['tab_title']).'</a></li>';
 				} ?>
 			</ul>
 		<?php endif; ?>
  
		</div>

	
	</div>
</div>

