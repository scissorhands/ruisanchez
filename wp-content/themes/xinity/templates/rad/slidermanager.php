<?php 
/**
 * Text Template for RAD BUILDER
 * Generates Column From Singular Shortcodes
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';

if($w['visibility']!='none')
{
	 $an .= 'way-animated '.$w['visibility'];
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';



?> 


<div <?php echo join(" ",$rad_attrs) ?>>
	
	 <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>

		<div class="slider-area">
			<?php echo do_shortcode("[slider id='".$w['slideshow']."']"); ?>
		</div>
		
</div>

