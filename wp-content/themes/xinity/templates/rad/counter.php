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


if(!isset($w['w'])) $w['w'] = '';
if(!isset($w['label'])) $w['label'] ="Label";

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="counter-inner-wrap" >
		
		 <div class="counter"  data-end='<?php echo $w['end'] ?>' data-step='<?php echo $w['step'] ?>' data-time='<?php echo $w['time'] ?>'  data-start='<?php echo $w['start'] ?>'   ><?php echo $w['start'] ?></div>

		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php if($w['t_icon']!='') echo '<i class="ioa-front-icon '.$w['t_icon'].'"></i>'; echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
			
	</div>
</div>

