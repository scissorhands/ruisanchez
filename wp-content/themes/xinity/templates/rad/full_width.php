<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['inputs']; 

$hidden_data = $ioa_helper->getAssocMap($w,'hidden');
$w = $ioa_helper->getAssocMap($w,'value'); // $ioa_helper->prettyPrint($w);



$col =$ioa_meta_data['widget']['layout'];

$layout_type = 'full_width';

if(isset($ioa_meta_data['rad_layout'])) 
{
	switch($col)
	{
		case '100%' : $layout_type = 'full_width left' ; break;
		case '75%' : $layout_type = 'three_fourth left' ; break;
		case '66%' : $layout_type = 'two_third left' ; break;
		case '50%' : $layout_type = 'one_half left' ; break;
		case '33%' : $layout_type = 'one_third left' ; break;
		case '25%' : $layout_type = 'one_fourth left' ; break;

	}


}


$inner_wrap_classes = '';


// Get keys ==== 
$keys = implode(',',$radunits[$ioa_meta_data['widget']['type']]->getInputKeys());
$h = '';

$joint = strtolower( str_replace(" ","_",trim($ioa_meta_data['widget']['type']) ) );

 ?>


<div data-type="<?php echo $ioa_meta_data['widget']['type']; ?>" id="<?php if(isset($ioa_meta_data['id'])) echo $ioa_meta_data['id']; ?>" data-fields="<?php echo $keys; ?>" class="<?php echo $joint ?>-wrapper page-rad-component rad-component-spacing   clearfix">
	
	<div class="curtain <?php  if(isset($ioa_meta_data['state']) && $ioa_meta_data['state'] == "live" ) echo 'hide'; ?>"> <h4><?php echo str_replace("_"," ",$ioa_meta_data['widget']['type']) ?>  <span><?php _e('(Drag to Arrange)','ioa') ?></span> </h4> </div> 
	
	<div class="<?php echo $joint ?>-inner-wrap <?php echo $inner_wrap_classes; ?> " >
		
		<div class="text text_data <?php echo $hidden_data['text_data']; ?>">
			<?php echo $ioa_helper->format($w['text_data'],false,false); ?>
		</div>
	</div>

</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>