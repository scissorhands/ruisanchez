<?php 
/**
 * HTMl Text Template for RAD BUILDER
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

if(isset($w['type']) && $w['type']!='rad_notification_widget')
	$w['c_type']  = $w['type'];

?> 


<div <?php echo join(" ",$rad_attrs) ?>>
	
	 <div class="ioa-message <?php echo 'message-'.$w['c_type'] ?>">
	 	<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
     		 <h2 itemprop="name" class="message-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
   	    <?php endif; ?>

		<div class='message-content'>
			<?php echo do_shortcode($w['text_data']) ?>
			<?php if($w['t_icon']!="") : ?><i class="notify-icon ioa-front-icon <?php echo $w['t_icon'] ?>"></i><?php endif; ?>
		</div>

	 </div>


</div>
