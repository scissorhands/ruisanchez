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
$rad_attrs[] = 'class="'.$an.' rad-widget rad-button-widget"';

$link = '';

if($w['col_link']!="none")
{
	if($w['col_link']=="custom") $link = $w['custom_link'];
	else $link = get_permalink($w['col_link']);

}

$code= '';


if($w['radius']!="0") $code .= 'border-radius:'.$w['radius'].'px;';
if($w['button_color']!="") $code .= 'color:'.$w['button_color'].';';

if(trim($w['button_bgcolor'])!="") 
{
	$code .= 'background-color:'.$w['button_bgcolor'].';';
	$code .= 'border-color:'.adjustBrightness($w['button_bgcolor'],-15).';';
}

$rel ='';
if($w['col_link']=="video")
{
	 $link = $w['video_link'];
	 $rel = "data-rel='prettyphoto[pp_gal]'";
}

if($w['col_link']=="image")
{
	 $link = $w['image_link'];
	 $rel = "data-rel='prettyphoto[pp_gal]'";
}

 ?>

<?php if($w['label']!="") : ?>
<div <?php echo join(" ",$rad_attrs) ?>>
	<a href="<?php echo $link; ?>" <?php  if($w['new_window']=='yes') echo "target='_BLANK'";  echo $rel;  if($code!='') echo "style='".$code."'" ?> class="ioa-button <?php echo "style-".$w['button_style'].' size-'.$w['button_size']; if($w['t_icon']!='') echo ' has-icon ';  ?>">
			<?php if($w['t_icon']!='') echo '<i class="ioa-front-icon '.$w['t_icon'].'"></i>'; echo stripslashes($w['label']) ?>
	</a>
</div>
<?php endif; ?>

