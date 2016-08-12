<?php 
/**
 * Text Template for RAD BUILDER
 * Generates Column From Singular Shortcodes
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';

if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';

if(strpos($w['icon'],"default") > 0 ) $an .= ' default-icon ';
if($w['col_style']=='left-icon' || $w['col_style']=='right-icon') $an .= ' icon-col-layout ';

if($w['visibility']!='none')
{
	 $an .= 'way-animated '.$w['visibility'];
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';

$rad_attrs[] = 'class="'.$an.' rad-widget"';

$link = '';

if($w['col_link']!="none")
{
	if($w['col_link']=="custom") $link = $w['custom_link'];
	else $link = get_permalink($w['col_link']);

}
if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
	$w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}
$m = '';

if($w['col_link']=="video")
{
	 $m = $w['video_link']; $link = 'video';
}

if($w['col_link']=="image")
{
	 $m = $w['image_link']; $link = 'image';
}

?> 


<div <?php echo join(" ",$rad_attrs) ?>>
	
<?php 
$code ='';
$rel = '';
$button_link = '';
$button_label = __('More','ioa');
$content = $ioa_helper->format($w['text_data'],false,true);
$icon = do_shortcode($w['icon']);
$image = $w['top_image'];
$col_style = $w['col_style'];
if($w['button_label']!="") $button_label = $w['button_label'];

if($link=="video")
{
   $link = $m;
   $rel = "data-rel='prettyphoto[pp_gal]'";
}

if($link=="image")
{
   $link = $m;
   $rel = "data-rel='prettyphoto[pp_gal]'";
}
if($link!="") $button_link = "<a href='$link' class='ioa-more-button' $rel> ".$w['button_label']." <i class='angle-righticon- ioa-front-icon'></i></a>";

$c_title = '';
$c_subtitle = '';
$c_text = '';
$icon_area = '';

if($w['text_title']!="") $c_title = "<h2 class='text-title'>".$w['text_title']."</h2>";
if($w['text_subtitle']!="") $c_subtitle = "<h4 class='text-subtitle'>".$w['text_subtitle']."</h4>";
if($content!="") $c_text = "<div class='ioa-text clearfix'>$content</div>";

if($icon!="")
$icon_area = "<div class='ioa-icon-area' style='margin-top:".$w['icon_margin']."'> $icon  </div>";

$img = '';


if($col_style=='image-box' && $image!="" ) 
 {
   $attr = " alt='".$w['text_title']."' ";
 
    switch ($w['image_resize']) {
      case 'none': $img = " <img src='".$image."' alt='".$w['text_title']."' height='".$w['height']."' width='".$w['width']."' /> ";  break;
      
      case 'default': $img = $ioa_helper->imageDisplay(array( "src" =>$image , 'imageAttr' =>  $attr, "parent_wrap" => false , "width" => $w['width'] , "height" => $w['width'] )); break;
     case 'hard' : $img = $ioa_helper->imageDisplay(array( "crop" => "hproportional" , "src" =>$image , 'imageAttr' =>  $attr, "parent_wrap" => false , "width" => $w['width'] , "height" => $w['width'] )); break;
      default:
        # code...
        break;
    }
    $icon_area = "<div class='ioa-image-area '> $img</div>";
 }

$a_start = $a_end = '';

if($col_style == 'boxed' && $link!='none' && $link!='')
{
  $a_start = "<a href='$link' class='' $rel>";
  $a_end = "</a>";
}

if($col_style !='iconed-alt') :
$code = "<div class='ioa-text-column $col_style clearfix'>$a_start
      $icon_area
      <div class='ioa-text-area'>
        $c_title
        $c_subtitle
        $c_text
        $button_link
      </div>
     $a_end</div>";
else :
$code = "<div class='ioa-text-column $col_style clearfix'>
        
        <div class='front-view'>
              $icon_area
              $c_title
        </div>
        <div class='alt-desc'>
           <div class='alt-inner-desc'>
               $c_title
               $c_subtitle
               $c_text
               $button_link
           </div> 
        </div>
     </div>";
endif;

echo $code;
?>

</div>