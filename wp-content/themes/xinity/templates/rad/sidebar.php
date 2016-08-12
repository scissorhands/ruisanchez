<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];


$rad_attrs = array();
$an = '';
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>	
  <div class="sidebar-inner-wrap clearfix">
	
	
	<div class="sidebar <?php if(isset($w['sidebar_behavior'])) echo $w['sidebar_behavior']; ?>"  itemscope itemtype="http://schema.org/WPSideBar">
		<?php 
	 	if ( isset($w['sidebar_v']) && trim($w['sidebar_v'])!=""  ) {
			dynamic_sidebar ($w['sidebar_v']); 
		}
		else  {
		 	dynamic_sidebar ("Blog Sidebar"); 
		}
	
	?>  
	</div>
	</div>
	
</div>

