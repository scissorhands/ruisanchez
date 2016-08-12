<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug;

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

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="<?php if(isset($w['col_alignment'])) echo "col-".$w['col_alignment'] ?> intro_title-inner-wrap">
	
			
			<div class="intro_title-title-inner-wrap clearfix"  itemscope itemtype="http://schema.org/Thing">
				<?php if(isset($w['text_title']) && $w['text_title']!="") : ?><h2 itemprop="name" class=""><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2><?php endif; ?>
				<?php if(isset($w['text_subtitle']) && $w['text_subtitle']!="" ) : ?><div itemprop="description" class="text_subtitle  "><?php echo $ioa_helper->format($w['text_subtitle'],true,false,false); ?></div><?php endif; ?>

				<?php if(isset($w['divider_toggle']) && $w['divider_toggle']=='yes') echo "<div class='clearfix'><div class='mini-divider'></div></div>"; ?>
			</div>	

		
	</div>
</div>

