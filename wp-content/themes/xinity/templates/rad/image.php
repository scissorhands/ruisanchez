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

if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
	$w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="image-inner-wrap">
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
		<?php echo do_shortcode("[image effect_delay='".$w['delay']."' lightbox='".$w['lightbox']."' src='".$w['image']."' effect='".$w['visibility']."'  resize='".$w['resizing']."'  link='".$w['link']."' width='".$w['width']."' height='".$w['height']."' /]"); ?>
		<?php if(isset($w['text_caption']) && $w['text_caption']!="") : ?><h4 itemprop="description" class=" text_caption custom-font1"><?php echo $ioa_helper->format($w['text_caption'],true,false,false); ?></h4><?php endif; ?>
	</div>
</div>
