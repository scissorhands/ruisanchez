<?php 
/**
 * Text Template for RAD BUILDER
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

 ?>

<div <?php echo join(" ",$rad_attrs) ?> style="padding:<?php if(isset($w['vspace']) && $w['vspace']!="0") echo $w['vspace']."px 0";  ?>">
	<div class="divider <?php echo $w['divider_style'] ?>"  >
	</div>
</div>

