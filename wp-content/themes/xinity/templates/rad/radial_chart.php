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
$rad_attrs[] = 'class="'.$an.' rad-widget"';


if(!isset($w['w'])) $w['w'] = '';
if(!isset($w['width'])) $w['width'] =350;
if(!isset($w['label'])) $w['label'] ="Label";

if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
	$w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}
 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="radial_chart-inner-wrap" >
		
			<?php echo do_shortcode("[radialchart size='".$w['size']."' width='".$w['width']."'  percent='".$w['value']."' bar_color='".trim($w['bar_color'])."' ] ".stripslashes($w['label'])."[/radialchart] "); ?>
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
			
	</div>
</div>

