<?php 
/**
 * HTMl Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
$col_align = 'col-align-'.$w['col_align'];


if($w['visibility']!='none')
{
	 $an = 'way-animated';
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$col_align.' '.$an.' rad-widget"';

?> 


<div <?php echo join(" ",$rad_attrs) ?>>
	
<?php 
$code ='';
$content = $ioa_helper->format($w['text_data'],false,true);


$c_title = '';
$c_subtitle = '';
$c_text = '';


if($w['text_title']!="") $c_title = "<h2 class='text-title'>".$w['text_title']."</h2>";
if($w['text_subtitle']!="") $c_subtitle = "<h4 class='text-subtitle'>".$w['text_subtitle']."</h4>";
if($content!="") $c_text = "<div class='ioa-text clearfix'>$content</div>";

$code = "<div class='ioa-text-column clearfix'>
      <div class='ioa-text-area'>
        $c_title
        $c_subtitle
        $c_text
      </div>
     </div>";

echo $code;
?>

</div>
