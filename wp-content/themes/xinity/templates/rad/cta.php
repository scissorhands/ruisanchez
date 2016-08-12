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

<div <?php echo join(" ",$rad_attrs) ?>>
	<div  itemscope itemtype="http://schema.org/Thing" class="cta-inner-wrap <?php echo $w['cta_style'] ?> clearfix ">
		
			<?php if($w['cta_style']=='center') : ?>
				<span class="hline"></span>
			<?php endif; ?>

			<div class="cta-heading" >
				<h3><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h3>
				<h5><?php echo $ioa_helper->format($w['subtext_title'],true,false,false); ?></h5>
				
				<?php if($w['cta_style']=='image-box' && (isset($w['button_link']) && $w['button_link']!="") ): ?>
				<a class='cta_button <?php if(trim($w['t_icon'])=="") echo 'no-icon-button'; if(isset($w['cta_button_classes'])) echo ' '.$w['cta_button_classes']; ?>' itemprop="url"  href="<?php if(isset($w['button_link']) && $w['button_link']!="") echo $w['button_link'] ?>"> 
					<span class="liner"></span>
					<span class="cta-button-label">
						<?php if(isset($w['cta_button']) && $w['cta_button']!="") echo stripslashes($w['cta_button']) ?>
					</span>
					<?php if ($w['t_icon']!=""): ?>
					<span class="cta-icon <?php echo $w['t_icon'] ?>"></span>
						<?php endif; ?>	
				</a>
				<?php endif; ?>

			</div>	
			

			
			<?php if($w['cta_style']!='image-box' && (isset($w['button_link']) && $w['button_link']!="")): ?>
			<a class='cta_button <?php if(trim($w['t_icon'])=="") echo 'no-icon-button'; if(isset($w['cta_button_classes'])) echo ' '.$w['cta_button_classes']; ?>' itemprop="url"  href="<?php if(isset($w['button_link']) && $w['button_link']!="") echo $w['button_link'] ?>"> 
				<span class="liner"></span>
				<span class="cta-button-label">
					<?php if(isset($w['cta_button']) && $w['cta_button']!="") echo stripslashes($w['cta_button']) ?>
				</span>
				<?php if ($w['t_icon']!=""): ?>
				<span class="cta-icon <?php echo $w['t_icon'] ?>"></span>
					<?php endif; ?>	
			</a>
			<?php endif; ?>
		
		
	</div>
</div>

