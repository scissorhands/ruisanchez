<?php 
/**
 * gallery Template for RAD BUILDER
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
$rad_attrs[] = 'class="'.$an.' rad-widget scrollable-wrapper"';

$margin = 20;
if(isset($w['margin'])) $margin = $w['margin'];


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>  
  <div class="scrollable-inner-wrap">

   <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>

    <?php  echo do_shortcode("[post_scrollable margin='".$margin."' width='".$w['width']."' height='".$w['height']."' ioa_query='".$w['posts_query']."' no='".$w['no_of_posts']."'  post_type='".$w['post_type']."' ]"); ?>   

    
  </div>

</div>
