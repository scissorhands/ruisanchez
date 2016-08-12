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
$rad_attrs[] = 'class=" '.$an.' blockquote-wrap rad-widget"';



?> 


<div <?php echo join(" ",$rad_attrs) ?>>
	
	 <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    <?php endif; ?>
	
	<blockquote>

		<?php echo do_shortcode($w['text_data']) ?>
	</blockquote>

	<div class="bottom-quote-wrap clearfix">
			<span class="author-preffix"><?php echo stripslashes($w['author_preffix']) ?></span>	
			<span class="author-name"><?php echo stripslashes($w['author_name']) ?></span>	
	</div>

</div>
